@php
$record = $getRecord();
$name = $record->name ?? '—';
$email = $record->email ?? '';
$initial = mb_strtoupper(mb_substr(trim($name), 0, 1));
$palette = ['#007aff','#34c759','#ff9500','#af52de','#ff2d55','#5856d6','#5ac8fa','#bf5af2'];
$bg = $palette[abs(crc32($name)) % count($palette)];
@endphp
<div style="display:flex;align-items:center;gap:12px;min-width:0">
    <div style="width:38px;height:38px;border-radius:50%;background:{{ $bg }};color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:14px;flex-shrink:0;box-shadow:inset 0 1px 0 rgba(255,255,255,.22),0 1px 2px rgba(0,0,0,.08)">
        {{ $initial ?: '?' }}
    </div>
    <div style="display:flex;flex-direction:column;min-width:0">
        <span style="font-weight:600;color:var(--mac-text);font-size:13.5px;line-height:1.25">{{ $name }}</span>
        @if($email)
            <a href="mailto:{{ $email }}" style="font-size:11.5px;color:var(--mac-text-soft);line-height:1.35;text-decoration:none">{{ $email }}</a>
        @endif
    </div>
</div>
