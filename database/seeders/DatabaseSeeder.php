<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Post;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Post::create(['title' => 'Post 1','content' => 'Post A content']);
        Post::create(['title' => 'Post 2','content' => 'Post A content']);
        Post::create(['title' => 'Post 3','content' => 'Post A content']);
        Post::create(['title' => 'Post 4','content' => 'Post B content']);
        Post::create(['title' => 'Post 5','content' => 'Post B content']);
        Post::create(['title' => 'Post 6','content' => 'Post C content']);
        Post::create(['title' => 'Post 7','content' => 'Post C content']);
        Post::create(['title' => 'Post 8','content' => 'Post C content']);
        Post::create(['title' => 'Post 9','content' => 'Post C content']);
        
        foreach (range(1, 9) as $no) {
            $date = "2020-$no-12";
            Post::where('id', $no)->update(['created_at' => $date, 'updated_at' => $date]);
        }
        
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
