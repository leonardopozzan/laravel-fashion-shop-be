<?php

namespace Database\Seeders;

use App\Functions\Helpers;
use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brands = config('dataseeder.brands');
        foreach($brands as $brand){
            $new_brand = new Brand();
            $new_brand->name = $brand;
            $new_brand->slug = Helpers::generateSlug($new_brand->name);
            $new_brand->save();
        }
    }
}
