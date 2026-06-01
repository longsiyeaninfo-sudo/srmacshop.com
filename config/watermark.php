<?php

return [
    // Master switch. Set WATERMARK_ENABLED=false in .env to disable.
    'enabled' => env('WATERMARK_ENABLED', true),

    // Text stamped across images.
    'text' => env('WATERMARK_TEXT', 'SRMACSHOP'),

    // Absolute path to a TrueType font (GD requires one for sized/angled text).
    'font' => resource_path('fonts/watermark.ttf'),

    // White text, opacity 0..1. Lower = more subtle.
    'color' => env('WATERMARK_COLOR', 'ffffff'),
    'opacity' => (float) env('WATERMARK_OPACITY', 0.30),

    // Diagonal angle of the repeated text.
    'angle' => 28,

    // Font size as a fraction of the image's shorter side (auto-scales to image).
    'font_scale' => 0.045,

    // Tile spacing as a fraction of the shorter side (higher = fewer, sparser repeats).
    'tile_scale' => 0.70,

    // Extra horizontal gap between repeats, as a fraction of the shorter side.
    'gap_scale' => 0.55,
];
