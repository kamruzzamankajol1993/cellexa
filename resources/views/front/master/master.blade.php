<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="{{ $front_ins_name }} -  {{ $front_ins_title }}">
    <meta name="robots" content="">
    <meta name="keywords" content="{{ $front_ins_k }}">
    <meta name="description" content="{{ $front_ins_d }}">
    <meta property="og:title" content="{{ $front_ins_name }} -  {{ $front_ins_title }}">
    <meta property="og:description" content="{{ $front_ins_d }}">
    <meta property="og:image" content="{{ asset('/') }}{{ $front_logo_name }}">
    <title>@yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('/') }}{{ $front_icon_name }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,100..700;1,100..700&display=swap"
        rel="stylesheet">

    <link href="{{ asset('/') }}public/front/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('/') }}public/front/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('/') }}public/front/assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="{{ asset('/') }}public/front/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="{{ asset('/') }}public/front/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <link href="{{ asset('/') }}public/front/assets/css/main.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    @yield('css')
    <style>
        @media (min-width: 992px) {
    .nav-item.dropdown:hover .dropdown-menu {
        display: block;
        margin-top: 0; 
    }
}
  /* Search Icon Custom Styling */
.btn-search {
    background-color: #ffffff; /* ব্যাকগ্রাউন্ড সাদা */
    color: #0d6efd;           /* আইকন কালার নীল */
    border: 1px solid #0d6efd; /* বর্ডার */
    width: 35px;
    height: 35px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;      /* গোল করার জন্য */
    transition: all 0.3s ease;
    text-decoration: none;
}

.btn-search:hover {
    background-color: #0d6efd; /* হোভার করলে ব্যাকগ্রাউন্ড নীল */
    color: #ffffff;           /* আইকন সাদা */
    transform: translateY(-2px); /* সামান্য উপরে উঠবে */
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.btn-search i {
    font-size: 16px; /* আইকন সাইজ */
    font-weight: bold;
}

/* যদি আপনি সোশ্যাল বাটনের মতো চারকোনা ব্যাকগ্রাউন্ড চান (যেমন ফেসবুক/ইউটিউব) */
.btn-search {
    background-color: #6c757d; 
    color: #fff;
    width: 45px;
    height: 45px;
    border-radius: 4px;
}
.cellexa_search_input_group {
    border: 2px solid #f1f1f1;
    border-radius: 50px; /* পিল শেপ সার্চ বার */
    overflow: hidden;
    transition: border-color 0.3s;
}

.cellexa_search_input_group:focus-within {
    border-color: #0d6efd;
}

#cellexa_global_search_input {
    border: none !important;
    padding: 12px 20px;
    font-size: 16px;
}

.cellexa_search_input_group .input-group-text {
    border: none !important;
    padding-left: 20px;
}
    .cellexa_search_input_group .form-control:focus {
        border-color: #ced4da;
        box-shadow: none;
    }
    
    .cellexa_search_result_item {
        display: flex;
        align-items: center;
        padding: 10px;
        border-bottom: 1px solid #f1f1f1;
        text-decoration: none;
        color: #333;
        transition: background 0.2s;
    }
    
    .cellexa_search_result_item:hover {
        background-color: #f9f9f9;
        color: #198754; /* Success color on hover */
    }
    
    .cellexa_search_result_img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 5px;
        margin-right: 15px;
    }
    
    .cellexa_search_result_details h6 {
        margin: 0 0 3px 0;
        font-weight: 600;
        font-size: 14px;
    }
    
    .cellexa_search_result_details p {
        margin: 0;
        color: #777;
        font-size: 12px;
    }
    
    .cellexa_search_result_price {
        margin-left: auto;
        font-weight: bold;
        color: #198754;
    }
</style>
</head>

<body class="index-page">
    @include('front.include.header')
    @include('front.include.offcanvas')

    @yield('body')
    @include('front.include.footer')

    {{-- Cellexa Global Search Modal --}}
