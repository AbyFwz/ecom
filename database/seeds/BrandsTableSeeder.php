<?php

use Illuminate\Database\Seeder;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brandsRecord = [
            ['id'=>1, 'name'=>'Morfeen', 'status'=>1],
            ['id'=>2, 'name'=>'3 Seconds', 'status'=>1],
        ];
        \App\Brand::insert($brandsRecord);
    }
}
