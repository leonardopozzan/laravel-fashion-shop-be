<?php

namespace Database\Seeders;

use App\Functions\Helpers;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //es. Vegan, Cruelty free...
        $tags = config('dataseeder.tags');
        foreach($tags as $tag){
            $new_tag = new Tag();
            $new_tag->name = $tag;
            $new_tag->slug = Helpers::generateSlug($new_tag->name);
            $new_tag->save();
        }
    }
}
