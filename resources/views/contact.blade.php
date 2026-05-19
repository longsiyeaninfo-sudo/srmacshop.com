@extends('layouts.storefront')

@section('title', 'Contact — SR MAC SHOP')
@section('description', 'Contact SR MAC SHOP. WhatsApp or Telegram: +855 98 33 47 55. Located at Borey Pibhu Thmey Kambol III, Phnom Penh. Open Mon–Sun 8AM–8PM.')

@section('content')
<style>
.ct-wrap{max-width:1100px;margin:0 auto;padding:var(--space-10) var(--space-6) var(--space-16)}
.ct-hero{text-align:center;margin-bottom:var(--space-10)}
.ct-hero .eyebrow{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:2px;color:var(--blue);margin-bottom:.5rem}
.ct-hero h1{font-size:clamp(2rem,4vw,2.8rem);font-weight:700;letter-spacing:-.035em;margin-bottom:.5rem}
.ct-hero p{color:var(--text2);font-size:15px;max-width:520px;margin:0 auto}

.ct-grid{display:grid;grid-template-columns:1fr 1.2fr;gap:var(--space-8)}
@media(max-width:780px){.ct-grid{grid-template-columns:1fr}}

.ct-info{display:flex;flex-direction:column;gap:var(--space-3)}
.ct-card{display:flex;gap:var(--space-3);align-items:flex-start;padding:var(--space-4) var(--space-5);background:var(--card);border-radius:var(--radius-lg);border:1px solid var(--hairline);transition:transform .25s var(--ease),box-shadow .25s var(--ease)}
.ct-card:hover{transform:translateY(-2px);box-shadow:var(--shadow-sm)}
.ct-card-ico{width:38px;height:38px;border-radius:var(--radius);background:var(--blue-l);color:var(--blue);display:flex;align-items:center;justify-content:center;font-size:17px;flex-shrink:0}
.ct-card-lbl{font-size:11px;font-weight:600;color:var(--text2);text-transform:uppercase;letter-spacing:.5px;margin-bottom:2px}
.ct-card-val{font-size:14px;font-weight:500;color:var(--text);letter-spacing:-.005em}
.ct-card-val a{color:var(--text);text-decoration:none;transition:color .15s var(--ease)}
.ct-card-val a:hover{color:var(--blue)}

