@extends('layouts.storefront')

@section('title', 'About — SR MAC SHOP')
@section('description', 'SR MAC SHOP was founded in 2018. Cambodia\'s most trusted MacBook specialist with over 500 happy customers in Phnom Penh.')

@section('content')
<section class="shop-section" style="background:var(--bg2);padding-top:2.5rem">
    <div class="inner" style="max-width:700px">
        <div class="sec-eyebrow" data-en="Our Story" data-km="រឿងរ៉ាវរបស់យើង">Our Story</div>
        <h1 class="sec-h" data-en="About SR MAC SHOP" data-km="អំពី SR MAC SHOP">About SR MAC SHOP</h1>
        <p style="font-size:15px;color:var(--text2);line-height:1.8;margin-top:1rem"
            data-en="SR MAC SHOP was founded in 2018 with a single goal: to make authentic Apple MacBooks accessible to every Cambodian. Based in Phnom Penh, we are Cambodia's most trusted MacBook specialist with over 500 happy customers and counting."
            data-km="SR MAC SHOP ត្រូវបានបង្កើតឡើងនៅឆ្នាំ ២០១៨ ដោយមានគោលដៅតែមួយ: ធ្វើឱ្យ MacBook Apple ពិតប្រាកដអាចចូលដំណើរការបានសម្រាប់ជនជាតិខ្មែរគ្រប់រូប។">
            SR MAC SHOP was founded in 2018 with a single goal: to make authentic Apple MacBooks accessible to every Cambodian. Based in Phnom Penh, we are Cambodia's most trusted MacBook specialist with over 500 happy customers and counting.
        </p>
        <div class="why-grid" style="margin-top:2rem">
            <div class="wcard">
                <div class="wcard-icon">🏆</div>
                <div class="wcard-t">Est. 2018</div>
                <div class="wcard-s" data-en="6+ years serving Cambodia's tech community." data-km="6+ ឆ្នាំ បំរើសហគមន៍បច្ចេកវិទ្យាកម្ពុជា។">6+ years serving Cambodia's tech community.</div>
            </div>
            <div class="wcard">
                <div class="wcard-icon">📍</div>
                <div class="wcard-t">Phnom Penh</div>
                <div class="wcard-s" data-en="Borey Pibhu Thmey Kambol III — visit us anytime." data-km="បុរីពិភពថ្មីកំបូល III — ចូរមកទស្សនាយើង។">Borey Pibhu Thmey Kambol III — visit us anytime.</div>
            </div>
            <div class="wcard">
                <div class="wcard-icon">🤝</div>
                <div class="wcard-t" data-en="Authorized Reseller" data-km="ភ្នាក់ងារលក់ផ្លូវការ">Authorized Reseller</div>
                <div class="wcard-s" data-en="Certified Apple premium reseller partner." data-km="ដៃគូ Apple premium reseller ដែលមានការបញ្ជាក់។">Certified Apple premium reseller partner.</div>
            </div>
            <div class="wcard">
                <div class="wcard-icon">⭐</div>
                <div class="wcard-t" data-en="500+ Customers" data-km="អតិថិជន 500+">500+ Customers</div>
                <div class="wcard-s" data-en="Trusted by hundreds of happy MacBook owners." data-km="ទទួលការទុកចិត្តពីម្ចាស់ MacBook រាប់រយនាក់។">Trusted by hundreds of happy MacBook owners.</div>
            </div>
        </div>

        <div style="margin-top:3rem;padding:24px;background:var(--card);border-radius:var(--r);border:1px solid var(--border2)">
            <div class="sec-eyebrow" style="margin-bottom:8px">Our Mission</div>
            <p style="font-size:15px;color:var(--text2);line-height:1.8"
                data-en="We believe every Cambodian deserves access to genuine Apple technology at fair prices. Our mission is to be the most trusted technology partner in Cambodia."
                data-km="យើងជឿជាក់ថាជនជាតិខ្មែរគ្រប់រូប អាចទទួលបានបច្ចេកវិទ្យា Apple ពិតប្រាកដ ក្នុងតម្លៃសមស្រប។">
                We believe every Cambodian deserves access to genuine Apple technology at fair prices. Our mission is to be the most trusted technology partner in Cambodia.
            </p>
        </div>

        <div style="text-align:center;margin-top:2rem">
            <a href="{{ route('shop') }}" class="btn btn-blue" data-en="Browse Our Products →" data-km="ឆ្លងកាត់ផលិតផលរបស់យើង →">Browse Our Products →</a>
            <a href="{{ route('contact') }}" class="btn btn-ghost" style="margin-left:8px" data-en="Contact Us" data-km="ទំនាក់ទំនង">Contact Us</a>
        </div>
    </div>
</section>
@endsection
