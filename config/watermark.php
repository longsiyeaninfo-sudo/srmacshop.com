<?php

return [
    // Master switch. Set WATERMARK_ENABLED=false in .env to disable.
    'enabled' => env('WATERMARK_ENABLED', true),

    // Text stamped across images.
    'text' => env('WATERMARK_TEXT', '098 334 755'),

    // Absolute path to a TrueType font (GD requires one for sized/angled text).
    'font' => resource_path('fonts/watermark.ttf'),

    // White text, opacity 0..1. Lower = more subtle.
    'color' => env('WATERMARK_COLOR', 'ffffff'),
    'opacity' => (float) env('WATERMARK_OPACITY', 0.30),

    // Diagonal angle of the repeated text.
    'angle' => 28,

    // Font size as a fraction of the image's shorter side (auto-scales to image).
    'font_scale' => 0.045,

    // Tile spacing as a fraction of the shorter side (gap between repeats).
    'tile_scale' => 0.40,
];
