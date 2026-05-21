@extends('layouts.storefront')

@section('title', 'About — SR MAC SHOP')
@section('description', 'SR MAC SHOP was founded in 2018. Cambodia\'s most trusted MacBook specialist with over 500 happy customers in Phnom Penh.')

@section('content')
<style>
.ab-hero{background:#0a0a0a;color:#fff;text-align:center;padding:96px 1.5rem 80px;position:relative;overflow:hidden}
.ab-hero::before{content:"";position:absolute;inset:0;background:
  radial-gradient(ellipse 50% 40% at 30% 30%, rgba(10,132,255,.1) 0%, transparent 60%),
  radial-gradient(ellipse 40% 30% at 70% 70%, rgba(175,82,222,.07) 0%, transparent 60%)}
.ab-hero-inner{position:relative;max-width:780px;margin:0 auto}
.ab-hero .eyebrow{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:2px;color:rgba(255,255,255,.55);margin-bottom:14px}
.ab-hero h1{font-size:clamp(2.2rem,5vw,3.6rem);font-weight:700;letter-spacing:-.04em;line-height:1.05;margin-bottom:18px}
.ab-hero p{font-size:17px;color:rgba(255,255,255,.7);line-height:1.55;letter-spacing:-.005em;max-width:580px;margin:0 auto}

.ab-trust{background:var(--bg2);padding:48px 1.5rem;border-bottom:1px solid var(--hairline)}
.ab-trust-inner{max-width:1100px;margin:0 auto;display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:32px;text-align:center}
.ab-trust-item .num{font-size:36px;font-weight:700;letter-spacing:-.03em;color:var(--text)}
.ab-trust-item .lbl{font-size:12px;color:var(--text2);margin-top:4px;text-transform:uppercase;letter-spacing:1px;font-weight:600}

/* Story */
.ab-story{padding:96px 1.5rem;background:var(--bg)}
.ab-story-inner{max-width:780px;margin:0 auto}
.ab-story .eyebrow{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:2px;color:var(--blue);margin-bottom:.5rem;text-align:center}
.ab-story h2{font-size:clamp(1.8rem,3.5vw,2.4rem);font-weight:700;letter-spacing:-.025em;text-align:center;margin-bottom:32px}
.ab-story p{font-size:16px;line-height:1.7;color:var(--text2);margin-bottom:16px}

/* Timeline */
.ab-timeline{padding:80px 1.5rem;background:var(--bg2)}
.ab-tl-inner{max-width:880px;margin:0 auto}
.ab-tl-head{text-align:center;margin-bottom:48px}
.ab-tl{position:relative;padding-left:42px;border-left:2px solid var(--hairline)}
.ab-tl-item{position:relative;padding-bottom:32px}
.ab-tl-item:last-child{padding-bottom:0}
.ab-tl-dot{position:absolute;left:-52px;top:0;width:20px;height:20px;border-radius:50%;background:var(--card);border:3px solid var(--blue);box-shadow:0 0 0 4px var(--bg2)}
.ab-tl-year{font-size:13px;font-weight:700;color:var(--blue);letter-spacing:.5px}
.ab-tl-title{font-size:17px;font-weight:600;margin-top:4px;letter-spacing:-.01em}
.ab-tl-desc{font-size:14px;color:var(--text2);margin-top:6px;line-height:1.55;max-width:520px}

/* Mission */
.ab-mission{padding:80px 1.5rem;background:linear-gradient(180deg, var(--bg) 0%, var(--bg2) 100%)}
.ab-mission-card{max-width:780px;margin:0 auto;background:var(--card);border:1px solid var(--hairline);border-radius:var(--radius-lg);padding:48px;box-shadow:var(--shadow-sm);text-align:center}
.ab-mission .eyebrow{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:2px;color:var(--blue);margin-bottom:.5rem}
.ab-mission h2{font-size:clamp(1.6rem,3vw,2rem);font-weight:700;letter-spacing:-.025em;margin-bottom:14px}
.ab-mission p{font-size:16px;color:var(--text2);line-height:1.7;max-width:560px;margin:0 auto}

.ab-cta{padding:48px 1.5rem;background:var(--bg2);text-align:center;border-top:1px solid var(--hairline)}
.ab-cta .btn{margin:0 4px}
</style>

{{-- HERO --}}
<section class="ab-hero reveal">
    <div class="ab-hero-inner">
        <div class="eyebrow" data-en="Our Story" data-km="រឿងរ៉ាវរបស់យើង">Our Story</div>
        <h1 data-en="MacBooks, made simple in Cambodia." data-km="MacBook ងាយស្រួលនៅកម្ពុជា។">MacBooks, made simple in Cambodia.</h1>
        <p data-en="Since 2018, we've been Cambodia's most trusted MacBook specialist. Authentic Apple hardware, fair prices, same-day delivery." data-km="ចាប់តាំងពីឆ្នាំ ២០១៨ យើងជាអ្នកជំនាញ MacBook ដែលគួរទុកចិត្តបំផុតនៅកម្ពុជា។">
            Since 2018, we've been Cambodia's most trusted MacBook specialist. Authentic Apple hardware, fair prices, same-day delivery.
        </p>
    </div>
</section>

{{-- TRUST BADGES --}}
<section class="ab-trust">
    <div class="ab-trust-inner">
        <div class="ab-trust-item">
            <div class="num">7+</div>
            <div class="lbl" data-en="Years in business" data-km="ឆ្នាំនៅក្នុងធុរកិច្ច">Years in business</div>
        </div>
        <div class="ab-trust-item">
            <div class="num">500+</div>
            <div class="lbl" data-en="Happy customers" data-km="អតិថិជនពេញចិត្ត">Happy customers</div>
        </div>
        <div class="ab-trust-item">
            <div class="num">100%</div>
            <div class="lbl" data-en="Authentic Apple" data-km="Apple ពិតប្រាកដ">Authentic Apple</div>
        </div>
        <div class="ab-trust-item">
            <div class="num">24/7</div>
            <div class="lbl" data-en="WhatsApp support" data-km="គាំទ្រ WhatsApp">WhatsApp support</div>
        </div>
    </div>
</section>

{{-- STORY --}}
<section class="ab-story reveal">
    <div class="ab-story-inner">
        <div class="eyebrow" data-en="About us" data-km="អំពីយើង">About us</div>
        <h2 data-en="A small team, a big mission." data-km="ក្រុមតូច បេសកកម្មធំ។">A small team, a big mission.</h2>
        <p data-en="SR MAC SHOP was founded in 2018 with a single goal: to make authentic Apple MacBooks accessible to every Cambodian." data-km="SR MAC SHOP ត្រូវបានបង្កើតឡើងនៅឆ្នាំ ២០១៨ ដោយមានគោលដៅតែមួយ: ធ្វើឱ្យ MacBook Apple ពិតប្រាកដអាចចូលដំណើរការបានសម្រាប់ជនជាតិខ្មែរគ្រប់រូប។">
            SR MAC SHOP was founded in 2018 with a single goal: to make authentic Apple MacBooks accessible to every Cambodian.
        </p>
        <p data-en="Based in Phnom Penh, we serve customers across the country with same-day delivery, free setup, and a no-questions-asked warranty policy." data-km="ដោយផ្អែកនៅភ្នំពេញ យើងបម្រើអតិថិជននៅទូទាំងប្រទេស ដោយដឹកជញ្ជូនថ្ងៃនេះ ដំឡើងឥតគិតថ្លៃ និងគោលនយោបាយធានាដោយឥតមានសំណួរ។">
            Based in Phnom Penh, we serve customers across the country with same-day delivery, free setup, and a no-questions-asked warranty policy.
        </p>
    </div>
</section>

{{-- TIMELINE --}}
<section class="ab-timeline reveal">
    <div class="ab-tl-inner">
        <div class="ab-tl-head">
            <div class="eyebrow" style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:2px;color:var(--blue);margin-bottom:.5rem" data-en="Our journey" data-km="ដំណើររបស់យើង">Our journey</div>
            <h2 style="font-size:clamp(1.8rem,3.5vw,2.4rem);font-weight:700;letter-spacing:-.025em" data-en="From a single laptop to a full catalog." data-km="ពីកុំព្យូទ័រយួរដៃតែមួយ ទៅជាបញ្ជីផលិតផលពេញលេញ។">From a single laptop to a full catalog.</h2>
        </div>
        <div class="ab-tl">
            <div class="ab-tl-item">
                <div class="ab-tl-dot"></div>
                <div class="ab-tl-year">2018</div>
                <div class="ab-tl-title" data-en="The shop opens" data-km="ហាងបើកដំណើរការ">The shop opens</div>
                <div class="ab-tl-desc" data-en="Started selling pre-owned MacBooks to friends and word-of-mouth customers in Phnom Penh." data-km="ចាប់ផ្តើមលក់ MacBook មួយទឹកដល់មិត្តភ័ក្តិ និងអតិថិជនតាមការនិយាយ-ពាក្យលឺ-ពាក្យនៅភ្នំពេញ។">Started selling pre-owned MacBooks to friends and word-of-mouth customers in Phnom Penh.</div>
            </div>
            <div class="ab-tl-item">
                <div class="ab-tl-dot"></div>
                <div class="ab-tl-year">2020</div>
                <div class="ab-tl-title" data-en="Expanded the catalog" data-km="ពង្រីកបញ្ជី">Expanded the catalog</div>
                <div class="ab-tl-desc" data-en="Added brand-new MacBooks with official warranty. Hit 200 happy customers." data-km="បន្ថែម MacBook ថ្មីដែលមានការធានាផ្លូវការ។ ឈានដល់អតិថិជន ២០០ នាក់។">Added brand-new MacBooks with official warranty. Hit 200 happy customers.</div>
            </div>
            <div class="ab-tl-item">
                <div class="ab-tl-dot"></div>
                <div class="ab-tl-year">2024</div>
                <div class="ab-tl-title" data-en="Launched the storefront" data-km="ដាក់ឱ្យដំណើរការហាងអនឡាញ">Launched the storefront</div>
                <div class="ab-tl-desc" data-en="srmacshop.com goes live. Online ordering, same-day delivery, KHQR payments." data-km="srmacshop.com ដាក់ឱ្យដំណើរការ។ ការបញ្ជាទិញលើបណ្តាញ ការដឹកជញ្ជូនថ្ងៃនេះ ការទូទាត់ KHQR។">srmacshop.com goes live. Online ordering, same-day delivery, KHQR payments.</div>
            </div>
            <div class="ab-tl-item">
                <div class="ab-tl-dot" style="background:var(--blue)"></div>
                <div class="ab-tl-year" data-en="Today" data-km="ថ្ងៃនេះ">Today</div>
                <div class="ab-tl-title" data-en="500+ customers across Cambodia" data-km="អតិថិជន ៥០០+ នៅទូទាំងកម្ពុជា">500+ customers across Cambodia</div>
                <div class="ab-tl-desc" data-en="Trusted by designers, engineers, students, and businesses nationwide." data-km="ទទួលការទុកចិត្តពីអ្នករចនា វិស្វករ និស្សិត និងសហគ្រាសនានាទូទាំងប្រទេស។">Trusted by designers, engineers, students, and businesses nationwide.</div>
            </div>
        </div>
    </div>
</section>

{{-- TESTIMONIALS --}}
<x-testimonials-section variant="light" />

{{-- MISSION --}}
<section class="ab-mission reveal">
    <div class="ab-mission-card">
        <div class="eyebrow" data-en="Our Mission" data-km="បេសកកម្មរបស់យើង">Our Mission</div>
        <h2 data-en="Authentic technology, fair prices, real support." data-km="បច្ចេកវិទ្យាពិតប្រាកដ តម្លៃសមរម្យ ការគាំទ្រពិតប្រាកដ។">Authentic technology, fair prices, real support.</h2>
        <p data-en="We believe every Cambodian deserves access to genuine Apple technology at fair prices. Our mission is to be the most trusted technology partner in Cambodia." data-km="យើងជឿជាក់ថាជនជាតិខ្មែរគ្រប់រូប អាចទទួលបានបច្ចេកវិទ្យា Apple ពិតប្រាកដ ក្នុងតម្លៃសមស្រប។">
            We believe every Cambodian deserves access to genuine Apple technology at fair prices. Our mission is to be the most trusted technology partner in Cambodia.
        </p>
    </div>
</section>

{{-- CTA --}}
<section class="ab-cta">
    <a href="{{ route('shop') }}" class="btn btn-blue" data-en="Browse our MacBooks →" data-km="មើល MacBook របស់យើង →">Browse our MacBooks →</a>
    <a href="{{ route('contact') }}" class="btn btn-ghost" data-en="Contact us" data-km="ទំនាក់ទំនង">Contact us</a>
</section>
@endsection
