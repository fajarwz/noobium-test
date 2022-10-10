<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
use Str;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dummy = [];

        for ($i=0; $i < 50; $i++) {
            $title = fake()->sentence;
            $content = fake()->paragraph(15);

            $dummy[] = [
                'user_id' => 1,
                'category_id' => fake()->numberBetween(1, 13),
                'title' => $title,
                'slug' => Str::of($title)->slug('-'),
                'content' => $content,
                'content_preview' => substr($content, 0, 218) . '...',
                'featured_image' => fake()->imageUrl(),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }

        DB::table('articles')->insert($dummy);
    }
}
