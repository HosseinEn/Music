<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = ["الکترونیک"=>"electronic", "کریسمس"=>"christmas", "فلامنکو"=>"flamnko", "چیل اوت"=>"chill-out",
         "ترنس"=>"trans", "امبینت"=>"ambient", "جاز"=>"jazz", "پست راک"=>"post-rock", "مدیتیشن"=>"meditation", "کلاسیک"=>"classic", "آرامش"=>"chill"];
        foreach($tags as $tag=>$slug) {
            Tag::create([
                "name"=>$tag,
                "slug"=>$slug
            ]);
        }
    }
}
