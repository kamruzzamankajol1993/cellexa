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

</head>

<body class="index-page">
    @include('front.include.header')
    @include('front.include.offcanvas')

    @yield('body')
    @include('front.include.footer')

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

        // ==========================================
        // 1. CART FUNCTIONS
        // ==========================================
        function loadCart() {
            $.ajax({
                url: "{{ route('front.getCartContent') }}",
                method: "GET",
                success: function(response) {
                    $('#cart_dynamic_body').html(response);
                },
                error: function(xhr) {
                    console.error("Failed to load cart");
                }
            });
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
                                    Swal.fire('Removed!',
                                        'Item has been removed from your list.',
                                        'success');
                                }
                            }
                        });
                    }
                });
            });

            // Login Submit
            $('#login_form_submit').submit(function(e) {
                e.preventDefault();
                var formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('front.loginUserPost') }}",
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        if (response.status === 'success') {
                            if (pendingQuoteRequest === true) {
                                submitQuoteToAdmin();
                            } else {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Login Successful',
                                    timer: 1500,
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
                    }
                });
            });

            // Register Submit
            $('#register_form_submit').submit(function(e) {
                e.preventDefault();
                var formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('front.registerUserPost') }}",
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        if (response.status === 'success') {
                            if (pendingQuoteRequest === true) {
                                submitQuoteToAdmin();
                            } else {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Registered!',
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => {
                                    window.location.href = response.redirect_url;
                                });
                            }
                        } else {
                            // Handle errors better if needed
                            let msg = response.message;
                            if (response.errors) msg = Object.values(response.errors)[0][0];
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: msg
                            });
                        }
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