<?php

namespace App\Console\Commands;

use App\Services\ImageWatermarker;
use Illuminate\Console\Command;
use Spatie\MediaLibrary\Conversions\FileManipulator;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class WatermarkExistingImages extends Command
{
    protected $signature = 'images:watermark
        {--collection= : Limit to one media collection (default: all collections)}
        {--force : Re-stamp images already marked as watermarked}';

    protected $description = 'Stamp the watermark onto existing media images';

    public function handle(ImageWatermarker $watermarker, FileManipulator $fileManipulator): int
    {
        $query = Media::query()
            ->when($this->option('collection'), fn ($q, $c) => $q->where('collection_name', $c));

        $total = $query->count();
        if ($total === 0) {
            $this->info('No media found.');

            return self::SUCCESS;
        }

        $bar = $this->output->createProgressBar($total);
        $bar->start();
        $done = 0;
        $skipped = 0;

        $query->chunkById(50, function ($media) use ($watermarker, $fileManipulator, $bar, &$done, &$skipped) {
            foreach ($media as $item) {
                $bar->advance();

                if (! str_starts_with((string) $item->mime_type, 'image/')) {
                    $skipped++;
                    continue;
                }
                if ($item->getCustomProperty('watermarked') && ! $this->option('force')) {
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

        $bar->finish();
        $this->newLine(2);
        $this->info("Watermarked: {$done}   Skipped: {$skipped}   Total: {$total}");

        return self::SUCCESS;
    }
}
