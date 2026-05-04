<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Support\Str;
use App\Models\Brand;
use App\Models\CompanyCategory;
use App\Models\Order;
use App\Models\OrderDetail;
class AuthController extends Controller
{
    // Login & Register Page View (যদি আলাদা পেজ থাকে)
    public function loginregisterPage()
    {
        return view('front.auth.login_register');
    }

    // ১. কাস্টমার রেজিস্ট্রেশন
    // ১. কাস্টমার রেজিস্ট্রেশন (Updated for Partial/Full registration)
    public function registerUserPost(Request $request)
    {
        // ভ্যালিডেশন আপডেট: name এবং address এখন nullable
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email|unique:customers,email',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ]);
        }

        DB::beginTransaction();
        try {
            // যদি নাম না দেওয়া থাকে, ইমেইলের প্রথম অংশকে নাম হিসেবে ব্যবহার করা হবে
            $userName = $request->name ?? explode('@', $request->email)[0];
            $userAddress = $request->address ?? 'N/A';

            // ১. ইউজার টেবিলে ডাটা ইনসার্ট
            $user = new User();
            $user->name = $userName;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->user_type = 1; // 1 = Customer
            $user->status = 1; // Active
            $user->save();

            $user->assignRole('customer');

            // ২. কাস্টমার টেবিলে ডাটা ইনসার্ট
            $customer = new Customer();
            $customer->user_id = $user->id;
            $customer->name = $userName;
            $customer->company_name = $request->company_name;
            $customer->email = $request->email;
            $customer->phone = $request->phone ?? null;
            $customer->address = $userAddress;
            $customer->password = Hash::make($request->password);
            $customer->status = 1;
            $customer->save();

            // ৩. ইউজারের মধ্যে কাস্টমার আইডি আপডেট করা
            $user->customer_id = $customer->id;
            $user->save();

            DB::commit();

            Auth::login($user);

            return response()->json([
                'status' => 'success',
                'message' => 'Registration successful! Redirecting...',
                'redirect_url' => route('front.userDashboard')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong! ' . $e->getMessage()
            ]);
        }
    }

    // ২. কাস্টমার লগইন
    public function loginUserPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => 'Please fill all fields correctly.']);
        }

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'user_type' => 1, // শুধু কাস্টমার লগইন করতে পারবে
            'status' => 1 // শুধু অ্যাক্টিভ ইউজার
        ];

        if (Auth::attempt($credentials, $request->remember)) {
    // চেক করছি ইউজার কি কার্ট থেকে এসেছে?
    if (session()->has('redirect_to_cart')) {
        session()->forget('redirect_to_cart'); // কাজ শেষ হলে মুছে ফেলুন
        $redirectUrl = route('front.cartDetails');
    } else {
        $redirectUrl = route('front.userDashboard');
    }

    return response()->json([
        'status' => 'success',
        'message' => 'Login successful!',
        'redirect_url' => $redirectUrl
    ]);
}
    }

    // 1. User Dashboard (Updated to pass data)
    public function userDashboard() {
    $user = Auth::user();
    $customer = Customer::where('user_id', $user->id)->first();
    // Fetch orders
    $orders = Order::where('customer_id', $customer->id ?? 0)->latest()->get();

    return view('front.customer.customer_profile', compact('user', 'customer', 'orders'));
}

    // 2. Update Profile Information
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $customer = Customer::where('user_id', $user->id)->first();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'company_name' => 'nullable|string|max:255',
            'address' => 'required|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()]);
        }

        DB::beginTransaction();
        try {
            // Update User Table
            $user->name = $request->name;
            $user->save();

            // Update Customer Table
            if ($customer) {
                $customer->name = $request->name;
                $customer->phone = $request->phone;
                $customer->company_name = $request->company_name;
                $customer->address = $request->address;
                $customer->save();
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Profile updated successfully!',
                'new_name' => $request->name // Return name to update header dynamically
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Update failed: ' . $e->getMessage()]);
        }
    }

    // 3. Update Password
    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed', // field name must be password and password_confirmation
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()]);
        }

        $user = Auth::user();

        // Check Current Password
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'errors' => ['current_password' => ['Current password does not match.']]
            ]);
        }

        DB::beginTransaction();
        try {
            // Update User Password
            $user->password = Hash::make($request->password);
            $user->save();

            // Update Customer Password (Legacy support)
            $customer = Customer::where('user_id', $user->id)->first();
            if ($customer) {
                $customer->password = Hash::make($request->password);
                $customer->save();
            }

            DB::commit();

            return response()->json(['status' => 'success', 'message' => 'Password changed successfully!']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Something went wrong!']);
        }
    }

    // Logout
    public function logout() {
        Auth::logout();
        return redirect()->route('front.index');
    }

    // --- Step 1: Check if Email Exists ---
    public function checkEmailForReset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => 'Invalid email format.']);
        }

        // চেক করা হচ্ছে ইউজার টেবিলে ইমেইল আছে কিনা
        $userExists = User::where('email', $request->email)->where('user_type', 1)->exists();

        if ($userExists) {
            return response()->json([
                'status' => 'success',
                'message' => 'Account found.'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'No account found with this email address.'
            ]);
        }
    }

    // --- Step 2: Direct Password Update ---
    public function directPasswordReset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6|confirmed', // password & password_confirmation
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            // ১. ইউজার খুঁজে বের করা
            $user = User::where('email', $request->email)->first();
            $user->password = Hash::make($request->password);
            $user->save();

            // ২. কাস্টমার টেবিলে পাসওয়ার্ড আপডেট করা (যদি থাকে)
            $customer = Customer::where('user_id', $user->id)->first();
            if ($customer) {
                $customer->password = Hash::make($request->password);
                $customer->save();
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Password reset successfully!'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'System error: ' . $e->getMessage()
            ]);
        }
    }
}
