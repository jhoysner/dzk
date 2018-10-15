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
	Route::get('/{id}', 'Params\ParamsController@show');
	Route::delete('/{id}', 'Params\ParamsController@destroy');
	Route::post('/', 'Params\ParamsController@store');
	Route::put('/', 'Params\ParamsController@update');
});

//Tags
Route::group(["prefix" => "tags"], function () {
	Route::get('/', 'Tags\TagsController@index');
	Route::get('/{id}', 'Tags\TagsController@show');
	Route::delete('/{id}', 'Tags\TagsController@destroy');
	Route::post('/', 'Tags\TagsController@store');
	Route::put('/', 'Tags\TagsController@update');
	Route::get('/search/{search}', 'Tags\TagsController@search');
});
//Discount-tags
Route::get('tags-discount/{id}', 'Discount\DiscountController@getTagsDiscount');

//Commerce-tags
Route::get('tags-commerce/{id}', 'Commerce\CommercesController@getTagsCommerce');

Route::resource('discount','Discount\DiscountController');
Route::resource('discount-categories','DiscountCategory\DiscountCategoryController');
Route::resource('commerce', 'Commerce\CommercesController');
Route::resource('branch', 'Branch\BranchsController');
Route::resource('commerce-categories', 'CommerceCategory\CommerceCategoriesController');

Route::post('branch-discount', 'Discount\DiscountController@branchDiscount');
Route::get('branch-discount/{id}', 'Discount\DiscountController@getBranchDiscount');
Route::get('branch-discount-update/{discount}/{id}', 'Discount\DiscountController@editBranchDiscount');
Route::patch('branch-discount-update/{discount}/{id}', 'Discount\DiscountController@updateBranchDiscount');
Route::delete('branch-discount-update/{discount}/{id}', 'Discount\DiscountController@branchDiscountDelete');

Route::get('countries', 'Country\CountriesController@getCountries');
Route::get('states/{id}', 'Country\CountriesController@getStates');
Route::get('cities/{id}', 'Country\CountriesController@getCities');
Route::get('commerce-size', 'Params\ParamsController@getCommerceSize');
Route::get('commerce-ext', 'Params\ParamsController@getCommerceType');
Route::get('branch-size', 'Params\ParamsController@getBranchSize');
Route::get('branch-ext', 'Params\ParamsController@getBranchType');
Route::get('user-size', 'Params\ParamsController@getUserSize');
Route::get('user-ext', 'Params\ParamsController@getUserType');
Route::get('tag-num', 'Params\ParamsController@getTagNum');

Route::get('all-commerces', 'HomeInit\HomeInitController@allCommerce');
Route::get('detail-commerce/{id}', 'HomeInit\HomeInitController@commerce_detail');
Route::get('commerce-detail-branchs/{id}', 'HomeInit\HomeInitController@commerce_detail_branchs');
