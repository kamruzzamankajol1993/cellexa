<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\AssignCategory;
use App\Models\CompanyCategory; // CompanyCategory মডেল যুক্ত করুন
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Expected Excel Headers: 
        // company_name, company_category, category_name, product_name, description, specification, buying_price, selling_price, discount_price

        // 1. Handle Brand (Company Name) - Nullable
        $brandId = null;
        if (!empty($row['company_name'])) {
            $brand = Brand::firstOrCreate(
                ['name' => trim($row['company_name'])], 
                [
                    'slug' => Str::slug($row['company_name']),
                    'status' => 1
                ]
            );
            $brandId = $brand->id;
        }

        // 2. Handle Company Category - Nullable (Only if Brand exists)
        $companyCategoryId = null;
        $companyCategoryName = null;
        if ($brandId && !empty($row['company_category'])) {
            $compCatName = trim($row['company_category']);
            $companyCategory = CompanyCategory::firstOrCreate(
                [
                    'name' => $compCatName, 
                    'company_id' => $brandId
                ], 
                [
                    'slug' => Str::slug($compCatName),
                    'status' => 1
                ]
            );
            $companyCategoryId = $companyCategory->id;
            $companyCategoryName = $companyCategory->name;
        }

        // 3. Handle Main Category - Required in Logic but handled if missing
        $categoryId = null;
        if (!empty($row['category_name'])) {
            $category = Category::firstOrCreate(
                ['name' => trim($row['category_name'])], 
                [
                    'slug' => Str::slug($row['category_name']),
                    'status' => 1
                ]
            );
            $categoryId = $category->id;
        }

        // 4. Generate Product Code
        $productCode = strtoupper(substr($row['product_name'], 0, 3)) . '-' . time() . rand(10, 99);

        // 5. Create Product
        $product = Product::create([
            'name'              => $row['product_name'],
            'slug'              => Str::slug($row['product_name']),
            'product_code'      => $productCode,
            'brand_id'          => $brandId,      // Nullable
            'category_id'       => $categoryId,   
            'description'       => $row['description'] ?? null,
            'specification'     => $row['specification'] ?? null,
            
            // --- PRICE COLUMNS ---
            'purchase_price'    => $row['buying_price'] ?? 0,    
            'base_price'        => $row['selling_price'] ?? null, // Nullable (Base Price)
            'discount_price'    => $row['discount_price'] ?? null,

            'status'            => 1,
            'thumbnail_image'   => [], 
            'main_image'        => [],
            'real_image'        => [],
        ]);

        // 6. Assign Main Category to Pivot Table (Legacy support or if needed)
        // Note: You logic moved category_id to products table, but if you still use assign_categories for main category:
        // if ($categoryId) { ... } 

        // 7. Assign Company Category
        if ($companyCategoryId) {
            AssignCategory::create([
                'product_id'    => $product->id,
                'category_id'   => $companyCategoryId,
                'category_name' => $companyCategoryName,
                'type'          => 'company_category'
            ]);
        }

        return $product;
    }
}