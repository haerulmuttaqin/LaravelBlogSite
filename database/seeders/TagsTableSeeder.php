<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Support\Str;
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
        $tags = collect(['Laravel', 'Codeigniter', 'Bug', 'Help']);
        $tags->each(function ($c) {
            Tag::create([
                'name' => $c,
                'slug' => Str::slug($c)
            ]);
        });
    }
}
