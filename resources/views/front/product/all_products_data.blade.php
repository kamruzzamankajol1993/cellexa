@forelse($products as $product)
    <div class="card mb-3 shadow-sm border-0">
        <div class="row g-0 align-items-center">
            
            {{-- বাম পাশে ইমেজ --}}
            <div class="col-md-3 col-4">
                @php
                    $productImages = $product->thumbnail_image; 
                    if (is_array($productImages) && count($productImages) > 0) {
                        $thumb = 'uploads/' . $productImages[0];
                    } elseif ($product->brand && $product->brand->logo) {
                        $thumb = $product->brand->logo;
                    } else {
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
                                <span class="badge bg-secondary"><i class="bi bi-tags"></i> {{ $product->category->name ?? 'Uncategorized' }}</span> | 
                                <span class="text-primary fw-bold"><i class="bi bi-building"></i> {{ $product->brand->name ?? 'No Company' }}</span>
                            </p>
                        </div>
                        {{-- প্রাইস (যদি দেখাতে চান) --}}
                        {{-- <div class="text-end">
                            <span class="fs-5 fw-bold text-success">৳{{ $product->base_price }}</span>
                        </div> --}}
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
        <i class="bi bi-search display-1 text-muted mb-3"></i>
        <h4 class="text-muted">No products found</h4>
        <p class="text-muted">Try adjusting your filters or search term.</p>
    </div>
@endforelse

{{-- Pagination --}}
<div class="row mt-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div class="text-muted small">
            Showing {{ $products->firstItem() ?? 0 }} to {{ $products->lastItem() ?? 0 }} of {{ $products->total() }} results
        </div>
        
        @if ($products->hasPages())
        <nav>
            <ul class="pagination pagination-sm mb-0">
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