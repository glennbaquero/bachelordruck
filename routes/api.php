<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('banner', [\App\Banners\Controllers\Api\BannerController::class, 'index']);
Route::get('news', [\App\News\Controllers\Api\NewsController::class, 'index']);
Route::get('galleries', [\App\Gallery\Controllers\Api\GalleryController::class, 'index']);
Route::get('pages', [\App\Pages\Controllers\Api\PageController::class, 'index']);
