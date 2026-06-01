<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class ImageWatermarker
{
    /**
     * Watermark a file stored on a Laravel disk (e.g. Filament FileUpload paths
     * like slides/foo.jpg). Idempotent via a sibling ".wm" marker file.
     * Returns true if it stamped the image this call.
     */
    public function stampDiskImage(string $relativePath, string $disk = 'public', bool $force = false): bool
    {
        if (! $relativePath) {
            return false;
        }

        $absolute = Storage::disk($disk)->path($relativePath);
        $marker = $absolute.'.wm';

        if (! $force && is_file($marker)) {
            return false;
        }

        if (! $this->stamp($absolute)) {
            return false;
        }

        @file_put_contents($marker, '');

        return true;
    }

    /**
     * Stamp the configured text diagonally and tiled across the image,
     * overwriting the file in place. Returns true if applied.
     */
    public function stamp(string $path): bool
    {
        if (! config('watermark.enabled')) {
            return false;
        }

        $font = config('watermark.font');
        if (! is_file($path) || ! is_file($font)) {
            return false;
        }

        $info = @getimagesize($path);
        if ($info === false) {
            return false;
        }
        [$w, $h] = $info;
        $type = $info[2];

        $img = $this->createFrom($path, $type);
        if ($img === null) {
            return false;
        }

        imagealphablending($img, true);

        $text = (string) config('watermark.text');
        $angle = (float) config('watermark.angle');
        $short = min($w, $h);
        $fontSize = max(11, (int) round($short * (float) config('watermark.font_scale')));

        $hex = ltrim((string) config('watermark.color'), '#');
        $r = (int) hexdec(substr($hex, 0, 2));
        $g = (int) hexdec(substr($hex, 2, 2));
        $b = (int) hexdec(substr($hex, 4, 2));
        $opacity = max(0.0, min(1.0, (float) config('watermark.opacity')));
        $gdAlpha = (int) round((1 - $opacity) * 127); // 0 = opaque, 127 = transparent

        $textColor = imagecolorallocatealpha($img, $r, $g, $b, $gdAlpha);
        $shadowColor = imagecolorallocatealpha($img, 0, 0, 0, min(127, $gdAlpha + 30));

        // Tile across a grid; offset rows so repeats interlock.
        $box = imagettfbbox($fontSize, $angle, $font, $text);
        $textW = abs($box[2] - $box[0]);
        $stepX = max(80, $textW + (int) round($short * (float) config('watermark.gap_scale', 0.10)));
        $stepY = max(60, (int) round($short * (float) config('watermark.tile_scale')));

        $row = 0;
        for ($y = $stepY; $y < $h + $stepY; $y += $stepY) {
            $offset = ($row % 2) * (int) round($stepX / 2);
            for ($x = -$stepX + $offset; $x < $w + $stepX; $x += $stepX) {
                imagettftext($img, $fontSize, $angle, $x + 1, $y + 1, $shadowColor, $font, $text);
                imagettftext($img, $fontSize, $angle, $x, $y, $textColor, $font, $text);
            }
            $row++;
        }

        return $this->save($img, $path, $type);
    }

    private function createFrom(string $path, int $type): ?\GdImage
    {
        $img = match ($type) {
            IMAGETYPE_JPEG => @imagecreatefromjpeg($path),
            IMAGETYPE_PNG => @imagecreatefrompng($path),
            IMAGETYPE_GIF => @imagecreatefromgif($path),
            IMAGETYPE_WEBP => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($path) : false,
            default => false,
        };

        return $img instanceof \GdImage ? $img : null;
    }

    private function save(\GdImage $img, string $path, int $type): bool
    {
        return match ($type) {
            IMAGETYPE_JPEG => imagejpeg($img, $path, 88),
            IMAGETYPE_PNG => $this->savePng($img, $path),
            IMAGETYPE_GIF => imagegif($img, $path),
            IMAGETYPE_WEBP => function_exists('imagewebp') ? imagewebp($img, $path, 88) : false,
            default => false,
        };
    }

    private function savePng(\GdImage $img, string $path): bool
    {
        imagealphablending($img, false);
        imagesavealpha($img, true);

        return imagepng($img, $path);
    }
}
