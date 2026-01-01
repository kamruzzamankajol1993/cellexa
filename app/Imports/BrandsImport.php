<?php

namespace App\Imports;

use App\Models\Brand;
use App\Models\Category; // Category মডেল ইমপোর্ট করুন
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BrandsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Expected Headers: company_name, category_name, description

        // নাম না থাকলে স্কিপ করবে
        if (empty($row['company_name'])) {
            return null;
        }

        // 1. ক্যাটাগরি নাম দিয়ে টেবিল থেকে ID খুঁজে বের করা
        $categoryId = null;
        if (!empty($row['category_name'])) {
            // নামের আগে-পিছে স্পেস থাকলে trim করা হচ্ছে
            $categoryName = trim($row['category_name']);
            
            // ডাটাবেস থেকে ক্যাটাগরি খোঁজা (case-insensitive বা exact match)
            $category = Category::where('name', $categoryName)->first();

            if ($category) {
                $categoryId = $category->id;
            }
        }

        // 2. ব্র্যান্ড তৈরি বা আপডেট করা
        return Brand::firstOrCreate(
            ['name' => trim($row['company_name'])], // নাম দিয়ে ইউনিক চেক
            [
                'category_id' => $categoryId, // খুঁজে পাওয়া ক্যাটাগরি ID (না পেলে null)
                'slug'        => Str::slug($row['company_name']),
                'description' => $row['description'] ?? null,
                'status'      => 1, // Default active
            ]
        );
    }
}