<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;

class ImportProductsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $chunk;

    /**
     * Create a new job instance.
     */
    public function __construct(array $chunk)
    {
        $this->chunk = $chunk;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->chunk as $row) {
            Product::create([
                'name' => $row['name'],
                'description' => $row['description'] ?? null,
                'price' => $row['price'] ?? 0,
                'image' => $row['image'] ?? 'products/default-product.png',
                'category' => $row['category'],
                'stock' => $row['stock']
            ]);
        }
    }
}
