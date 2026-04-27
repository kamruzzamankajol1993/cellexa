@forelse($products as $product)
    <div class="card mb-3 shadow-sm border-0">
        <div class="row g-0 align-items-center">

            {{-- বাম পাশে ইমেজ --}}
            <div class="col-md-3 col-4">
                @php
                    $productImages = $product->thumbnail_image;

                    if (is_array($productImages) && count($productImages) > 0) {
                        $thumb = 'uploads/' . $productImages[0];
                    }
                    elseif ($product->brand && $product->brand->logo) {
                        $thumb = $product->brand->logo;
                    }
                    else {
                        $thumb = 'No_Image_Available.jpg';
                    }
                @endphp
                <div class="product-list-img-container rounded-start">
                    <img src="{{ asset('public/'.$thumb) }}"
                         class="product-list-img"
                         alt="{{ $product->name }}"
                         onerror="this.src='{{ asset('public/No_Image_Available.jpg') }}'">
                </div>
            </div>

            {{-- ডান পাশে ইনফরমেশন --}}
            <div class="col-md-9 col-8">
                <div class="card-body p-2 p-md-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="w-100 overflow-hidden">
                            <h4 class="card-title fw-bold mb-1">
                                <a href="{{ route('front.product.details', $product->slug) }}" class="text-dark text-decoration-none product-title-text">
                                    {{ $product->name }}
                                </a>
                            </h4>
                            <p class="text-muted small mb-2">
                                <span class="product-meta-item"><i class="bi bi-upc-scan"></i> Code: {{ $product->product_code ?? 'N/A' }}</span> |
                                <span class="text-primary fw-bold product-meta-item" style="color: #a1573c !important;"><i class="bi bi-building"></i> {{ $product->brand->name ?? 'No Company' }}</span>
                            </p>
                        </div>
                    </div>

                    <p class="card-text text-muted mt-2 d-none d-md-block">
                        {!! Str::limit(strip_tags($product->description), 180) !!}
                    </p>

                    {{-- 50-50 Buttons Grid --}}
                    <div class="mt-2 mt-md-3 row g-2">
                        <div class="col-6">
                            <a href="{{ route('front.product.details', $product->slug) }}" class="btn custom-btn-outline btn-sm w-100 btn-mobile-text">
                                <i class="bi bi-eye"></i> View Details
                            </a>
                        </div>
                        <div class="col-6">
                            <button class="btn custom-btn-solid btn-sm w-100 btn-mobile-text" onclick="addToCart({{ $product->id }}, 1)">
                                <i class="bi bi-cart-plus"></i> Add To Cart
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@empty
    <div class="text-center py-5 bg-white shadow-sm rounded">
        <i class="bi bi-box-seam display-1 text-muted mb-3"></i>
        <h4 class="text-muted">No products found matching your criteria.</h4>
        <p class="text-muted">Try adjusting your filters or search term.</p>
    </div>
@endforelse

{{-- Pagination Block --}}
<div class="row mt-4 align-items-center pagination-container">
    <div class="col-12 d-flex flex-column flex-md-row justify-content-between align-items-center">
        <div class="text-muted small mb-3 mb-md-0 text-center text-md-start">
            Showing <span class="fw-bold">{{ $products->firstItem() ?? 0 }}</span> to <span class="fw-bold">{{ $products->lastItem() ?? 0 }}</span> of <span class="fw-bold">{{ $products->total() }}</span> results
        </div>

        @if ($products->hasPages())
        <nav aria-label="Page navigation">
            <ul class="pagination custom-pagination pagination-sm mb-0">
                @if ($products->onFirstPage())
                    <li class="page-item disabled"><span class="page-link">Prev</span></li>
                @else
                    <li class="page-item"><a class="page-link ajax-page-link" href="#" data-page="{{ $products->currentPage() - 1 }}">Prev</a></li>
                @endif

                @foreach ($products->links()->elements as $element)
                    @if (is_string($element))
                        <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                    @endif
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $products->currentPage())
                                <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                            @else
                                <li class="page-item"><a class="page-link ajax-page-link" href="#" data-page="{{ $page }}">{{ $page }}</a></li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                @if ($products->hasMorePages())
                    <li class="page-item"><a class="page-link ajax-page-link" href="#" data-page="{{ $products->currentPage() + 1 }}">Next</a></li>
                @else
                    <li class="page-item disabled"><span class="page-link">Next</span></li>
                @endif
            </ul>
        </nav>
        @endif
    </div>
</div>
