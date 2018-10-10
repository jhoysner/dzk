<?php

use Illuminate\Http\Request;

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

//Login
Route::post('login', 'Auth\LoginController@authenticate');
//Logout
Route::get('logout', 'UserController@logout');

//Usuario
Route::group(["prefix" => "profile"], function () {
	Route::get('/{id}', 'UserController@userDetail');
	Route::post('/', 'UserController@updateProfile');

});

//Parametros
Route::group(["prefix" => "params"], function () {
	Route::get('/', 'Params\ParamsController@index');
	Route::get('/{id}', 'UserController@userDetail');
	Route::post('/', 'UserController@updateProfile');

});

Route::resource('discount','Discount\DiscountController');
Route::resource('discount-categories','DiscountCategory\DiscountCategoryController');
Route::resource('commerce', 'Commerce\CommercesController');
Route::resource('branch', 'Branch\BranchsController');
Route::resource('commerce-categories', 'CommerceCategory\CommerceCategoriesController');
Route::post('branch-discount', 'Discount\DiscountController@branchDiscount');
Route::get('branch-discount/{id}', 'Discount\DiscountController@getBranchDiscount');

Route::get('countries', 'Country\CountriesController@getCountries');
Route::get('states/{id}', 'Country\CountriesController@getStates');
Route::get('cities/{id}', 'Country\CountriesController@getCities');
Route::get('commerce-size', 'Params\ParamsController@getCommerceSize');
Route::get('commerce-ext', 'Params\ParamsController@getCommerceType');
Route::get('branch-size', 'Params\ParamsController@getBranchSize');
Route::get('branch-ext', 'Params\ParamsController@getBranchType');
