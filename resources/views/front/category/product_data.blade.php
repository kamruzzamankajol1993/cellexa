@foreach($products as $product)
<div class="col-lg-6 col-12">
    {{-- প্রোডাক্ট ডিটেইলস লিংক --}}
    <a href="{{ route('front.product.details', $product->slug) }}">
        <div class="cellexa_item_box">
            <div class="cellexa_item_box_img1">
                {{-- ইমেজ ডিকোড এবং ডিসপ্লে --}}
                @php
                    $images = json_decode($product->thumbnail_image);
                    $thumb = (is_array($images) && count($images) > 0) ? $images[0] : 'default.png';
                @endphp
                <img src="{{ asset('public/'.$thumb) }}" alt="{{ $product->name }}">
            </div>
            
            <div class="cellexa_item_box_text1">
                {{-- নাম এবং লিমিট --}}
                <h1>{{ Str::limit($product->name, 50) }}</h1>
                
                <div class="cellexa_item_box_list">
                    {{-- ডেসক্রিপশন স্ট্রিপ ট্যাগ এবং লিমিট --}}
                    <div class="product-short-desc text-muted">
                        {!! Str::limit(strip_tags($product->description), 150) !!}
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>
@endforeach