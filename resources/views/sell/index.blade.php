@extends('layouts.storefront')

@section('title', 'Sell Your Apple Device — SR MAC SHOP')
@section('description', 'Sell your used iPhone, iPad, MacBook or Apple Watch to SR MAC SHOP. Fast quote, fair price, pay on the spot. Get an offer in minutes.')

@section('content')
<style>
.sl-wrap{max-width:880px;margin:0 auto;padding:var(--space-10) var(--space-6) var(--space-16)}
.sl-hero{text-align:center;margin-bottom:var(--space-8)}
.sl-hero .eyebrow{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:2px;color:#1ebe57;margin-bottom:.5rem}
.sl-hero h1{font-size:clamp(2rem,4vw,2.8rem);font-weight:700;letter-spacing:-.035em;margin-bottom:.5rem}
.sl-hero p{color:var(--text2);font-size:15px;max-width:560px;margin:0 auto}

.sl-trust{display:grid;grid-template-columns:repeat(3,1fr);gap:var(--space-3);margin-bottom:var(--space-8)}
@media(max-width:640px){.sl-trust{grid-template-columns:1fr}}
.sl-trust-card{display:flex;gap:10px;align-items:center;padding:var(--space-3) var(--space-4);background:var(--card);border-radius:var(--radius-lg);border:1px solid var(--hairline)}
.sl-trust-ico{font-size:20px}
.sl-trust-txt{font-size:13px;font-weight:600;color:var(--text);letter-spacing:-.005em}

.sl-flash{display:flex;gap:10px;align-items:flex-start;padding:var(--space-4) var(--space-5);border-radius:var(--radius-lg);background:rgba(37,211,102,.12);border:1px solid rgba(37,211,102,.4);color:#0d8a3e;font-size:14px;font-weight:600;margin-bottom:var(--space-6)}
[data-theme="dark"] .sl-flash{color:#5be58a}

.sl-form{background:var(--card);border:1px solid var(--hairline);border-radius:var(--radius-lg);padding:var(--space-6) var(--space-6) var(--space-7)}
.sl-grid{display:grid;grid-template-columns:1fr 1fr;gap:var(--space-4) var(--space-5)}
@media(max-width:640px){.sl-grid{grid-template-columns:1fr}}
.sl-field{display:flex;flex-direction:column;gap:6px}
.sl-field.full{grid-column:1/-1}
.sl-field label{font-size:12px;font-weight:600;color:var(--text2);text-transform:uppercase;letter-spacing:.4px}
.sl-field label .req{color:var(--red)}
.sl-field input,.sl-field select,.sl-field textarea{width:100%;padding:11px 13px;border:1px solid var(--hairline);border-radius:var(--radius);background:var(--bg);color:var(--text);font-size:14px;font-family:var(--font);transition:border-color .15s var(--ease),box-shadow .15s var(--ease)}
.sl-field input:focus,.sl-field select:focus,.sl-field textarea:focus{outline:none;border-color:#25D366;box-shadow:0 0 0 3px rgba(37,211,102,.18)}
.sl-field textarea{resize:vertical;min-height:90px}
.sl-err{font-size:12px;color:var(--red);font-weight:500}

.sl-radio-row{display:flex;gap:var(--space-2);flex-wrap:wrap}
.sl-radio{flex:1;min-width:90px;display:flex;align-items:center;justify-content:center;gap:6px;padding:10px;border:1px solid var(--hairline);border-radius:var(--radius);background:var(--bg);cursor:pointer;font-size:13px;font-weight:600;color:var(--text);transition:all .15s var(--ease)}
.sl-radio input{display:none}
.sl-radio:has(input:checked){border-color:#25D366;background:rgba(37,211,102,.1);color:#0d8a3e}
[data-theme="dark"] .sl-radio:has(input:checked){color:#5be58a}

.sl-hint{font-size:12px;color:var(--text2)}
.sl-submit{width:100%;margin-top:var(--space-6);padding:15px;border:none;border-radius:var(--radius);background:linear-gradient(180deg,#25D366,#1ebe57);color:#fff;font-size:16px;font-weight:700;font-family:var(--font);cursor:pointer;transition:transform .15s var(--ease),box-shadow .15s var(--ease);box-shadow:0 4px 12px rgba(37,211,102,.28)}
.sl-submit:hover{transform:translateY(-1px);box-shadow:0 6px 18px rgba(37,211,102,.4)}
</style>

<div class="sl-wrap">
    <div class="sl-hero">
        <div class="eyebrow" data-en="Trade-in" data-km="ប្តូរយកលុយ" data-zh="以旧换新">Trade-in</div>
        <h1 data-en="Sell your Apple device for cash." data-km="លក់ឧបករណ៍ Apple របស់អ្នកយកលុយ។" data-zh="出售您的 Apple 设备换现金。">Sell your Apple device for cash.</h1>
        <p data-en="Tell us about your iPhone, iPad, MacBook or Apple Watch and we'll send you a fair quote — fast." data-km="ប្រាប់យើងអំពី iPhone, iPad, MacBook ឬ Apple Watch របស់អ្នក យើងនឹងផ្ញើតម្លៃសមរម្យឱ្យអ្នកយ៉ាងលឿន។" data-zh="告诉我们您的 iPhone、iPad、MacBook 或 Apple Watch，我们会快速给您一个公道的报价。">Tell us about your iPhone, iPad, MacBook or Apple Watch and we'll send you a fair quote — fast.</p>
    </div>

    <div class="sl-trust">
        <div class="sl-trust-card"><span class="sl-trust-ico">⚡</span><span class="sl-trust-txt" data-en="Fast quote" data-km="តម្លៃរហ័ស" data-zh="快速报价">Fast quote</span></div>
        <div class="sl-trust-card"><span class="sl-trust-ico">🤝</span><span class="sl-trust-txt" data-en="Fair price" data-km="តម្លៃសមរម្យ" data-zh="价格公道">Fair price</span></div>
        <div class="sl-trust-card"><span class="sl-trust-ico">💵</span><span class="sl-trust-txt" data-en="Pay on the spot" data-km="បង់ភ្លាមៗ" data-zh="当场付款">Pay on the spot</span></div>
    </div>

    @if(session('success'))
        <div class="sl-flash">✅ <span>{{ session('success') }}</span></div>
    @endif

    <form class="sl-form" method="POST" action="{{ route('sell.submit') }}" enctype="multipart/form-data">
        @csrf
        <div class="sl-grid">
            <div class="sl-field">
                <label data-en="Device type" data-km="ប្រភេទឧបករណ៍" data-zh="设备类型">Device type <span class="req">*</span></label>
                <select name="device_type" required>
                    <option value="iPhone" @selected(old('device_type')==='iPhone')>iPhone</option>
                    <option value="iPad" @selected(old('device_type')==='iPad')>iPad</option>
                    <option value="MacBook" @selected(old('device_type')==='MacBook')>MacBook</option>
                    <option value="Apple Watch" @selected(old('device_type')==='Apple Watch')>Apple Watch</option>
                    <option value="Other" @selected(old('device_type')==='Other')>Other</option>
                </select>
                @error('device_type')<span class="sl-err">{{ $message }}</span>@enderror
            </div>

            <div class="sl-field">
                <label data-en="Model" data-km="ម៉ូដែល" data-zh="型号">Model <span class="req">*</span></label>
                <input type="text" name="model" value="{{ old('model') }}" placeholder="iPhone 13 Pro" required>
                @error('model')<span class="sl-err">{{ $message }}</span>@enderror
            </div>

            <div class="sl-field">
                <label data-en="Storage" data-km="ទំហំផ្ទុក" data-zh="存储容量">Storage</label>
                <select name="storage">
                    <option value="" data-en="Not sure" data-km="មិនច្បាស់" data-zh="不确定">Not sure</option>
                    @foreach(['64GB','128GB','256GB','512GB','1TB','2TB'] as $s)
                        <option value="{{ $s }}" @selected(old('storage')===$s)>{{ $s }}</option>
                    @endforeach
                </select>
                @error('storage')<span class="sl-err">{{ $message }}</span>@enderror
            </div>

            <div class="sl-field">
                <label data-en="Condition" data-km="ស្ថានភាព" data-zh="成色">Condition</label>
                <select name="condition_grade">
                    <option value="" data-en="Not sure" data-km="មិនច្បាស់" data-zh="不确定">Not sure</option>
                    <option value="A+" @selected(old('condition_grade')==='A+')>A+ — Like new</option>
                    <option value="A" @selected(old('condition_grade')==='A')>A — Excellent</option>
                    <option value="B" @selected(old('condition_grade')==='B')>B — Good</option>
                    <option value="C" @selected(old('condition_grade')==='C')>C — Fair</option>
                </select>
                @error('condition_grade')<span class="sl-err">{{ $message }}</span>@enderror
            </div>

            <div class="sl-field">
                <label data-en="Battery health %" data-km="សុខភាពថ្ម %" data-zh="电池健康度 %">Battery health %</label>
                <input type="number" name="battery_health" value="{{ old('battery_health') }}" min="0" max="100" placeholder="89">
                @error('battery_health')<span class="sl-err">{{ $message }}</span>@enderror
            </div>

            <div class="sl-field">
                <label data-en="Your asking price (USD)" data-km="តម្លៃដែលអ្នកចង់បាន (USD)" data-zh="您的期望价格 (USD)">Your asking price (USD)</label>
                <input type="number" name="asking_price" value="{{ old('asking_price') }}" min="0" step="1" placeholder="500">
                @error('asking_price')<span class="sl-err">{{ $message }}</span>@enderror
            </div>

            <div class="sl-field full">
                <label data-en="Anything else? (scratches, accessories, box…)" data-km="មានអ្វីផ្សេងទៀតទេ? (ស្នាម គ្រឿងបន្ថែម ប្រអប់…)" data-zh="还有其他吗？（划痕、配件、包装盒…）">Anything else? (scratches, accessories, box…)</label>
                <textarea name="description" placeholder="...">{{ old('description') }}</textarea>
                @error('description')<span class="sl-err">{{ $message }}</span>@enderror
            </div>

            <div class="sl-field full">
                <label data-en="Photos (up to 4)" data-km="រូបថត (រហូតដល់ ៤)" data-zh="照片（最多 4 张）">Photos (up to 4)</label>
                <input type="file" name="photos[]" accept="image/*" multiple>
                <span class="sl-hint" data-en="JPG, PNG or WebP · max 5MB each. Clear photos = faster, better quote." data-km="JPG, PNG ឬ WebP · អតិបរមា 5MB ក្នុងមួយ។ រូបច្បាស់ = តម្លៃលឿន និងល្អជាង។" data-zh="JPG、PNG 或 WebP · 每张最大 5MB。照片清晰 = 报价更快更好。">JPG, PNG or WebP · max 5MB each. Clear photos = faster, better quote.</span>
                @error('photos.*')<span class="sl-err">{{ $message }}</span>@enderror
                @error('photos')<span class="sl-err">{{ $message }}</span>@enderror
            </div>

            <div class="sl-field">
                <label data-en="Your name" data-km="ឈ្មោះរបស់អ្នក" data-zh="您的姓名">Your name <span class="req">*</span></label>
                <input type="text" name="customer_name" value="{{ old('customer_name') }}" required>
                @error('customer_name')<span class="sl-err">{{ $message }}</span>@enderror
            </div>

            <div class="sl-field">
                <label data-en="Phone" data-km="ទូរស័ព្ទ" data-zh="电话">Phone <span class="req">*</span></label>
                <input type="tel" name="customer_phone" value="{{ old('customer_phone') }}" placeholder="0XX XXX XXX" required>
                @error('customer_phone')<span class="sl-err">{{ $message }}</span>@enderror
            </div>

            <div class="sl-field full">
                <label data-en="How should we reach you?" data-km="តើយើងគួរទាក់ទងអ្នកដោយរបៀបណា?" data-zh="我们该如何联系您？">How should we reach you?</label>
                <div class="sl-radio-row">
                    <label class="sl-radio"><input type="radio" name="contact_method" value="whatsapp" @checked(old('contact_method','whatsapp')==='whatsapp')> 💬 WhatsApp</label>
                    <label class="sl-radio"><input type="radio" name="contact_method" value="telegram" @checked(old('contact_method')==='telegram')> <x-icon-telegram :size="14" /> Telegram</label>
                    <label class="sl-radio"><input type="radio" name="contact_method" value="phone" @checked(old('contact_method')==='phone')> 📞 <span data-en="Phone" data-km="ទូរស័ព្ទ" data-zh="电话">Phone</span></label>
                </div>
                @error('contact_method')<span class="sl-err">{{ $message }}</span>@enderror
            </div>
        </div>

        <button type="submit" class="sl-submit" data-en="💵 Get my quote" data-km="💵 ទទួលតម្លៃ" data-zh="💵 获取报价">💵 Get my quote</button>
    </form>
</div>
@endsection
