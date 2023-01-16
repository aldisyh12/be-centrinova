<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('post')->insert([
            'comment_id' => 1,
            'judul' => "Tekonologi",
            'categories' => "Teknologi",
            'description' => "Desckripsi",
        ]);
    }
}