<div class="modal fade" id="cellexaSearchModal" tabindex="-1" aria-labelledby="cellexaSearchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fs-5" id="cellexaSearchModalLabel">Search Our Catalog</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-2">
                {{-- সার্চ ইনপুট ফিল্ড --}}
                <div class="input-group mb-3 cellexa_search_input_group">
                    <span class="input-group-text bg-white border-end-0" id="basic-addon1">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" id="cellexa_global_search_input" class="form-control border-start-0 ps-0 form-control-lg" placeholder="Type product name, code or category..." aria-label="Search Products">
                </div>
                
                {{-- সার্চ রেজাল্ট দেখানোর এরিয়া (ডিফল্টভাবে লুকানো থাকবে) --}}
                <div id="cellexa_search_results_container" style="display: none; max-height: 400px;">
                    <h6 class="text-muted border-bottom pb-2 mb-3">Search Results</h6>
                    <div id="cellexa_search_results_list">
                        {{-- AJAX এর মাধ্যমে এখানে রেজাল্ট লোড হবে --}}
                    </div>
                </div>
                
                {{-- লোডার (সার্চ করার সময় দেখাবে) --}}
                <div id="cellexa_search_loader" class="text-center py-4" style="display: none;">
                    <div class="spinner-border text-success" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="text-muted mt-2">Searching products...</p>
                </div>

                {{-- রেজাল্ট না পাওয়া গেলে এই বার্তা দেখাবে --}}
                <div id="cellexa_search_no_results" class="text-center py-4" style="display: none;">
                    <i class="bi bi-search-heart display-4 text-muted"></i>
                    <p class="text-muted mt-3">No products found matching your search.</p>
                </div>
            </div>
        </div>
    </div>
