@extends('layouts.storefront')

@section('title', 'Contact — SR MAC SHOP')
@section('description', 'Contact SR MAC SHOP. WhatsApp or Telegram: +855 98 33 47 55. Located at Borey Pibhu Thmey Kambol III, Phnom Penh. Open Mon–Sun 8AM–8PM.')

@section('content')
<section class="shop-section" style="background:var(--bg);padding-top:2.5rem">
    <div class="inner">
        <div class="sec-eyebrow" data-en="Get In Touch" data-km="ទំនាក់ទំនង">Get In Touch</div>
        <h1 class="sec-h" data-en="Contact Us" data-km="ទំនាក់ទំនងយើង">Contact Us</h1>

        <div class="contact-grid">
            <div style="display:flex;flex-direction:column;gap:10px">
                <div class="cinfo-card">
                    <div class="cinfo-ico">📍</div>
                    <div>
                        <div class="cinfo-lbl" data-en="Address" data-km="អាសយដ្ឋាន">Address</div>
                        <div class="cinfo-val"
                            data-en="Borey Pibhu Thmey Kambol III, Sangkat Kambol, Phnom Penh"
                            data-km="បុរីពិភពថ្មីកំបូល III ភូមិថ្មដា សង្កាត់កំបូល ខណ្ឌកំបូល ភ្នំពេញ">
                            Borey Pibhu Thmey Kambol III, Sangkat Kambol, Phnom Penh
                        </div>
                    </div>
                </div>
                <div class="cinfo-card">
                    <div class="cinfo-ico">📞</div>
                    <div>
                        <div class="cinfo-lbl">Phone / Telegram</div>
                        <div class="cinfo-val">
                            <a href="tel:+85598334755" style="color:inherit">+855 98 33 47 55</a>
                        </div>
                    </div>
                </div>
                <div class="cinfo-card">
                    <div class="cinfo-ico">💬</div>
                    <div>
                        <div class="cinfo-lbl">WhatsApp</div>
                        <div class="cinfo-val">
                            <a href="https://wa.me/85598334755" target="_blank" rel="noopener" style="color:inherit">+855 98 33 47 55</a>
                        </div>
                    </div>
                </div>
                <div class="cinfo-card">
                    <div class="cinfo-ico">✈️</div>
                    <div>
                        <div class="cinfo-lbl">Telegram</div>
                        <div class="cinfo-val">
                            <a href="https://t.me/srmacshop" target="_blank" rel="noopener" style="color:inherit">@srmacshop</a>
                        </div>
                    </div>
                </div>
                <div class="cinfo-card">
                    <div class="cinfo-ico">🕐</div>
                    <div>
                        <div class="cinfo-lbl" data-en="Hours" data-km="ម៉ោង">Hours</div>
                        <div class="cinfo-val" data-en="Mon–Sun: 8AM – 8PM" data-km="ច័ន្ទ–អាទិត្យ: ៨ – ២០ម៉ោង">Mon–Sun: 8AM – 8PM</div>
                    </div>
                </div>
                <div class="cinfo-card">
                    <div class="cinfo-ico">🌐</div>
                    <div>
                        <div class="cinfo-lbl">Website</div>
                        <div class="cinfo-val">www.srmacshop.com</div>
                    </div>
                </div>

                {{-- Quick Contact Buttons --}}
                <div style="display:flex;gap:8px;margin-top:8px">
                    <a href="https://wa.me/85598334755?text=Hi%20SR%20MAC%20SHOP!%20I%20have%20a%20question."
                        target="_blank" rel="noopener"
                        style="flex:1;padding:12px;background:#25D366;color:#fff;border-radius:var(--rs);font-size:14px;font-weight:700;text-align:center;text-decoration:none;display:flex;align-items:center;justify-content:center;gap:6px">
                        💬 WhatsApp
                    </a>
                    <a href="https://t.me/srmacshop"
                        target="_blank" rel="noopener"
                        style="flex:1;padding:12px;background:#229ED9;color:#fff;border-radius:var(--rs);font-size:14px;font-weight:700;text-align:center;text-decoration:none;display:flex;align-items:center;justify-content:center;gap:6px">
                        ✈️ Telegram
                    </a>
                </div>
            </div>

            <div class="map-ph">
                <span style="font-size:44px">🗺️</span>
                <p style="font-weight:700;color:var(--blue)" data-en="Find Us on Google Maps" data-km="ស្វែងរក នៅ Google Maps">Find Us on Google Maps</p>
                <p style="font-size:12px;color:var(--text2);text-align:center;padding:0 1rem"
                    data-en="Borey Pibhu Thmey Kambol III, Sangkat Kambol, Phnom Penh"
                    data-km="បុរីពិភពថ្មីកំបូល III ភូមិថ្មដា សង្កាត់កំបូល">
                    Borey Pibhu Thmey Kambol III, Sangkat Kambol, Phnom Penh
                </p>
                <a href="https://maps.google.com/?q=11.55949976721228,104.89155303686857"
                    target="_blank" rel="noopener" class="btn btn-blue btn-sm">
                    <span data-en="Open Maps →" data-km="បើក Maps →">Open Maps →</span>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
