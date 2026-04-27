@extends('front.master.master')

@section('title')
    All Products - {{ env('APP_NAME') }}
@endsection

@section('css')
<style>
    /* Custom Button Colors */
    .custom-btn-solid {
        background-color: #a1573c !important;
        border-color: #a1573c !important;
        color: #ffffff !important;
    }
    .custom-btn-solid:hover {
        background-color: #874932 !important; /* Hover-এ হালকা ডার্ক */
        border-color: #874932 !important;
        color: #ffffff !important;
    }

    .custom-btn-outline {
        color: #a1573c !important;
        border-color: #a1573c !important;
        background-color: transparent !important;
    }
    .custom-btn-outline:hover {
        background-color: #a1573c !important;
        color: #ffffff !important;
    }

    /* Pagination Custom Design for Mobile Fix */
    .custom-pagination {
        flex-wrap: wrap !important;
        justify-content: center;
        gap: 4px;
    }
    .custom-pagination .page-item .page-link {
        color: #a1573c;
        border-radius: 4px;
    }
    .custom-pagination .page-item.active .page-link {
        background-color: #a1573c;
        border-color: #a1573c;
        color: white;
    }

    /* Mobile Responsive Adjustments */
    @media (max-width: 767px) {
        /* Title and Meta */
        .product-title-text {
            font-size: 14px !important; /* মোবাইলে টাইটেল ছোট */
            line-height: 1.3;
            display: block;
            word-wrap: break-word;
        }
        .product-meta-item {
            font-size: 12px !important; /* মোবাইলে ক্যাটাগরি/ব্র্যান্ড বড় */
            display: inline-block;
            margin-top: 3px;
            white-space: normal !important;
        }
        /* Buttons Text adjustment for mobile */
        .btn-mobile-text {
            font-size: 11px !important;
            padding: 5px 2px !important;
        }
        /* Pagination Container adjustment */
        .pagination-container {
            flex-direction: column !important;
            text-align: center;
        }
        .pagination-container .text-muted {
            margin-bottom: 12px;
        }
    }
    .custom-toolbar {
        background: #f8f9fa;
        padding: 15px;
        border: 1px solid #dee2e6;
        border-radius: 5px;
        margin-bottom: 20px;
    }
    .loading-overlay {
        position: relative;
        opacity: 0.6;
        pointer-events: none;
    }
    .filter-sidebar {
        background: #fff;
        border: 1px solid #eee;
        border-radius: 5px;
        padding: 20px;
    }
    .filter-title {
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 15px;
        border-bottom: 2px solid #0d6efd;
        padding-bottom: 10px;
    }
    .filter-group-title {
        font-size: 15px;
        font-weight: 600;
        margin-top: 15px;
        margin-bottom: 10px;
        color: #444;
    }
    .custom-checkbox .form-check-input:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
    /* Horizontal Card Image Styling */
    .product-list-img-container {
        width: 100%;
        height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f9f9f9;
        border-right: 1px solid #eee;
    }
    .product-list-img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }
</style>
@endsection

@section('body')
<main>
    <section class="section product_page">
        <div class="container">
            <div class="mt-5 mb-4">
                <h2 class="home_category_title">All Products</h2>
                <p class="text-muted">Explore our complete catalog of scientific and medical equipment.</p>
            </div>

            <div class="row g-4">

                {{-- Left Sidebar: Filters --}}
                <div class="col-lg-3">
                    <button class="btn btn-primary w-100 mb-3 d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#filterCanvas">
                        <i class="bi bi-funnel"></i> Show Filters
                    </button>

                    <div class="offcanvas-lg offcanvas-start" tabindex="-1" id="filterCanvas">
                        <div class="offcanvas-header">
                            <h5 class="offcanvas-title">Filters</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#filterCanvas"></button>
                        </div>

                        <div class="offcanvas-body d-block filter-sidebar shadow-sm">
                            <h3 class="filter-title">Filter Products</h3>

                            {{-- Category Filter --}}
                            <div class="filter-group mb-4">
                                <h5 class="filter-group-title">Categories</h5>
                                <div style="max-height: 200px; overflow-y: auto;">
                                    @foreach($allCategories as $cat)
                                        <div class="form-check custom-checkbox mb-2">
                                            <input class="form-check-input filter-checkbox" type="checkbox" value="{{ $cat->id }}" id="cat_{{ $cat->id }}" name="categories[]">
                                            <label class="form-check-label" for="cat_{{ $cat->id }}">{{ $cat->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Brand Filter --}}
                            <div class="filter-group">
                                <h5 class="filter-group-title">Companies / Brands</h5>
                                <div style="max-height: 200px; overflow-y: auto;">
                                    @foreach($allBrands as $brand)
                                        <div class="form-check custom-checkbox mb-2">
                                            <input class="form-check-input filter-checkbox" type="checkbox" value="{{ $brand->id }}" id="brand_{{ $brand->id }}" name="brands[]">
                                            <label class="form-check-label" for="brand_{{ $brand->id }}">{{ $brand->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right Side: Products & Search --}}
                <div class="col-lg-9 col-12">

                    {{-- Global Search Bar & Toolbar --}}
                    <div class="row custom-toolbar align-items-center g-3 mx-0 shadow-sm">
                        <div class="col-md-5 col-12 d-flex align-items-center">
                            <label class="me-2 fw-bold text-secondary">Show</label>
                            <select id="per_page" class="form-select form-select-sm w-auto border-secondary">
                                <option value="10" selected>10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                            </select>
                        </div>

                        <div class="col-md-7 col-12 text-md-end">
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                                <input type="text" id="search" class="form-control form-control-lg border-start-0 ps-0" placeholder="Search by Product Name or Code...">
                            </div>
                        </div>
                    </div>

                    {{-- Products Container --}}
                    <div id="product-list-container">
                        @include('front.product.all_products_data')
                    </div>

                    <input type="hidden" id="ajax_url" value="{{ route('front.allProducts') }}">
                </div>

            </div>
        </div>
    </section>
</main>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {

        function fetch_data(page) {
            var search = $('#search').val();
            var per_page = $('#per_page').val();
            var url = $('#ajax_url').val();

            var categories = [];
            $('input[name="categories[]"]:checked').each(function() {
                categories.push($(this).val());
            });

            var brands = [];
            $('input[name="brands[]"]:checked').each(function() {
                brands.push($(this).val());
            });

            $('#product-list-container').addClass('loading-overlay');

            $.ajax({
                url: url,
                type: "GET",
                data: {
                    page: page,
                    search: search,
                    per_page: per_page,
                    categories: categories,
                    brands: brands
                },
                success: function (data) {
                    $('#product-list-container').html(data);
                    $('#product-list-container').removeClass('loading-overlay');
                },
                error: function(xhr) {
                    console.log('Error:', xhr);
                    $('#product-list-container').removeClass('loading-overlay');
                }
            });
        }

        // Search trigger with a slight delay (Debounce) to avoid too many requests
        var searchTimer;
        $(document).on('keyup', '#search', function () {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(function() {
                fetch_data(1);
            }, 300);
        });

        $(document).on('change', '#per_page, .filter-checkbox', function () {
            fetch_data(1);
        });

        $(document).on('click', '.ajax-page-link', function (event) {
            event.preventDefault();
            var page = $(this).data('page');
            fetch_data(page);
            // Scroll to top of the list slightly
            $('html, body').animate({
                scrollTop: $("#product-list-container").offset().top - 100
            }, 500);
        });
    });
</script>
@endsection
