@foreach($products as $product)
<div class="col-12">
    <div class="card mb-3 shadow-sm border-0">
        <div class="row g-0 align-items-center">
            
            {{-- বাম পাশে ইমেজ --}}
            <div class="col-md-3 col-4">
                @php
                    $images = $product->thumbnail_image;
                    // চেক করা হচ্ছে ইমেজ অ্যারে কিনা
                    $thumb = (is_array($images) && count($images) > 0) ? $images[0] : 'default.png';
                @endphp
                <div class="product-list-img-container rounded-start">
                    @if (is_array($images) && count($images) > 0)
                        <img src="{{ asset('public/uploads/'.$thumb) }}" 
                             class="product-list-img" 
                             alt="{{ $product->name }}"
                             onerror="this.src='{{ asset('public/No_Image_Available.jpg') }}'">
                    @else
                        <img src="{{ asset('public/'.$thumb) }}" 
                             class="product-list-img" 
                             alt="{{ $product->name }}"
                             onerror="this.src='{{ asset('public/No_Image_Available.jpg') }}'">
                    @endif
                </div>
            </div>

            {{-- ডান পাশে ইনফরমেশন --}}
            <div class="col-md-9 col-8">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h4 class="card-title fw-bold mb-1">
                                <a href="{{ route('front.product.details', $product->slug) }}" class="text-dark text-decoration-none">
                                    {{ $product->name }}
                                </a>
                            </h4>
                            <p class="text-muted small mb-2">
                                <i class="bi bi-upc-scan"></i> Code: {{ $product->product_code ?? 'N/A' }} | 
                                {{-- ক্যাটাগরির নাম বাদ দেওয়া হয়েছে --}}
                                <span class="text-primary fw-bold"><i class="bi bi-building"></i> {{ $product->brand->name ?? 'No Company' }}</span>
                            </p>
                        </div>
                    </div>

                    <p class="card-text text-muted mt-2 d-none d-md-block">
                        {!! Str::limit(strip_tags($product->description), 180) !!}
                    </p>

                    <div class="mt-3">
                        <a href="{{ route('front.product.details', $product->slug) }}" class="btn btn-outline-primary btn-sm me-2">
                            <i class="bi bi-eye"></i> View Details
                        </a>
                        <button class="btn btn-primary btn-sm" onclick="addToCart({{ $product->id }}, 1)">
                            <i class="bi bi-cart-plus"></i> Add To Cart
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach