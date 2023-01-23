<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Functions\Helpers;
use App\Models\Type;
class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //es. Blush, Bronzer...
        $types = config('dataseeder.types');
        foreach($types as $type){
            $new_type = new Type();
            $new_type->name = $type;
            $new_type->slug = Helpers::generateSlug($new_type->name);
            $new_type->save();
        }
    }
}
