<?php

// cd /opt/lampp/htdocs/laravel_auction && php artisan serve
// OR php artisan serve --port=8081
// 
// http://127.0.0.1:8000
// http://127.0.0.1:8000/sellers/2021-06-29
// http://127.0.0.1:8000/sellers/29-06-2021

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ViewsController;
use App\Http\Controllers\AddSellerController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\MockDataController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/sellers/{date}', [ViewsController::class, 'sellers']);

Route::get('/sellers_db/{date}', [ViewsController::class, 'sellers_db']);



Route::get('/', [ViewsController::class, 'sellers']); // Used when page is first loaded

Route::get('/lots/{date}/{id}', [ViewsController::class, 'lots']);

Route::post('/create/seller/', [AddSellerController::class, 'store']);
// Alternate method after Laravel 7
// Route::post('/create/seller/', 'App\Http\Controllers\AddSellerController@store');

Route::get('posts', [PostsController::class, 'index']);
Route::get('mock_data', [MockDataController::class, 'mock_data']);


Route::get('/test/', function(){
    return response()->json([
        'name' => 'D. Adamson',
        'date' => '2022-08-11',
    ]);
});
