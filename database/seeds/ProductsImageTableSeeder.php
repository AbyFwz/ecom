<?php

use Illuminate\Database\Seeder;

class ProductsImageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productImageRecords = [
            ['id'=>1, 'product_id'=>1, 'image'=>'', 'status'=>1],
        ];

        \App\ProductsImage::insert($productImageRecords);
    }
}
