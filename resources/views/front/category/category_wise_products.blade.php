@extends('front.master.master')

@section('title')
    {{ $category->name }} - Products - {{ $front_ins_name }}
@endsection

@section('css')
<style>
    /* লোডার ডিজাইন */
    .ajax-load {
        background: #fff;
        padding: 20px 0px;
        width: 100%;
        text-align: center;
        display: none; /* শুরুতে হাইড */
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

    /* Custom Button Colors */
    .custom-btn-solid {
        background-color: #a1573c !important;
        border-color: #a1573c !important;
        color: #ffffff !important;
    }
    .custom-btn-solid:hover {
        background-color: #874932 !important;
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

    /* Mobile Responsive Adjustments */
    @media (max-width: 767px) {
        .product-title-text {
            font-size: 14px !important;
            line-height: 1.3;
            display: block;
            word-wrap: break-word;
        }
        .product-meta-item {
            font-size: 12px !important;
            display: inline-block;
            margin-top: 3px;
            white-space: normal !important;
        }
        .btn-mobile-text {
            font-size: 11px !important;
            padding: 5px 2px !important;
        }
    }
</style>
@endsection

@section('body')
<main>
    <section class="section product_page">
        <div class="container">
            <div class="mt-5 mb-5">
                {{-- ডাইনামিক টাইটেল --}}
                <h2 class="home_category_title">{{ $category->name }}</h2>

                {{-- ডেসক্রিপশন --}}
                <p>
                    @if($category->description)
                        {!! $category->description !!}
                    @else
                        Cellexa is an independent provider of {{ $category->name }} from the major manufacturers.
                    @endif
                </p>
            </div>

            <div class="productpage_company_logo">
                <div class="row g-3" id="product-data-container">
                    {{-- প্রথমে include করা হবে --}}
                    @include('front.category.product_data')
                </div>
            </div>

            <div class="ajax-load text-center">
                <p><i class="fa fa-spinner fa-spin"></i> Loading More Products...</p>
            </div>

            @if($products->count() == 0)
                <div class="text-center mt-4">
                    <p class="text-muted">No products found in this category.</p>
                </div>
            @endif

        </div>
    </section>
</main>
@endsection

@section('scripts')
<script>
    // স্ক্রল প্যাজিনেশন স্ক্রিপ্ট
    var page = 1;
    var isLoading = false;
    var hasMoreData = true;

    $(window).scroll(function() {
        // পেজের নিচে আসার ৫০০px আগে লোড শুরু হবে
        if ($(window).scrollTop() + $(window).height() >= $(document).height() - 500) {
            if (!isLoading && hasMoreData) {
                page++;
                loadMoreData(page);
            }
        }
    });

    function loadMoreData(page) {
        isLoading = true;
        $('.ajax-load').show(); // লোডার দেখান

        $.ajax({
            url: '?page=' + page,
            type: "get",
            beforeSend: function() {
                // রিকোয়েস্টের আগে কিছু করার থাকলে
            }
        })
        .done(function(data) {
            isLoading = false;
            $('.ajax-load').hide(); // লোডার লুকান

            if (data.trim() == "") {
                hasMoreData = false;
                $('.ajax-load').html("No more products found");
                return;
            }

            // নতুন ডাটা যোগ করুন
            $("#product-data-container").append(data);
        })
        .fail(function(jqXHR, ajaxOptions, thrownError) {
            isLoading = false;
            $('.ajax-load').hide();
            console.log('Server error');
        });
    }
</script>
@endsection
