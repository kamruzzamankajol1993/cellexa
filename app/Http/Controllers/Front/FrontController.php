<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
class FrontController extends Controller
{

    
   public function index()
{
    // ১. আগের কোড (Category with Brands)
    $home_first_category = Category::where('status', 1)
        ->whereHas('brands')
        ->with(['brands' => function($q) {
            $q->where('status', 1)
              ->withCount('companyCategories')
              ->latest()
              ->take(8);
        }])
        ->first();

    // ২. নতুন কোড (Category WITHOUT Brands, BUT WITH Products)
    // doesntHave('brands') = যার কোনো কোম্পানি নেই
    // whereHas('products') = যার প্রোডাক্ট আছে
    $home_second_category = Category::where('status', 1)
        ->doesntHave('brands') 
        ->whereHas('products')
        ->with(['products' => function($q) {
            $q->where('status', 1)
              ->latest()
              ->take(4); // লেটেস্ট ৪টা প্রোডাক্ট
        }])
        ->first();

    return view('front.home_page.index', compact('home_first_category', 'home_second_category'));
}


public function categoryWiseCompanies(Request $request, $slug)
{
    // ১. ক্যাটাগরি চেক
    $category = Category::where('slug', $slug)
        ->where('status', 1)
        ->firstOrFail();

    // ২. আলাদাভাবে ব্র্যান্ড কুয়েরি করে প্যাজিনেশন করা (১০ টা করে)
    $brands = $category->brands()
        ->where('status', 1)
        ->withCount('companyCategories')
        ->latest()
        ->paginate(10); // প্রতি পেজে ১০ টা

    // ৩. যদি AJAX রিকোয়েস্ট হয় (স্ক্রল করলে কল হবে)
    if ($request->ajax()) {
        return view('front.category.company_data', compact('brands'))->render();
    }

    // ৪. সাধারণ লোড
    return view('front.category.category_wise_companies', compact('category', 'brands'));
}

public function categoryWiseProducts(Request $request, $slug)
{
    // ১. ক্যাটাগরি চেক
    $category = Category::where('slug', $slug)
        ->where('status', 1)
        ->firstOrFail();

    // ২. আলাদাভাবে প্রোডাক্ট কুয়েরি করে প্যাজিনেশন করা (১২ টা করে)
    $products = $category->products()
        ->where('status', 1)
        ->latest()
        ->paginate(12); // প্রতি পেজে ১২ টা

    // ৩. যদি AJAX রিকোয়েস্ট হয় (স্ক্রল করলে কল হবে)
    if ($request->ajax()) {
        return view('front.category.product_data', compact('products'))->render();
    }

    // ৪. সাধারণ লোড
    return view('front.category.category_wise_products', compact('category', 'products'));
}

// প্রোডাক্ট ডিটেইলস মেথড
public function productDetails($slug)
{
    // প্রোডাক্ট কুয়েরি (পরে ডিজাইন করবেন)
    // $product = Product::where('slug', $slug)->firstOrFail();
    return "This is Product Details Page for: " . $slug;
}

    // নতুন মেথড ১: কোম্পানি ওয়াইজ ক্যাটাগরি পেজ
public function companyWiseCategories($slug)
{
    // লজিক পরে বসাবেন
    return "Company Categories Page for: " . $slug;
}

// নতুন মেথড ২: কোম্পানি ওয়াইজ প্রোডাক্ট পেজ
public function companyWiseProducts($slug)
{
    // লজিক পরে বসাবেন
    return "Company Products Page for: " . $slug;
}
}
