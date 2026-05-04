@extends('front.master.master')

@section('title')
Shopping Cart - {{ $front_ins_name }}
@endsection

@section('css')
<style>
    /* Minimalist Monochromatic Theme */
    :root {
        --cellexa-cart-bg: #ffffff;
        --cellexa-cart-text: #111111;
        --cellexa-cart-text-muted: #666666;
        --cellexa-cart-border: #d1d5db;
        --cellexa-cart-border-dark: #222222;
    }

    .cellexa_cart_container {
        max-width: 1200px;
        margin: 60px auto;
        padding: 0 20px;
        font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
        color: var(--cellexa-cart-text);
    }

    .cellexa_cart_page_header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--cellexa-cart-border);
    }

    .cellexa_cart_page_title {
        font-size: 26px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin: 0;
    }

    .cellexa_cart_layout {
        display: flex;
        gap: 40px;
        align-items: flex-start;
    }

    @media (max-width: 900px) {
        .cellexa_cart_layout { flex-direction: column; }
        .cellexa_cart_right { width: 100% !important; }
    }

    .cellexa_cart_left { flex: 1; }
    .cellexa_cart_right { width: 380px; }

    .cellexa_cart_item {
        display: flex;
        align-items: center;
        gap: 25px;
        padding: 30px 0;
        border-bottom: 1px solid var(--cellexa-cart-border);
        position: relative;
    }

    .cellexa_cart_item_image_box {
        width: 160px;
        height: 160px;
        border: 1px solid var(--cellexa-cart-border-dark);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        padding: 10px;
        box-sizing: border-box;
    }

    .cellexa_cart_item_image_box img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .cellexa_cart_item_details {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-height: 160px;
    }

    .cellexa_cart_item_header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .cellexa_cart_item_title {
        font-size: 16px;
        font-weight: 600;
        text-transform: uppercase;
        margin: 0;
        line-height: 1.4;
    }

    .cellexa_cart_item_desc {
        font-size: 13px;
        color: var(--cellexa-cart-text-muted);
        margin: 6px 0 0 0;
        line-height: 1.4;
        max-width: 90%;
    }

    .cellexa_cart_item_remove {
        background: none;
        border: 1px solid black;
        font-size: 18px;
        cursor: pointer;
        color: var(--cellexa-cart-text);
        padding: 5px;
        line-height: 1;
    }

    .cellexa_cart_item_controls {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 15px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .cellexa_cart_company_text {
        font-size: 13px;
        font-weight: 600;
        color: var(--cellexa-cart-text);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: 1px solid var(--cellexa-cart-border-dark);
        padding: 10px 15px;
        display: inline-block;
    }

    .cellexa_cart_qty_box {
        display: flex;
        align-items: center;
        border: 1px solid var(--cellexa-cart-border-dark);
        height: 40px;
    }

    .cellexa_cart_qty_btn {
        background: transparent;
        border: none;
        width: 30px;
        height: 100%;
        cursor: pointer;
        font-size: 16px;
    }

    .cellexa_cart_qty_input {
        width: 40px;
        text-align: center;
        border: none;
        font-size: 14px;
        font-weight: 500;
        outline: none;
    }

    .cellexa_cart_summary_box {
        border: 1px solid var(--cellexa-cart-border-dark);
        padding: 30px;
    }

    .cellexa_cart_summary_title {
        font-size: 16px;
        font-weight: 700;
        text-transform: uppercase;
        margin: 0 0 25px 0;
        letter-spacing: 0.5px;
    }

    .cellexa_cart_form { display: flex; flex-direction: column; gap: 20px; }
    .cellexa_cart_form_group { display: flex; flex-direction: column; gap: 5px; }

    .cellexa_cart_label {
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        color: var(--cellexa-cart-text);
        letter-spacing: 0.5px;
    }

    .cellexa_cart_input {
        width: 100%;
        border: none;
        border-bottom: 1px solid var(--cellexa-cart-border);
        padding: 12px 0;
        font-size: 13px;
        outline: none;
        border-radius: 0;
        font-family: inherit;
        text-transform: uppercase;
        color: var(--cellexa-cart-text);
    }

    .cellexa_cart_textarea { resize: vertical; min-height: 80px; }

    .cellexa_cart_submit_btn {
        background: var(--cellexa-cart-border-dark);
        color: white;
        border: none;
        padding: 18px;
        width: 100%;
        font-size: 14px;
        font-weight: 600;
        text-transform: uppercase;
        cursor: pointer;
        margin-top: 25px;
        letter-spacing: 1px;
        transition: background 0.2s;
    }

    .cellexa_cart_submit_btn:hover { background: #000000; }

    /* Modal Styles */
    .cellexa_cart_modal {
        display: none; position: fixed; z-index: 1000; left: 0; top: 0;
        width: 100%; height: 100%; overflow: auto;
        background-color: rgba(0,0,0,0.5); backdrop-filter: blur(4px);
    }

    .cellexa_cart_modal_content {
        background-color: var(--cellexa-cart-bg);
        margin: 15% auto; padding: 40px;
        border: 1px solid var(--cellexa-cart-border-dark);
        width: 90%; max-width: 450px;
        position: relative; text-align: center;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    }

    .cellexa_cart_modal_close {
        color: var(--cellexa-cart-text-muted);
        position: absolute; top: 15px; right: 20px;
        font-size: 28px; font-weight: bold; cursor: pointer;
    }

    .cellexa_cart_success_icon { margin: 0 auto 20px auto; width: 60px; height: 60px; }

    .cellexa_cart_checkmark {
        width: 100%; height: 100%; border-radius: 50%;
        display: block; stroke-width: 4; stroke: var(--cellexa-cart-border-dark);
        animation: scale .3s ease-in-out .9s both;
    }

    .cellexa_cart_checkmark_circle {
        stroke-dasharray: 166; stroke-dashoffset: 166; stroke-width: 4;
        stroke: var(--cellexa-cart-border-dark); fill: none;
        animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
    }

    .cellexa_cart_checkmark_check {
        stroke-dasharray: 48; stroke-dashoffset: 48;
        animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.6s forwards;
    }

    @keyframes stroke { 100% { stroke-dashoffset: 0; } }
    @keyframes scale { 0%, 100% { transform: none; } 50% { transform: scale3d(1.1, 1.1, 1); } }

    .cellexa_cart_modal_title { font-size: 22px; font-weight: 700; text-transform: uppercase; margin-bottom: 15px; }
    .cellexa_cart_modal_text { font-size: 14px; color: var(--cellexa-cart-text-muted); line-height: 1.6; margin-bottom: 30px; }
    .cellexa_cart_modal_ok_btn {
        background: var(--cellexa-cart-border-dark); color: white; border: none;
        padding: 12px 30px; font-size: 14px; font-weight: 600; text-transform: uppercase;
        cursor: pointer; letter-spacing: 1px;
    }
</style>
@endsection

@section('body')
<div class="cellexa_cart_container">
    <div class="cellexa_cart_page_header">
        <h1 class="cellexa_cart_page_title">Shopping Cart</h1>
    </div>

    <div class="cellexa_cart_layout">
        <!-- Left Side: Products -->
        <div class="cellexa_cart_left">
            @php $cart = session()->get('cart', []); @endphp

            @if(count($cart) > 0)
                @foreach($cart as $id => $details)
                <div class="cellexa_cart_item" id="cart-item-{{ $id }}">
                   <div class="cellexa_cart_item_image_box">
    <img src="{{ asset('public/'.$details['image']) }}"
         alt="{{ $details['name'] }}"
         onerror="this.src='{{ asset('public/no-image.png') }}'">
</div>

                    <div class="cellexa_cart_item_details">
                        <div class="cellexa_cart_item_header">
                            <div>
                                <h2 class="cellexa_cart_item_title">{{ $details['name'] }}</h2>
                                <p class="cellexa_cart_item_desc">Product Code: {{ $details['code'] ?? 'N/A' }}</p>
                            </div>
                            <button class="cellexa_cart_item_remove remove-from-cart" data-id="{{ $id }}">✕</button>
                        </div>

                        <div class="cellexa_cart_item_controls">
                            <div class="cellexa_cart_select_group">
                                <span class="cellexa_cart_company_text">Company: {{ $front_ins_name }}</span>
                            </div>

                            <div class="cellexa_cart_qty_box">
                                <button type="button" class="cellexa_cart_qty_btn cart-qty-minus" data-id="{{ $id }}">−</button>
                                <input type="number" class="cellexa_cart_qty_input cart-qty-input" value="{{ $details['quantity'] }}" min="1" readonly>
                                <button type="button" class="cellexa_cart_qty_btn cart-qty-plus" data-id="{{ $id }}">+</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="text-center py-5">
                    <h4 class="text-muted">Your cart is empty</h4>
                    <a href="{{ route('front.index') }}" class="btn btn-dark mt-3">Continue Shopping</a>
                </div>
            @endif
        </div>

        <!-- Right Side: Contact Form -->
        <div class="cellexa_cart_right">
            <div class="cellexa_cart_summary_box">
                <h3 class="cellexa_cart_summary_title">Your Information</h3>

                <form id="quote_submission_form" class="cellexa_cart_form">
                    @csrf
                    <div class="cellexa_cart_form_group">
                        <label class="cellexa_cart_label">Full Name *</label>
                        <input type="text" name="name" class="cellexa_cart_input" value="{{ Auth::user()->name ?? '' }}" placeholder="JOHN DOE" required>
                    </div>

                    <div class="cellexa_cart_form_group">
                        <label class="cellexa_cart_label">Company Name</label>
                        <input type="text" name="company" class="cellexa_cart_input" value="{{ $customer->company_name ?? '' }}" placeholder="YOUR COMPANY LTD.">
                    </div>

                    <div class="cellexa_cart_form_group">
                        <label class="cellexa_cart_label">Phone Number *</label>
                        <input type="tel" name="phone" class="cellexa_cart_input" value="{{ $customer->phone ?? '' }}" placeholder="+1 (555) 000-0000" required>
                    </div>

                    <div class="cellexa_cart_form_group">
                        <label class="cellexa_cart_label">Email Address *</label>
                        <input type="email" name="email" class="cellexa_cart_input" value="{{ Auth::user()->email ?? '' }}" placeholder="JOHN@EXAMPLE.COM" required>
                    </div>

                    <div class="cellexa_cart_form_group">
                        <label class="cellexa_cart_label">Address *</label>
                        <textarea name="address" class="cellexa_cart_input cellexa_cart_textarea" placeholder="YOUR FULL ADDRESS..." required>{{ $customer->address ?? '' }}</textarea>
                    </div>

                    <button type="submit" class="cellexa_cart_submit_btn">Ask for Price</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div id="cellexa_cart_success_modal" class="cellexa_cart_modal">
    <div class="cellexa_cart_modal_content">
        <span class="cellexa_cart_modal_close">&times;</span>
        <div class="cellexa_cart_success_icon">
            <svg class="cellexa_cart_checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                <circle class="cellexa_cart_checkmark_circle" cx="26" cy="26" r="25" fill="none"/>
                <path class="cellexa_cart_checkmark_check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
            </svg>
        </div>
        <h3 class="cellexa_cart_modal_title">Success!</h3>
        <p class="cellexa_cart_modal_text">
            Price quotation successfully submitted. We will get back to you within a short time. Please be patient, and if you have any queries, let us know via email at <strong>{{ $front_ins_email ?? 'info@cellexa.com' }}</strong>.
        </p>
        <button class="cellexa_cart_modal_ok_btn">OK</button>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        const modal = $('#cellexa_cart_success_modal');

        // Form Submission
        $('#quote_submission_form').on('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Submitting...',
                allowOutsideClick: false,
                didOpen: () => { Swal.showLoading(); }
            });

            $.ajax({
                url: "{{ route('front.submitQuoteUpdate') }}",
                type: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    Swal.close();
                    if(response.status === 'success') {
                        modal.show();
                    } else {
                        Swal.fire('Error', response.message, 'error');
                    }
                },
                error: function() {
                    Swal.close();
                    Swal.fire('Error', 'Something went wrong!', 'error');
                }
            });
        });

        // Modal Controls
        $('.cellexa_cart_modal_close, .cellexa_cart_modal_ok_btn').on('click', function() {
            modal.hide();
            window.location.href = "{{ route('front.userDashboard') }}?tab=quotes";
        });

        $(window).on('click', function(e) {
            if ($(e.target).is(modal)) {
                modal.hide();
            }
        });

        // Quantity Update (Reuse existing logic if available in master)
        $('.cart-qty-plus, .cart-qty-minus').on('click', function() {
            var id = $(this).data('id');
            var isPlus = $(this).hasClass('cart-qty-plus');
            var input = $(this).siblings('.cart-qty-input');
            var currentVal = parseInt(input.val());
            var newVal = isPlus ? currentVal + 1 : currentVal - 1;

            if (newVal < 1) return;

            $.ajax({
                url: "{{ route('front.updateCartQty') }}",
                method: "POST",
                data: { id: id, quantity: newVal },
                success: function(response) {
                    if (response.status === 'success') {
                        input.val(newVal);
                    }
                }
            });
        });

        // Remove from Cart
        $('.remove-from-cart').on('click', function() {
            var id = $(this).data('id');
            $.ajax({
                url: "{{ route('front.removeFromCart') }}",
                method: "POST",
                data: { id: id },
                success: function(response) {
                    if (response.status === 'success') {
                        $('#cart-item-' + id).remove();
                        if($('.cellexa_cart_item').length === 0) {
                            location.reload();
                        }
                    }
                }
            });
        });
    });
</script>
@endsection
