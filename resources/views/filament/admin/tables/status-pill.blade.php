@php
$record = $getRecord();
$status = $record->status;
$label = $status->label();
$key = $status->value;
$style = match($key) {
    'pending'   => ['#fff7ed', '#c2410c', '#f97316'],
    'confirmed' => ['#eff6ff', '#1d4ed8', '#007aff'],
    'delivered' => ['#dcfce7', '#15803d', '#34c759'],
    'cancelled' => ['#fef2f2', '#b91c1c', '#ff3b30'],
    default     => ['#f5f5f7', '#3f3f46', '#8e8e93'],
};
[$bg, $txt, $dot] = $style;
@endphp
<span style="display:inline-flex;align-items:center;gap:6px;padding:3px 11px;background:{{ $bg }};color:{{ $txt }};border-radius:980px;font-size:11.5px;font-weight:700;letter-spacing:-0.005em;white-space:nowrap">
    <span style="width:6px;height:6px;border-radius:50%;background:{{ $dot }};box-shadow:0 0 0 2px rgba(255,255,255,.6)"></span>
    {{ $label }}
</span>
