<?php

namespace App\Imports;


use Maatwebsite\Excel\Row;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ProductsImport implements OnEachRow, WithHeadingRow, WithChunkReading, ShouldQueue
{
    protected $batch = [];

    public function onRow(Row $row)
    {
        $data = $row->toArray();

        $this->batch[] = [
            'name'        => $data['name'] ?? null,
            'description' => $data['description'] ?? null,
            'price'       => (float)($data['price'] ?? 0),
            'image'       => !empty($data['image']) ? ltrim($data['image'], '/') : '/storage/products/default-product.png',
            'category'    => $data['category'] ?? null,
            'stock'       => (int)($data['stock'] ?? 0),
            'created_at'  => now(),
            'updated_at'  => now(),
        ];

        if (count($this->batch) >= 1000) {
            DB::table('products')->insert($this->batch);
            $this->batch = [];
        }
    }

    public function chunkSize(): int
    {
        return 1000; 
    }

    public function __destruct()
    {
        if (!empty($this->batch)) {
            DB::table('products')->insert($this->batch);
        }
    }
}