.ct-actions{display:flex;gap:var(--space-2);margin-top:var(--space-2)}
.ct-action{flex:1;display:inline-flex;align-items:center;justify-content:center;gap:6px;padding:14px;border-radius:var(--radius);font-size:14px;font-weight:600;text-decoration:none;color:#fff;transition:transform .15s var(--ease),box-shadow .15s var(--ease)}
.ct-action:hover{transform:translateY(-1px);box-shadow:var(--shadow-md)}
.ct-action-wa{background:#25D366}
.ct-action-tg{background:#229ED9}

.ct-map{border-radius:var(--radius-lg);overflow:hidden;border:1px solid var(--hairline);min-height:480px;position:relative;background:var(--bg)}
.ct-map iframe{width:100%;height:100%;min-height:480px;border:none;display:block}
.ct-map-overlay{position:absolute;left:var(--space-4);right:var(--space-4);bottom:var(--space-4);background:rgba(255,255,255,.95);backdrop-filter:blur(14px) saturate(180%);-webkit-backdrop-filter:blur(14px) saturate(180%);border-radius:var(--radius);padding:var(--space-3) var(--space-4);display:flex;justify-content:space-between;align-items:center;box-shadow:var(--shadow-md);gap:var(--space-3)}
.ct-map-overlay-text{font-size:13px;font-weight:600;color:var(--text);letter-spacing:-.005em}
.ct-map-overlay-sub{font-size:11px;color:var(--text2);margin-top:2px}
[data-theme="dark"] .ct-map-overlay{background:rgba(28,28,30,.92);color:#fff}
</style>

<div class="ct-wrap">
    <div class="ct-hero">
        <div class="eyebrow" data-en="Get in touch" data-km="ទំនាក់ទំនង">Get in touch</div>
        <h1 data-en="Talk to us." data-km="និយាយជាមួយយើង។">Talk to us.</h1>
        <p data-en="WhatsApp, Telegram, phone, or in person — pick what works for you." data-km="WhatsApp, Telegram, ទូរស័ព្ទ ឬ ផ្ទាល់ — ជ្រើសរើសអ្វីដែលអ្នកចូលចិត្ត។">WhatsApp, Telegram, phone, or in person — pick what works for you.</p>
    </div>

    <div class="ct-grid">
        <div class="ct-info">
            <div class="ct-card">
                <div class="ct-card-ico">📍</div>
                <div>
                    <div class="ct-card-lbl" data-en="Address" data-km="អាសយដ្ឋាន">Address</div>
                    <div class="ct-card-val" data-en="Borey Pibhu Thmey Kambol III, Sangkat Kambol, Phnom Penh" data-km="បុរីពិភពថ្មីកំបូល III ភូមិថ្មដា សង្កាត់កំបូល ភ្នំពេញ">Borey Pibhu Thmey Kambol III, Sangkat Kambol, Phnom Penh</div>
                </div>
            </div>
            <div class="ct-card">
                <div class="ct-card-ico">📞</div>
                <div>
                    <div class="ct-card-lbl">Phone</div>
                    <div class="ct-card-val"><a href="tel:+85598334755">+855 98 33 47 55</a></div>
                </div>
            </div>
            <div class="ct-card">
                <div class="ct-card-ico">💬</div>
                <div>
                    <div class="ct-card-lbl">WhatsApp</div>
                    <div class="ct-card-val"><a href="https://wa.me/85598334755" target="_blank" rel="noopener">+855 98 33 47 55</a></div>
                </div>
            </div>
            <div class="ct-card">
                <div class="ct-card-ico">✈️</div>
                <div>
                    <div class="ct-card-lbl">Telegram</div>
                    <div class="ct-card-val"><a href="https://t.me/srmacshop" target="_blank" rel="noopener">@srmacshop</a></div>
                </div>
            </div>
            <div class="ct-card">
                <div class="ct-card-ico">🕐</div>
                <div>
                    <div class="ct-card-lbl" data-en="Hours" data-km="ម៉ោង">Hours</div>
                    <div class="ct-card-val" data-en="Mon–Sun: 8 AM – 8 PM" data-km="ច័ន្ទ–អាទិត្យ: ៨ – ២០ម៉ោង">Mon–Sun: 8 AM – 8 PM</div>
                </div>
            </div>

            <div class="ct-actions">
                <a href="https://wa.me/85598334755?text=Hi%20SR%20MAC%20SHOP!%20I%20have%20a%20question." target="_blank" rel="noopener" class="ct-action ct-action-wa">💬 WhatsApp</a>
                <a href="https://t.me/srmacshop" target="_blank" rel="noopener" class="ct-action ct-action-tg">✈️ Telegram</a>
            </div>
        </div>

        {{-- Map (OpenStreetMap via iframe — no API key needed) --}}
        <div class="ct-map">
            <iframe
                src="https://www.openstreetmap.org/export/embed.html?bbox=104.870,11.545,104.913,11.573&layer=mapnik&marker=11.5595,104.8916"
                loading="lazy"
                title="SR MAC SHOP location on map"></iframe>
            <div class="ct-map-overlay">
                <div>
                    <div class="ct-map-overlay-text">SR MAC SHOP</div>
                    <div class="ct-map-overlay-sub" data-en="Borey Pibhu Thmey Kambol III" data-km="បុរីពិភពថ្មីកំបូល III">Borey Pibhu Thmey Kambol III</div>
                </div>
                <a href="https://maps.google.com/?q=11.5595,104.8916" target="_blank" rel="noopener" class="btn btn-blue btn-sm" data-en="Directions →" data-km="ទិសដៅ →">Directions →</a>
            </div>
        </div>
    </div>
</div>
@endsection
