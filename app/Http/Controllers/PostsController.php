<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Classes\DateClass;

class PostsController extends Controller
{
    public function index()
    {
        $posts = DB::table('posts')->get();
        
        $posts = DB::table('posts')
            ->where('id', 2)
            ->get();
        
        $posts = DB::table('posts')
            ->select('content')
            ->get()
            ->toJson();
        $posts = json_decode($posts, true);
        $posts = array_column($posts, 'content');
        
        // Returns same results as previous query
        $posts = DB::table('posts')
            ->pluck('content')
            ->toArray();
        
        // echo '<pre style="background:#111; color:#b5ce28; font-size:11px;">'; print_r($posts); echo '</pre>'; die();
        
        $collection = collect([[1, 2, 3], [4, 5, 6], [7, 8, 9]])->all();
        /*
        [0] => Array
            (
                [0] => 1
                [1] => 2
                [2] => 3
            )

        [1] => Array
            (
                [0] => 4
                [1] => 5
                [2] => 6
        etc.
        */
        
        $collection = collect([[1, 2, 3], [4, 5, 6], [7, 8, 9]]);
        $collapsed = $collection->collapse()->all();
        /*
        [0] => 1
        [1] => 2
        [2] => 3
        [3] => 4
        [4] => 5
        etc.
        */
        
        // echo '<pre style="background:#111; color:#b5ce28; font-size:11px;">'; print_r($collapsed); echo '</pre>'; die();
        
        
        // $posts = $posts->toArray();
        // $posts = $posts->toJson(JSON_PRETTY_PRINT);
        // $posts = json_decode(json_encode($posts), true);

        $dateObj = new DateClass();
        echo $dateObj->AddDays(2); die();

        
        // $posts = DB::table('posts')
        //     ->where('created_at', '<', Carbon::now()->subDays(30) )
        //     ->orWhere('updated_at', '=', '2022-07-12')
        //     ->get();


        echo '<pre style="background:#111; color:#b5ce28; font-size:11px;">'; print_r($posts); echo '</pre>'; die();
    }
}
