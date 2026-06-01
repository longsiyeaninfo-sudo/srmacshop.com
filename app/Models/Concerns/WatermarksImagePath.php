<?php

namespace App\Models\Concerns;

use App\Services\ImageWatermarker;

/**
 * Auto-watermarks an `image_path` upload (stored on the public disk) whenever it
 * changes. For models whose images bypass the media library (Filament FileUpload).
 */
trait WatermarksImagePath
{
    public static function bootWatermarksImagePath(): void
    {
        static::saved(function ($model): void {
            // wasChanged() is false on a fresh insert, so check creation too.
            if (! $model->wasRecentlyCreated && ! $model->wasChanged('image_path')) {
                return;
            }

            if ($path = $model->image_path) {
                app(ImageWatermarker::class)->stampDiskImage($path);
            }
        });
    }
}
