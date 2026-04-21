@forelse($products as $product)
    <div class="card mb-3 shadow-sm border-0">
        <div class="row g-0 align-items-center">
            
            {{-- বাম পাশে ইমেজ --}}
            <div class="col-md-3 col-4">
                @php
                    // ১. প্রথমে প্রোডাক্ট ইমেজ আছে কিনা চেক
                    $productImages = $product->thumbnail_image; 
                    
                    if (is_array($productImages) && count($productImages) > 0) {
                        $thumb = 'uploads/' . $productImages[0];
                    } 
                    // ২. প্রোডাক্ট ইমেজ না থাকলে, ব্র্যান্ড লোগো আছে কিনা চেক
                    elseif ($product->brand && $product->brand->logo) {
                        $thumb = $product->brand->logo;
                    } 
                    // ৩. কিছুই না থাকলে ডিফল্ট ইমেজ
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
@empty
    <div class="text-center py-5 bg-white shadow-sm rounded">
        <i class="bi bi-box-seam display-1 text-muted mb-3"></i>
        <h4 class="text-muted">No products found matching your criteria.</h4>
        <p class="text-muted">Try adjusting your filters or search term.</p>
    </div>
@endforelse

{{-- Pagination Block --}}
<div class="row mt-4 align-items-center">
    <div class="col-md-5 col-12 text-center text-md-start mb-3 mb-md-0">
        <p class="text-muted mb-0">
            Showing <span class="fw-bold">{{ $products->firstItem() ?? 0 }}</span> to <span class="fw-bold">{{ $products->lastItem() ?? 0 }}</span> of <span class="fw-bold">{{ $products->total() }}</span> results
        </p>
    </div>
    <div class="col-md-7 col-12">
        @if ($products->hasPages())
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center justify-content-md-end mb-0 custom-pagination">
                @if ($products->onFirstPage())
                    <li class="page-item disabled"><span class="page-link"><i class="bi bi-chevron-left"></i> Prev</span></li>
                @else
                    <li class="page-item"><a class="page-link ajax-page-link" href="#" data-page="{{ $products->currentPage() - 1 }}"><i class="bi bi-chevron-left"></i> Prev</a></li>
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
                    <li class="page-item"><a class="page-link ajax-page-link" href="#" data-page="{{ $products->currentPage() + 1 }}">Next <i class="bi bi-chevron-right"></i></a></li>
                @else
                    <li class="page-item disabled"><span class="page-link">Next <i class="bi bi-chevron-right"></i></span></li>
                @endif
            </ul>
        </nav>
        @endif
    </div>
</div>