</div>



    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('/') }}public/front/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('/') }}public/front/assets/vendor/php-email-form/validate.js"></script>
    <script src="{{ asset('/') }}public/front/assets/vendor/aos/aos.js"></script>
    <script src="{{ asset('/') }}public/front/assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="{{ asset('/') }}public/front/assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="{{ asset('/') }}public/front/assets/vendor/purecounter/purecounter_vanilla.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('/') }}public/front/assets/js/main.js"></script>

    <script>
        // Setup CSRF Token for all AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
    
    $('#cellexaSearchModal').on('shown.bs.modal', function () {
        $('#cellexa_global_search_input').focus();
    });

    let searchTimer;
    const searchInput = $('#cellexa_global_search_input');
    const resultsContainer = $('#cellexa_search_results_container');
    const resultsList = $('#cellexa_search_results_list');
    const loader = $('#cellexa_search_loader');
    const noResults = $('#cellexa_search_no_results');

    searchInput.on('keyup', function() {
        clearTimeout(searchTimer);
        const query = $(this).val();

       
        if (query.length < 1) {
            resultsContainer.hide();
            noResults.hide();
            loader.hide();
            return;
        }

        searchTimer = setTimeout(function() {
            
            resultsContainer.hide();
            noResults.hide();
            loader.show();

            $.ajax({
                url: "{{ route('front.globalSearchProducts') }}", 
                type: "GET",
                data: { query: query },
                success: function(response) {
                    loader.hide(); 

                    if (response.status === 'success' && response.data.length > 0) {
                        resultsList.empty(); 
                        
                  
              $.each(response.data, function(index, product) {
    let productUrl = "{{ route('front.product.details', ':slug') }}";
    productUrl = productUrl.replace(':slug', product.slug);

    let defaultImg = "{{ asset('public/no-image.png') }}";
    let imgPath = defaultImg;

    // ১. মেইন ইমেজ (Array) হ্যান্ডেল করা
    if (product.main_image && Array.isArray(product.main_image) && product.main_image.length > 0) {
        imgPath = "{{ asset('public/uploads') }}/" + product.main_image[0];
    } else if (product.brand && product.brand.logo) {
        imgPath = "{{ asset('public') }}/" + product.brand.logo;
    }

    let imgHtml = '<img src="' + imgPath + '" class="cellexa_search_result_img" alt="' + product.name + '" onerror="this.src=\'' + defaultImg + '\'">';

    // ২. প্রাইস লজিক (Base Price vs Discount Price)
    let priceHtml = '';
    
    if (product.discount_price && product.discount_price > 0) {
        // ডিসকাউন্ট প্রাইস থাকলে
        priceHtml = '<div class="cellexa_search_result_price">' +
                        '<span class="text-danger text-decoration-line-through small me-2" style="font-size: 11px;">৳' + product.base_price + '</span>' +
                        '<span>৳' + product.discount_price + '</span>' +
                    '</div>';
    } else if (product.base_price && product.base_price > 0) {
        // শুধু বেস প্রাইস থাকলে
        priceHtml = '<div class="cellexa_search_result_price">৳' + product.base_price + '</div>';
    } else {
        // কোনো প্রাইস না থাকলে
        priceHtml = '<div class="cellexa_search_result_price"><span class="badge bg-primary px-2 py-1" style="font-size: 10px;">Asked For Price</span></div>';
    }

    let resultItem = '<a href="' + productUrl + '" class="cellexa_search_result_item">' +
        imgHtml +
        '<div class="cellexa_search_result_details">' +
            '<h6>' + product.name + '</h6>' +
            '<p class="mb-0">Code: ' + (product.product_code || 'N/A') + '</p>' +
        '</div>' +
        priceHtml +
    '</a>';
    
    resultsList.append(resultItem);
});

                        noResults.hide();
                        resultsContainer.show();
                    } else {
                        resultsList.empty();
                        resultsContainer.hide();
                        noResults.show();
                    }
                },
                error: function() {
                    loader.hide();
                    console.error('Cellexa Search Error: Unable to fetch products.');
                }
            });
        }, 250); // ২৫০ মিলি-সেকেন্ড ডিলে (Debounce)
    });
});

        // ==========================================
        // 1. CART FUNCTIONS
        // ==========================================
        function loadCart() {
            $.ajax({
                url: "{{ route('front.getCartContent') }}",
                method: "GET",
                success: function(response) {
                    $('#cart_dynamic_body').html(response);
                    // আইটেম রো গুনে কাউন্ট বের করা (নিশ্চিত করুন আপনার cart_content এ 'cart-item-row' ক্লাস আছে)
            let itemCount = $('#cart_dynamic_body').find('.cart-item-row').length; 
            updateCartBadge(itemCount);
                },
                error: function(xhr) {
                    console.error("Failed to load cart");
                }
            });
        }
