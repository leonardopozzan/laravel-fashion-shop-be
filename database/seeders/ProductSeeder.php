<?php

namespace Database\Seeders;

use App\Functions\Helpers;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Storage;


class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $products = config('dataseeder.products');
        foreach($products as $product){
            $new_product = new Product();
            $new_product->name = $product['name'];
            $new_product->slug = Helpers::generateSlug($new_product->name);
            $new_product->description = $product['description'];
            $new_product->price = $product['price'];
            $new_product->image = ProductSeeder::storeimage($product['api_featured_image']);
            $new_product->rating = $product['rating'];
            $new_product->available = $faker->boolean();
            $new_product->detail_link = $product['product_link'];
            $new_product->type_id = $product['type_id'];
            $new_product->brand_id = $product['brand_id'];
            $new_product->category_id = $product['category_id'];
            $new_product->save();
        }
    }
    public static function storeimage($img){
        $url = 'https:'.$img;
        $contents = file_get_contents($url);
        $temp_name = substr($url, strrpos($url, '/') + 1);
        $name = substr($temp_name, 0, strpos($temp_name, '?')) .'.jpg';
        $path = 'images/' . $name;
        Storage::put('images/'.$name, $contents);
        return $path;
    }
}
