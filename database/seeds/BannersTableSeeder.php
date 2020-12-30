<?php

use Illuminate\Database\Seeder;

class BannersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bannerRecords = [
            ['id'=>1,'image'=>'banner1.png','link'=>'','title'=>'Black Jacket','alt'=>'Black Jacket','Status'=>1],
            ['id'=>2,'image'=>'banner2.png','link'=>'','title'=>'Half Sleeve T-Shirt','alt'=>'Black Jacket','Status'=>1],
            ['id'=>3,'image'=>'banner3.png','link'=>'','title'=>'Full Sleeve T-Shirt','alt'=>'Black Jacket','Status'=>1],
        
        ];
        \App\Banner::insert($bannerRecords);
    }
}
