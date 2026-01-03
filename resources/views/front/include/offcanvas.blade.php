 <!-- FLOATING NAVIGATION (Right Side - Middle) -->
 <div class="cellexa_company_category_floating_nav">
     <button class="cellexa_company_category_nav_btn" data-bs-toggle="offcanvas" data-bs-target="#cellexaCartCanvas">
         <i class="bi bi-cart3 fs-4"></i>
         <span>Cart</span>
     </button>
     <!-- Horizontal Divider -->
     <div style="width: 24px; background: #ddd; height: 1px;"></div>
     <button class="cellexa_company_category_nav_btn" data-bs-toggle="offcanvas" data-bs-target="#cellexaProfileCanvas">
         <i class="bi bi-person-circle fs-4"></i>
         <span>Profile</span>
     </button>
 </div>


 <!-- CART OFFCANVAS -->
 <div class="offcanvas offcanvas-end" tabindex="-1" id="cellexaCartCanvas" aria-labelledby="cellexaCartCanvasLabel">
     <div class="offcanvas-header cellexa_company_category_offcanvas_header">
         <h5 class="offcanvas-title" id="cellexaCartCanvasLabel">Shopping Cart</h5>
         <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
     </div>
     <!-- Updated Body to allow scrolling of items while fixing footer -->
     <div class="offcanvas-body cellexa_company_category_offcanvas_body_flex">

         <!-- Scrollable Item List -->
         <div class="cellexa_company_category_cart_list_container">

             <!-- Item 1 -->
             <div class="cellexa_company_category_cart_item">
                 <img src="{{ asset('/') }}public/front/assets/img/company_category/product2.jpg" class="cellexa_company_category_cart_img"
                     alt="Product">
                 <div class="cellexa_company_category_cart_details">
                     <h6 class="mb-1">Altmann GC Columns</h6>
                     <!-- Quantity Control Input Group -->
                     <div class="cellexa_company_category_qty_controls">
                         <div class="input-group input-group-sm" style="width: 110px;">
                             <button class="btn btn-outline-secondary cellexa_company_category_qty_minus" type="button">
                                 <i class="bi bi-dash"></i>
                             </button>
                             <input type="text" class="form-control text-center cellexa_company_category_qty_input"
                                 value="1">
                             <button class="btn btn-outline-secondary cellexa_company_category_qty_plus" type="button">
                                 <i class="bi bi-plus"></i>
                             </button>
                         </div>
                     </div>
                 </div>
                 <!-- Delete Button with Bootstrap Icon -->
                 <button class="cellexa_company_category_delete_btn" aria-label="Delete">
                     <i class="bi bi-trash"></i>
                 </button>
             </div>

             <!-- Item 2 -->
             <div class="cellexa_company_category_cart_item">
                 <img src="{{ asset('/') }}public/front/assets/img/company_category/product2.jpg" class="cellexa_company_category_cart_img"
                     alt="Product">
                 <div class="cellexa_company_category_cart_details">
                     <h6 class="mb-1">Altmann GC Columns5</h6>
                     <!-- Quantity Control Input Group -->
                     <div class="cellexa_company_category_qty_controls">
                         <div class="input-group input-group-sm" style="width: 110px;">
                             <button class="btn btn-outline-secondary cellexa_company_category_qty_minus" type="button">
                                 <i class="bi bi-dash"></i>
                             </button>
                             <input type="text" class="form-control text-center cellexa_company_category_qty_input"
                                 value="2">
                             <button class="btn btn-outline-secondary cellexa_company_category_qty_plus" type="button">
                                 <i class="bi bi-plus"></i>
                             </button>
                         </div>
                     </div>
                 </div>
                 <button class="cellexa_company_category_delete_btn" aria-label="Delete">
                     <i class="bi bi-trash"></i>
                 </button>
             </div>

             <!-- Item 3 -->
             <div class="cellexa_company_category_cart_item">
                 <img src="{{ asset('/') }}public/front/assets/img/company_category/product2.jpg" class="cellexa_company_category_cart_img"
                     alt="Product">
                 <div class="cellexa_company_category_cart_details">
                     <h6 class="mb-1">Altmann GC Columns</h6>
                     <div class="cellexa_company_category_qty_controls">
                         <div class="input-group input-group-sm" style="width: 110px;">
                             <button class="btn btn-outline-secondary cellexa_company_category_qty_minus" type="button">
                                 <i class="bi bi-dash"></i>
                             </button>
                             <input type="text" class="form-control text-center cellexa_company_category_qty_input"
                                 value="1">
                             <button class="btn btn-outline-secondary cellexa_company_category_qty_plus" type="button">
                                 <i class="bi bi-plus"></i>
                             </button>
                         </div>
                     </div>
                 </div>
                 <button class="cellexa_company_category_delete_btn" aria-label="Delete">
                     <i class="bi bi-trash"></i>
                 </button>
             </div>

             <!-- Item 4 -->
             <div class="cellexa_company_category_cart_item">
                 <img src="{{ asset('/') }}public/front/assets/img/company_category/product2.jpg" class="cellexa_company_category_cart_img"
                     alt="Product">
                 <div class="cellexa_company_category_cart_details">
                     <h6 class="mb-1">Altmann GC Columns</h6>
                     <div class="cellexa_company_category_qty_controls">
                         <div class="input-group input-group-sm" style="width: 110px;">
                             <button class="btn btn-outline-secondary cellexa_company_category_qty_minus" type="button">
                                 <i class="bi bi-dash"></i>
                             </button>
                             <input type="text" class="form-control text-center cellexa_company_category_qty_input"
                                 value="1">
                             <button class="btn btn-outline-secondary cellexa_company_category_qty_plus" type="button">
                                 <i class="bi bi-plus"></i>
                             </button>
                         </div>
                     </div>
                 </div>
                 <button class="cellexa_company_category_delete_btn" aria-label="Delete">
                     <i class="bi bi-trash"></i>
                 </button>
             </div>

         </div>

         <!-- Fixed Footer with Total and Checkout -->
         <div class="cellexa_company_category_cart_footer">
             <button class="btn btn-dark w-100">Ask For Price</button>
         </div>
     </div>
 </div>

 <!-- PROFILE OFFCANVAS (Login/Register) -->
 <div class="offcanvas offcanvas-end" tabindex="-1" id="cellexaProfileCanvas"
     aria-labelledby="cellexaProfileCanvasLabel">
     <div class="offcanvas-header cellexa_company_category_offcanvas_header">
         <h5 class="offcanvas-title" id="cellexaProfileCanvasLabel">Account</h5>
         <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
     </div>
     <div class="offcanvas-body">

         <div class="cellexa_company_category_auth_toggle">
             <div class="cellexa_company_category_auth_tab active" onclick="switchCellexaAuth('login')">Login</div>
             <div class="cellexa_company_category_auth_tab" onclick="switchCellexaAuth('register')">Register</div>
         </div>

         <!-- Login Form -->
         <div id="cellexaLoginForm" class="cellexa_company_category_auth_form show">
             <form>
                 <div class="mb-3">
                     <label class="form-label">Email address</label>
                     <input type="email" class="form-control" placeholder="name@example.com">
                 </div>
                 <div class="mb-3">
                     <label class="form-label">Password</label>
                     <input type="password" class="form-control" placeholder="********">
                 </div>
                 <div class="mb-3 form-check">
                     <input type="checkbox" class="form-check-input" id="rememberMe">
                     <label class="form-check-label" for="rememberMe">Remember me</label>
                 </div>
                 <button type="submit" class="btn btn-primary w-100">Sign In</button>
                 <div class="text-center mt-3">
                     <a href="#" class="text-decoration-none small">Forgot password?</a>
                 </div>
             </form>
         </div>

         <!-- Register Form -->
         <div id="cellexaRegisterForm" class="cellexa_company_category_auth_form">
             <form>
                 <div class="mb-3">
                     <label class="form-label">Full Name</label>
                     <input type="text" class="form-control" placeholder="John Doe">
                 </div>
                 <div class="mb-3">
                     <label class="form-label">Company Name</label>
                     <input type="text" class="form-control" placeholder="John Doe">
                 </div>
                 <div class="mb-3">
                     <label class="form-label">Company Address Name</label>
                     <input type="text" class="form-control" placeholder="John Doe">
                 </div>
                 <div class="mb-3">
                     <label class="form-label">Email address</label>
                     <input type="email" class="form-control" placeholder="name@example.com">
                 </div>
                 <div class="mb-3">
                     <label class="form-label">Password</label>
                     <input type="password" class="form-control" placeholder="Create a password">
                 </div>
                 <div class="mb-3">
                     <label class="form-label">Confirm Password</label>
                     <input type="password" class="form-control" placeholder="Confirm password">
                 </div>
                 <div class="mb-3 form-check">
                     <input type="checkbox" class="form-check-input" id="terms">
                     <label class="form-check-label small" for="terms">I agree to the Terms & Conditions</label>
                 </div>
                 <button type="submit" class="btn btn-success w-100">Create Account</button>
             </form>
         </div>

     </div>
 </div>


 <!-- Script for functionality -->
 <script>
