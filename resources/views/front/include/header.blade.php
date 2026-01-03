<header>
    <div class="branding-section">
        <div class="branding-shape-container d-none d-lg-block"></div>
        <div class="container branding-content">
            <div class="row align-items-center">

                <div class="col-lg-4 col-md-4 col-5 d-flex align-items-center">
                    <div class="d-flex flex-column text-center text-lg-start">
                        <div class="d-flex align-items-center justify-content-center justify-content-lg-start">
                            <div class="logo-icon-circle">
                                <a href="{{ route('front.index') }}">
                                    <img src="{{ asset('/') }}{{ $front_logo_name }}" alt="" srcset="">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5 col-md-5 d-flex d-none d-md-block d-xl-block align-items-center mb-3 mb-md-0">
                    <div class="warehouse-title ms-lg-5">
                        {{ $front_ins_title }}
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 col-7 d-flex flex-column align-items-end">

                    <div class="d-flex mb-2">
                        {{-- LinkedIn --}}
                        @php
                            $linkedin = $social_links->where('title', 'LinkedIn')->first();
                        @endphp
                        @if($linkedin)
                        <a href="{{ $linkedin->link }}" class="social-icon-btn btn-linkedin me-2" aria-label="LinkedIn" target="_blank">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        @endif

                        {{-- Facebook --}}
                        @php
                            $facebook = $social_links->where('title', 'Facebook')->first();
                        @endphp
                        @if($facebook)
                        <a href="{{ $facebook->link }}" class="social-icon-btn btn-facebook me-2" aria-label="Facebook" target="_blank">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        @endif

                        {{-- YouTube --}}
                        @php
                            $youtube = $social_links->where('title', 'YouTube')->first();
                        @endphp
                        @if($youtube)
                        <a href="{{ $youtube->link }}" class="social-icon-btn btn-youtube" aria-label="YouTube" target="_blank">
                            <i class="fab fa-youtube"></i>
                        </a>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="nav-sticky-wrapper" id="main-nav-wrapper">
        <nav class="navbar navbar-expand-lg bg-gw-light-grey border-bottom border-top">
            <div class="container">
                <a class="navbar-brand d-lg-none text-gw-dark-grey fw-bold" href="#">SCIENTIFIC SOLUTIONS</a>
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
                    aria-labelledby="offcanvasNavbarLabel">
                    <div class="offcanvas-header">
                        <button type="button" class="btn-close btn-close-black" data-bs-dismiss="offcanvas"
                            aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav justify-content-between flex-grow-1 pe-3">
                            
                            <li class="nav-item">
                                <a class="nav-link nav-link-main active" aria-current="page"
                                    href="{{ route('front.index') }}">HOME</a>
                            </li>

                            @if(isset($header_categories))
                                @foreach($header_categories as $category)
                                    <li class="nav-item">
                                        @if($category->brands->count() > 0)
                                            {{-- Route 1: If category has companies/brands --}}
                                            <a class="nav-link nav-link-main" 
                                               href="{{ route('front.category.companies', $category->slug) }}">
                                               {{ $category->name }}
                                            </a>
                                        @else
                                            {{-- Route 2: If category has no companies (show products directly) --}}
                                            <a class="nav-link nav-link-main" 
                                               href="{{ route('front.category.products', $category->slug) }}">
                                               {{ $category->name }}
                                            </a>
                                        @endif
                                    </li>
                                @endforeach
                            @endif

                            <li class="nav-item">
                                <a class="nav-link nav-link-main" href="{{ route('front.aboutUs') }}">About us</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link nav-link-main" href="{{ route('front.contactUs') }}">CONTACT US</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <div class="sub-nav-bar bg-gw-blue text-white d-none d-lg-block">
            <div class="container">
                <div class="d-flex flex-wrap justify-content-center">
                    <span class="sub-nav-link text-white px-3">Specialised Laboratory</span>
                    <span class="sub-nav-link text-white px-3">Chromatography</span>
                    <span class="sub-nav-link text-whitepx-3">Specialist Medical Supplies</span>
                </div>
            </div>
        </div>
    </div>

</header>