<?php

namespace App\Imports;

use App\Models\CompanyCategory;
use App\Models\Brand;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CompanyCategoriesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Expected Headers: company_name, category_name, parent_category, description

        // ১. নাম এবং কোম্পানি নাম না থাকলে স্কিপ
        if (empty($row['category_name']) || empty($row['company_name'])) {
            return null;
        }

        // ২. কোম্পানি নাম দিয়ে ডাটাবেস থেকে কোম্পানি (Brand) খুঁজে বের করা বা তৈরি করা
        $companyName = trim($row['company_name']);
        
        $company = Brand::firstOrCreate(
            ['name' => $companyName],
            ['slug' => Str::slug($companyName), 'status' => 1]
        );

        // ৩. প্যারেন্ট ক্যাটাগরি হ্যান্ডেল করা (যদি এক্সেল ফাইলে থাকে)
        $parentId = null;
        
        // চেক করা হচ্ছে parent_category কলামটি আছে কি না এবং খালি কি না
        if (isset($row['parent_category']) && !empty($row['parent_category'])) {
            $parentName = trim($row['parent_category']);
            
            // একই কোম্পানির আন্ডারে প্যারেন্ট ক্যাটাগরি খোঁজা বা তৈরি করা
            $parentCategory = CompanyCategory::firstOrCreate(
                [
                    'company_id' => $company->id,
                    'name'       => $parentName,
                ],
                [
                    'slug'        => Str::slug($parentName),
                    'status'      => 1
                ]
            );
            $parentId = $parentCategory->id;
        }

        // ৪. ক্যাটাগরি তৈরি বা আপডেট
        return CompanyCategory::firstOrCreate(
            [
                'company_id' => $company->id,
                'name'       => trim($row['category_name']),
            ],
            [
                'parent_id'   => $parentId, // প্যারেন্ট থাকলে আইডি, না থাকলে null
                'slug'        => Str::slug($row['category_name']),
                'description' => $row['description'] ?? null,
                'status'      => 1, // Default Active
            ]
        );
    }
}