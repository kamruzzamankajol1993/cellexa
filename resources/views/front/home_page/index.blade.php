@extends('front.master.master')

@section('title')
{{ $front_ins_name }} -  {{ $front_ins_title }}
@endsection

@section('css')
@endsection

@section('body')
 <!-- Hero Section -->
    @include('front.include.hero')
    <!-- /Hero Section -->

    <section class="section about_section">
        <div class="container" data-aos="fade-up" data-aos-delay="50">
            <div class="row">
                <div class="col-lg-7">
                    <div class="about_us_content">
                        <h4>ADVANCING HEALTHCARE, EMPOWERING INNOVATION</h4>
                    </div>
                    <div class="about_us_content_below">
                        <p>Cellexa Healthcare Solutions is an Australian supplier of hospital-grade consumables and
                            advanced laboratory equipment, serving hospitals, research institutions, and healthcare
                            organisations nationwide.</p>
                        <p>Through partnerships with globally recognised manufacturers, we deliver innovative, reliable,
                            and compliant solutions that support excellence in healthcare, diagnostics, and life
                            sciences. </p>
                        <p>At Cellexa, we go beyond supply — we are your trusted partner in advancing healthcare and
                            scientific innovation across Australia and beyond.</p>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="about_image">
                        <img src="{{ asset('/') }}public/front/assets/img/home/about.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>

   {{-- ক্যাটাগরি ডাটা যদি পাওয়া যায় তবেই সেকশন শো করবে --}}
    @if($home_first_category)
    <section class="section home_category">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-12">
                    {{-- ডাইনামিক ক্যাটাগরি নাম --}}
                    <h2 class="home_category_title">{{ $home_first_category->name }}</h2>
                </div>
                <div class="col-lg-5 col-12">
                    <div class="home_category_sub">
                        {{-- ডাইনামিক রাউট (Explore All Company) --}}
                        <a href="{{ route('front.category.companies', $home_first_category->slug) }}" class="btn cellexa_custom_btn">
                            Explore All Company
                        </a>
                    </div>
                </div>
            </div>

            <div class="row g-3 mt-4">
                {{-- কোম্পানি লুপ শুরু --}}
                @foreach($home_first_category->brands as $company)
    <div class="col-lg-3 col-6">
        
        {{-- লজিক শুরু: কোম্পানির নিজস্ব ক্যাটাগরি আছে কিনা চেক --}}
        @if($company->company_categories_count > 0)
            {{-- যদি ক্যাটাগরি থাকে -> ক্যাটাগরি পেজে যাবে --}}
            <a href="{{ route('front.company.categories', $company->slug) }}">
        @else
            {{-- যদি ক্যাটাগরি না থাকে -> প্রোডাক্ট পেজে যাবে --}}
            <a href="{{ route('front.company.products', $company->slug) }}">
        @endif
        {{-- লজিক শেষ --}}

            <div class="cellexa_item_box">
                <div class="cellexa_item_box_img">
                    <img src="{{ asset('public/'.$company->logo) }}" alt="{{ $company->name }}">
                </div>
            </div>
        </a> {{-- অ্যাংকর ট্যাগ ক্লোজ --}}
    </div>
    @endforeach
                {{-- কোম্পানি লুপ শেষ --}}
            </div>
        </div>
    </section>
    @endif
    @if($home_second_category)
    <section class="section home_category">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-12">
                    {{-- ডাইনামিক ক্যাটাগরি নাম --}}
                    <h2 class="home_category_title">{{ $home_second_category->name }}</h2>
                </div>
            </div>
            <div class="row g-3 mt-4">
                
                {{-- প্রোডাক্ট লুপ শুরু --}}
                @foreach($home_second_category->products as $product)
                <div class="col-lg-3 col-12">
                    
                    {{-- প্রোডাক্ট ডিটেইলস লিংক --}}
                    <a href="{{ route('front.product.details', $product->slug) }}" class="text-decoration-none text-dark">
                        <div class="cellexa_item_box">
                            <div class="cellexa_item_box_img1">
                                {{-- ইমেজ হ্যান্ডলিং --}}
                                @php
                                    // JSON স্ট্রিং থেকে অ্যারেতে কনভার্ট করা
                                    $images = json_decode($product->thumbnail_image);
                                    // যদি ইমেজ থাকে প্রথমটা নিবে, না থাকলে ডিফল্ট
                                    $thumb = (is_array($images) && count($images) > 0) ? $images[0] : 'default.png';
                                @endphp
                                
                                <img src="{{ asset('public/'.$thumb) }}" alt="{{ $product->name }}">
                            </div>
                            
                            <div class="cellexa_item_box_text1">
                                <h1>{{ Str::limit($product->name, 30) }}</h1>
                                <div class="cellexa_item_box_list">
                                    {{-- ডেসক্রিপশন (HTML রেন্ডার করার জন্য {!! !!}) --}}
                                    {{-- ছোট করে দেখানোর জন্য Str::limit ব্যবহার করা হয়েছে --}}
                                    <div class="product-short-desc">
                                        {!! Str::limit(strip_tags($product->description), 100) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
                {{-- প্রোডাক্ট লুপ শেষ --}}

            </div>
        </div>
    </section>
    @endif
    <section class="section home_details">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
                    <div class="home_details_left">
                        <img src="{{ asset('/') }}public/front/assets/img/home/2.png" alt="">
                    </div>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-12 mb-3">
                    <div class="home_details_right">
                        <h2>Our Story</h2>
                        <p>Cellexa Healthcare Solutions, a brand of Aurexa Group Pty Ltd, Australia, was founded to
                            bridge the gap between global innovation and Australia’s evolving healthcare and scientific
                            needs. With a commitment to quality, compliance, and reliability, Cellexa has become a
                            trusted
                            supplier of hospital-grade consumables and advanced laboratory equipment for hospitals,
                            research facilities, and healthcare organisations nationwide and around the globe.</p>
                        <h2>Achievements</h2>
                        <ul>
                            <li>Supplied and supported laboratory equipment and hospital consumables for leading
                                healthcare and research institutions across Asia-Pacific, South Africa. the Middle East
                                and parts of Europe.</li>
                            <li>Partnered with globally recognised manufacturers delivering innovative and compliant
                                healthcare and laboratory solutions.
                            </li>
                            <li>Recognised as a preferred supplier to hospitals, pharmaceutical, and research
                                organisations nationwide.</li>
                            <li>Proven track record of on-time delivery, responsive support, and competitive pricing.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <div class="home_details_bottom_left">
                        <img src="{{ asset('/') }}public/front/assets/img/home/3.jpg" alt="">
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12">
                    <div class="home_details_bottom_middle">
                        <h4>Our Mission</h4>
                        <p>To deliver premium pharmaceutical laboratory equipment that support innovation, accuracy, and
                            compliance for clients across Australia.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="home_details_bottom_right">
                        <h4>Our Vision</h4>
                        <p>To be recognised as Australia’s most reliable and trusted partner for pharmaceutical
                            laboratory solutions, contributing to the growth and advancement of the nation’s life
                            sciences sector.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section home_faq">
        <div class="container faq">
            <div class="row">
                <div class="col-lg-7 col-sm-12" data-aos="fade-up" data-aos-delay="300">
                    <div class="faq-container">

                        <div class="faq-item faq-active">
                            <h3><span>1</span> What products does Cellexa provide?</h3>
                            <div class="faq-content">
                                <p>Cellexa supplies hospital consumables and laboratory equipment, supporting both
                                    clinical and research environments.</p>
                            </div>
                            <i class="faq-toggle bi bi-chevron-right"></i>
                        </div><!-- End Faq item-->

                        <div class="faq-item">
                            <h3><span>2</span> Do you offer after-sales support?</h3>
                            <div class="faq-content">
                                <p>Yes. We ensure product quality and provide prompt replacements or assistance when
                                    needed.</p>
                            </div>
                            <i class="faq-toggle bi bi-chevron-right"></i>
                        </div><!-- End Faq item-->

                        <div class="faq-item">
                            <h3><span>3</span> Can you source specialised products?</h3>
                            <div class="faq-content">
                                <p>Yes. We work with global manufacturers to source or customise products to your
                                    specific requirements.</p>
                            </div>
                            <i class="faq-toggle bi bi-chevron-right"></i>
                        </div><!-- End Faq item-->

                        <div class="faq-item">
                            <h3><span>4</span> Where do you deliver?</h3>
                            <div class="faq-content">
                                <p>We deliver nationwide across Australia and internationally through trusted logistics
                                    partners.</p>
                            </div>
                            <i class="faq-toggle bi bi-chevron-right"></i>
                        </div><!-- End Faq item-->
                        <div class="faq-item">
                            <h3><span>5</span> Why choose Cellexa?</h3>
                            <div class="faq-content">
                                <p>We combine global expertise with local understanding, offering reliable, compliant,
                                    and cost-effective healthcare solutions.</p>
                            </div>
                            <i class="faq-toggle bi bi-chevron-right"></i>
                        </div><!-- End Faq item-->
                    </div>
                </div>
                <div class="col-lg-5" data-aos="fade-up">
                    <div class="home_faq">
                        <img src="{{ asset('/') }}public/front/assets/img/home/4.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
@endsection