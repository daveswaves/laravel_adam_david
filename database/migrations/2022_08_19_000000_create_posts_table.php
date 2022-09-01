<?php

/*=========================================================================
| Running 'php artisan migrate' runs the files in the 'database/migrations'
| directory.
| Regardless of the files in the 'migrations' directory, Laravel automatically
| creates two database tables: 1) migrations 2) personal_access_tokens
| 
| The up() function below creates the following 'posts' table:

+------------+---------------------+------+-----+---------+----------------+
| Field      | Type                | Null | Key | Default | Extra          |
+------------+---------------------+------+-----+---------+----------------+
| id         | bigint(20) unsigned | NO   | PRI | None    | auto_increment |
| title      | varchar(255)        | NO   | UNI | None    |                |
| content    | varchar(255)        | NO   |     | None    |                |
| created_at | timestamp           | YES  |     | NULL    |                |
| updated_at | timestamp           | YES  |     | NULL    |                |
+------------+---------------------+------+-----+---------+----------------+

| $table->timestamps() creates the 'created_at' and 'updated_at' fields.
|
| 'php artisan migrate:refresh' resets and re-runs all migrations.
| Alternatively, migrate:fresh (Drop all tables and re-run all migrations)
| 
| The 'database/seeders/DatabaseSeeder.php' file populates the tables with data.
| The following will insert data into the 'title' and 'content' fields:
|
| public function run()
| {
|     Post::create(['title' => 'Post 1','content' => 'Post 1 content']);
|     Post::create(['title' => 'Post 2','content' => 'Post 2 content']);
|     etc.
| }
| 
| NOTE: The above requires a Post.php model (php artisan make:model Post)
|       and the following use statement: 'use App\Models\Post;'
| 
| The following command populates the table: 'php artisan db:seed'
|
| Alternatively, combine 'migrate' and 'seed': 'php artisan migrate:refresh --seed'.
| 
| To rollback migrations:
| 1) php artisan migrate:reset    (Rollback all database migrations)
| 2) php artisan migrate:rollback (Rollback the last database migration)
| 
|========================================================================*/

// php artisan make

/*
DROP TABLES `migrations`;
DROP TABLES `personal_access_tokens`;
DROP TABLES `posts`;
 */


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->string('content');
            $table->date('edit_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            // $table->timestamp('edit_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamps();
            
            // $table->integer('created_at');
            // $table->integer('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
};

/*
use Illuminate\Support\Facades\DB;

$id = 7;

$posts = DB::select('SELECT * FROM posts WHERE id = ?', [$id]); // OR WHERE id = :id', ['id' => $id]

$posts = DB::select([
    'table' => 'posts',
    'where' => ['id' => $id]
]);


// Alternative, QueryBuilder lets you chain methods together:

NOTE: A collection is returned.

$posts = DB::table('posts')
    ->where('id', $id)
    ->get();

dd($posts);

$posts = DB::table('posts')
    ->select('body')
    ->get();

dd($posts);

$posts = DB::table('posts')
    ->where('created_at', '<', Carbon::now()->subDays(30) )
    ->orWhere('updated_at', '=', '2022-07-12')
    ->get();

dd($posts);

$posts = DB::table('posts')
    ->whereBetween('id', [2,5]) // returns records with 'ids' 2, 3, 4, 5
    ->get();

dd($posts);

$posts = DB::table('posts')
    ->whereNotNull('title')
    ->get();

dd($posts);

$posts = DB::table('posts')
    ->select('content')
    ->distinct()
    ->get();

dd($posts);

$posts = DB::table('posts')
    ->orderBy('id', 'desc')
    ->get();

dd($posts);

$posts = DB::table('posts')
    ->latest() // sorts records by 'created_at' field... Newest records first.
    ->get();   // Use ->oldest() to sort by oldest records first.

dd($posts);

https://youtu.be/C3Z-PzXoDxY?list=PLFHz2csJcgk_3VJwzVoeyMuC1rdBcfiLv
*/