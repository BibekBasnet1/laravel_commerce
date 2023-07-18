<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Product;
use App\Models\Roles;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // Retrieve all products
        $products = Product::all();

        // Prepare the data for the stocks table
        $stockData = $products->map(function ($product) {
            return [
                'product_id' => $product->id,
                'quantity' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        });

        // Insert the data into the stocks table
        DB::table('stocks')->insert($stockData->toArray());
    }
}
