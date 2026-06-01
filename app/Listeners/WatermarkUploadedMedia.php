<?php

namespace App\Listeners;

use App\Services\ImageWatermarker;
use Spatie\MediaLibrary\Conversions\FileManipulator;
use Spatie\MediaLibrary\MediaCollections\Events\MediaHasBeenAddedEvent;

class WatermarkUploadedMedia
{
    public function __construct(
        private ImageWatermarker $watermarker,
    ) {}

    public function handle(MediaHasBeenAddedEvent $event): void
    {
        $media = $event->media;

        if ($media->getCustomProperty('watermarked')) {
            return;
        }
        if (! str_starts_with((string) $media->mime_type, 'image/')) {
            return;
        }

        if (! $this->watermarker->stamp($media->getPath())) {
            return;
        }

        $media->setCustomProperty('watermarked', true)->save();

        // Re-derive conversions (thumb) from the now-watermarked original.
        app(FileManipulator::class)->createDerivedFiles($media);
    }
}
