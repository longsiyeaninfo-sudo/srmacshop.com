<?php

namespace App\Console\Commands;

use App\Models\HomePromoCard;
use App\Models\HomeSlide;
use App\Services\ImageWatermarker;
use Illuminate\Console\Command;
use Spatie\MediaLibrary\Conversions\FileManipulator;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class WatermarkExistingImages extends Command
{
    protected $signature = 'images:watermark
        {--collection= : Limit media-library processing to one collection (default: all)}
        {--force : Re-stamp images already marked as watermarked}';

    protected $description = 'Stamp the watermark onto existing images (media library + slides + promo cards)';

    public function handle(ImageWatermarker $watermarker, FileManipulator $fileManipulator): int
    {
        $force = (bool) $this->option('force');
        $done = 0;
        $skipped = 0;

        // 1. Media-library images (product galleries, trade-in photos, …)
        Media::query()
            ->when($this->option('collection'), fn ($q, $c) => $q->where('collection_name', $c))
            ->chunkById(50, function ($media) use ($watermarker, $fileManipulator, $force, &$done, &$skipped) {
                foreach ($media as $item) {
                    if (! str_starts_with((string) $item->mime_type, 'image/')) {
                        $skipped++;
                        continue;
                    }
                    if ($item->getCustomProperty('watermarked') && ! $force) {
                        $skipped++;
                        continue;
                    }
                    if (! $watermarker->stamp($item->getPath())) {
                        $skipped++;
                        continue;
                    }

                    $item->setCustomProperty('watermarked', true)->save();
                    $fileManipulator->createDerivedFiles($item);
                    $done++;
                }
            });

        // 2. Loose public-disk uploads (homepage slides + social promo cards)
        foreach ([HomeSlide::class, HomePromoCard::class] as $model) {
            $model::query()->whereNotNull('image_path')->each(
                function ($record) use ($watermarker, $force, &$done, &$skipped) {
                    if ($watermarker->stampDiskImage($record->image_path, 'public', $force)) {
                        $done++;
                    } else {
                        $skipped++;
                    }
                }
            );
        }

        $this->info("Watermarked: {$done}   Skipped: {$skipped}");

        return self::SUCCESS;
    }
}
