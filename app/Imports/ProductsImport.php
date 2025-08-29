<?php

namespace App\Imports;


use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;
use App\Models\Product;

class ProductsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        Log::info('Data:', $row);

        return new Product([
            'name'        => $row['name'] ?? null,
            'description' => $row['description'] ?? null,
            'price'       => (float)($row['price'] ?? 0),
            'image'       => !empty($row['image']) ? ltrim($row['image'], '/') : '/storage/products/default-product.png',
            'category'    => $row['category'] ?? null,
            'stock'       => (int)($row['stock'] ?? 0),
        ]);
    }
}

