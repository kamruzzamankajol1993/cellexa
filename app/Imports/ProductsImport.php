<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\AssignCategory;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Expected Excel Headers: 
        // company_name, category_name, product_name, description, specification, buying_price, selling_price, discount_price

        // 1. Handle Brand (Company Name)
        $brandId = null;
        if (!empty($row['company_name'])) {
            $brand = Brand::firstOrCreate(
                ['name' => $row['company_name']], 
                [
                    'slug' => Str::slug($row['company_name']),
                    'status' => 1
                ]
            );
            $brandId = $brand->id;
        }

        // 2. Handle Category
        $categoryId = null;
        if (!empty($row['category_name'])) {
            $category = Category::firstOrCreate(
                ['name' => $row['category_name']], 
                [
                    'slug' => Str::slug($row['category_name']),
                    'status' => 1
                ]
            );
            $categoryId = $category->id;
        }

        // 3. Generate Product Code
        $productCode = strtoupper(substr($row['product_name'], 0, 3)) . '-' . time() . rand(10, 99);

        // 4. Create Product
        $product = Product::create([
            'name'              => $row['product_name'],
            'slug'              => Str::slug($row['product_name']),
            'product_code'      => $productCode,
            'brand_id'          => $brandId,
            'category_id'       => $categoryId, // Primary category for backward compatibility
            'description'       => $row['description'] ?? null,
            'specification'     => $row['specification'] ?? null,
            
            // --- NEW PRICE COLUMNS MAPPING ---
            'purchase_price'    => $row['buying_price'] ?? 0,    // Buying Price
            'base_price'        => $row['selling_price'] ?? 0,   // Selling Price
            'discount_price'    => $row['discount_price'] ?? null, // Discount Price

            'status'            => 1,
            'thumbnail_image'   => [], 
            'main_image'        => [],
            'real_image'        => [],
            'is_free_delivery'  => 0,
            'is_pre_order'      => 0,
        ]);

        // 5. Assign Category to Pivot Table
        if ($categoryId) {
            AssignCategory::create([
                'product_id'    => $product->id,
                'category_id'   => $categoryId,
                'type'          => 'product_category'
            ]);
        }

        return $product;
    }
}