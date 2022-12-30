<?php

use App\Http\Controllers\Api\ApiProdukController;
use App\Http\Controllers\Api\ApiUserController;
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



Route::post('/eziz-user', [ApiUserController::class, 'store']);
Route::post('/login', [ApiUserController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    
    Route::get('/produk',[ApiProdukController::class,'index']);
    Route::post('/eziz-product',[ApiProdukController::class,'product']);


    Route::get('/user', [ApiUserController::class, 'index']);
    Route::get('/profile', function (Request $request) {
        return auth()->user();
    });
});