function updateCartBadge(count) {
    let badge = $('#cart-count-badge');
    if (count > 0) {
        badge.text(count).fadeIn(); // সংখ্যাটি দেখাবে
        badge.css('display', 'inline-block'); // ফোর্স ডিসপ্লে
    } else {
        badge.hide(); // শুধু ০ হলে হাইড হবে
    }
}
        function addToCart(productId, quantity) {
            $.ajax({
                url: "{{ route('front.addToCart') }}",
                method: "POST",
                data: {
                    product_id: productId,
                    quantity: quantity
                },
                success: function(response) {
                    if (response.status === 'success') {
                        updateCartBadge(response.total_items);
                        loadCart();
                        var cartOffcanvas = new bootstrap.Offcanvas(document.getElementById('cellexaCartCanvas'));
                        cartOffcanvas.show();

                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true
                        });
                        Toast.fire({
                            icon: 'success',
                            title: response.message
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!',
                    });
                }
            });
        }

        // ==========================================
        // 2. AUTH & TAB SWITCHING LOGIC (Updated)
        // ==========================================
        function switchCellexaAuth(type) {
            const loginForm = document.getElementById('cellexaLoginForm');
            const registerForm = document.getElementById('cellexaRegisterForm');
            const forgotForm = document.getElementById('cellexaForgotForm');
            const authTabs = document.getElementById('auth_tabs_container');

            // Hide all forms first
            if (loginForm) loginForm.classList.remove('show');
            if (registerForm) registerForm.classList.remove('show');
            if (forgotForm) forgotForm.classList.remove('show');

            // Reset Forgot Password Steps
            $('#forgot_step_1').show();
            $('#forgot_step_2').hide();
            if ($('#forgot_check_email_form').length > 0) $('#forgot_check_email_form')[0].reset();
            if ($('#forgot_reset_password_form').length > 0) $('#forgot_reset_password_form')[0].reset();

            // Handle switching
            if (type === 'login') {
                if (loginForm) loginForm.classList.add('show');
                if (authTabs) authTabs.style.display = 'flex';
                $('.cellexa_company_category_auth_tab').eq(0).addClass('active');
                $('.cellexa_company_category_auth_tab').eq(1).removeClass('active');
            } else if (type === 'register') {
                if (registerForm) registerForm.classList.add('show');
                if (authTabs) authTabs.style.display = 'flex';
                $('.cellexa_company_category_auth_tab').eq(0).removeClass('active');
                $('.cellexa_company_category_auth_tab').eq(1).addClass('active');
            } else if (type === 'forgot') {
                if (forgotForm) forgotForm.classList.add('show');
                if (authTabs) authTabs.style.display = 'none'; // Hide tabs for cleaner UI
            }
        }

        // ==========================================
        // 3. QUOTE LOGIC
        // ==========================================
        var pendingQuoteRequest = false;

        function initiateQuoteRequest() {
            var isLoggedIn = "{{ Auth::check() ? 'true' : 'false' }}";

            if (isLoggedIn === 'true') {
                submitQuoteToAdmin();
            } else {
                pendingQuoteRequest = true;
                var cartCanvas = bootstrap.Offcanvas.getInstance(document.getElementById('cellexaCartCanvas'));
                if (cartCanvas) cartCanvas.hide();

                var profileCanvas = new bootstrap.Offcanvas(document.getElementById('cellexaProfileCanvas'));
                profileCanvas.show();

                switchCellexaAuth('login');

                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'info',
                    title: 'Please Login or Register to submit quote.',
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        }

        function submitQuoteToAdmin() {
            Swal.fire({
                title: 'Sending Request...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: "{{ route('front.submitQuote') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.status === 'success') {
                        loadCart();
                        Swal.fire({
                            icon: 'success',
                            title: 'Request Sent!',
                            text: response.message,
                            confirmButtonColor: '#0d6efd'
                        }).then(() => {
                            window.location.href = "{{ route('front.userDashboard') }}?tab=quotes";
                        });
                        pendingQuoteRequest = false;
                        var cartCanvas = bootstrap.Offcanvas.getInstance(document.getElementById(
                            'cellexaCartCanvas'));
                        if (cartCanvas) cartCanvas.hide();
                    } else {
                        Swal.fire('Error', response.message, 'error');
                    }
                },
                error: function() {
                    Swal.fire('Error', 'Failed to submit request.', 'error');
                }
            });
        }

        // ==========================================
        // 4. DOCUMENT READY HANDLERS
        // ==========================================
        $(document).ready(function() {
            // Load cart
            loadCart();

            // Cart Quantity Update
            $(document).on('click', '.cart-qty-plus, .cart-qty-minus', function() {
                var id = $(this).data('id');
                var inputField = $(this).siblings('.cart-qty-input');
                var currentVal = parseInt(inputField.val());
                var isPlus = $(this).hasClass('cart-qty-plus');
                var newVal = isPlus ? currentVal + 1 : currentVal - 1;

                if (newVal < 1) return;

                $.ajax({
                    url: "{{ route('front.updateCartQty') }}",
                    method: "POST",
                    data: {
                        id: id,
                        quantity: newVal
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            loadCart();
                        }
                    }
                });
            });

            // Cart Remove Item
            $(document).on('click', '.remove-from-cart', function() {
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want to remove this item from the list?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#0d6efd',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, remove it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('front.removeFromCart') }}",
                            method: "POST",
                            data: {
                                id: id
                            },
                            success: function(response) {
                                if (response.status === 'success') {
        loadCart();
        updateCartBadge(response.total_items); // রিমুভ করার পর ব্যাজ আপডেট
        Swal.fire('Removed!', 'Item has been removed.', 'success');
    }
                            }
                        });
                    }
                });
            });

            // Login Submit
            // Login Submit