// Auth Tab Switching
function switchCellexaAuth(type) {
    const loginForm = document.getElementById('cellexaLoginForm');
    const registerForm = document.getElementById('cellexaRegisterForm');
    const tabs = document.querySelectorAll('.cellexa_company_category_auth_tab');

    if (type === 'login') {
        loginForm.classList.add('show');
        registerForm.classList.remove('show');
        tabs[0].classList.add('active');
        tabs[1].classList.remove('active');
    } else {
        loginForm.classList.remove('show');
        registerForm.classList.add('show');
        tabs[0].classList.remove('active');
        tabs[1].classList.add('active');
    }
}

// Cart Quantity Logic
document.addEventListener('DOMContentLoaded', function() {
    // Select all wrapper divs for quantity controls
    const qtyGroups = document.querySelectorAll('.cellexa_company_category_qty_controls');

    qtyGroups.forEach(group => {
        const input = group.querySelector('.cellexa_company_category_qty_input');
        const minusBtn = group.querySelector('.cellexa_company_category_qty_minus');
        const plusBtn = group.querySelector('.cellexa_company_category_qty_plus');

        minusBtn.addEventListener('click', () => {
            let currentValue = parseInt(input.value);
            if (currentValue > 1) {
                input.value = currentValue - 1;
            }
        });

        plusBtn.addEventListener('click', () => {
            let currentValue = parseInt(input.value);
            input.value = currentValue + 1;
        });
    });
});
 </script>