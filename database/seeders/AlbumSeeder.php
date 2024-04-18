<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class AlbumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       // Generate some sample data for albums
       $albums = [
        [
            'name' => 'Album 1',
            'description' => 'Description for Album 1',
            'cover_image' => 'album1.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'Album 2',
            'description' => 'Description for Album 2',
            'cover_image' => fake()->imageUrl(),
            'created_at' => now(),
            'updated_at' => now(),
        ],
        // Add more albums as needed
    ];

    // Insert the data into the database
    DB::table('albums')->insert($albums);
    }
}
