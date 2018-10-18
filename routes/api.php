<?php

use Illuminate\Http\Request;
Use App\Article;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



// api for collection

Route::get('collections', 'CollectionController@index');
Route::get('collections/{id}', 'CollectionController@show');
Route::put('collections/{id}', 'CollectionController@update');
Route::delete('collections/{id}', 'CollectionController@delete');

//api for product

Route::get('products', 'ProductController@index');
Route::get('products/{id}', 'ProductController@show');
Route::post('products', 'ProductController@store');
Route::put('products/{id}', 'ProductController@update');
Route::delete('products/{id}', 'ProductController@delete');
Route::get('products/size/{id}', 'ProductController@getProductsBySize');