$('#login_form_submit').submit(function(e) {
    e.preventDefault();
    var formData = $(this).serialize();

    // লগইন লোডার
    Swal.fire({
        title: 'Signing In...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    $.ajax({
        url: "{{ route('front.loginUserPost') }}",
        type: "POST",
        data: formData,
        success: function(response) {
            Swal.close();
            if (response.status === 'success') {
                if (pendingQuoteRequest === true) {
                    submitQuoteToAdmin();
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Login Successful',
                        timer: 1000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = response.redirect_url;
                    });
                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Login Failed',
                    text: response.message
                });
            }
        },
        error: function() {
            Swal.close();
            Swal.fire('Error', 'An error occurred. Please try again.', 'error');
        }
    });
});

            // Register Submit
            // Register Submit
$('#register_form_submit').submit(function(e) {
    e.preventDefault();
    var formData = $(this).serialize();

    // লোডার দেখানো হচ্ছে
    Swal.fire({
        title: 'Creating Account...',
        html: 'Please wait while we set up your profile.',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    $.ajax({
        url: "{{ route('front.registerUserPost') }}",
        type: "POST",
        data: formData,
        success: function(response) {
            Swal.close(); // লোডার বন্ধ
            if (response.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Registration Successful!',
                    text: 'Please login with your credentials.',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    // রেজিস্ট্রেশন সফল হলে লগইন ফর্ম ওপেন করা হচ্ছে
                    switchCellexaAuth('login');
                    // ফর্ম রিসেট করে দেওয়া হচ্ছে
                    $('#register_form_submit')[0].reset();
                });
            } else {
                let msg = response.message;
                if (response.errors) msg = Object.values(response.errors)[0][0];
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: msg
                });
            }
        },
        error: function() {
            Swal.close();
            Swal.fire('Error', 'Something went wrong during registration.', 'error');
        }
    });
});

            // --- FORGOT PASSWORD STEP 1: CHECK EMAIL ---
            $('#forgot_check_email_form').submit(function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                var emailVal = $(this).find('input[name="email"]').val();

                Swal.fire({
                    title: 'Checking...',
                    didOpen: () => {
                        Swal.showLoading()
                    }
                });

                $.ajax({
                    url: "{{ route('front.checkEmailForReset') }}",
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        Swal.close();
                        if (response.status === 'success') {
                            // Show Step 2
                            $('#forgot_step_1').fadeOut(300, function() {
                                $('#forgot_step_2').fadeIn(300);
                            });

                            // Store email
                            $('#verified_email').val(emailVal);

                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000
                            });
                            Toast.fire({
                                icon: 'success',
                                title: 'Account found! Please reset password.'
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Not Found',
                                text: response.message
                            });
                        }
                    },
                    error: function() {
                        Swal.close();
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Something went wrong.'
                        });
                    }
                });
            });

            // --- FORGOT PASSWORD STEP 2: RESET PASSWORD ---
            $('#forgot_reset_password_form').submit(function(e) {
                e.preventDefault();
                var formData = $(this).serialize();

                Swal.fire({
                    title: 'Updating...',
                    didOpen: () => {
                        Swal.showLoading()
                    }
                });

                $.ajax({
                    url: "{{ route('front.directPasswordReset') }}",
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        Swal.close();
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: 'Password updated successfully. Please Login.',
                                confirmButtonText: 'Go to Login'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    switchCellexaAuth('login');
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.close();
                        let msg = 'Update failed.';
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            msg = Object.values(xhr.responseJSON.errors)[0][0];
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Validation Error',
                            text: msg
                        });
                    }
                });
            });

        });
    </script>
    @yield('scripts')

</body>

</html>