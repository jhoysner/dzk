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


Route::post('login', 'Auth\LoginController@authenticate');


Route::resource('discount','Discount\DiscountController');
Route::resource('discount-categories','DiscountCategory\DiscountCategoryController');
Route::resource('commerce', 'Commerce\CommercesController');
Route::resource('branch', 'Branch\BranchsController');
Route::resource('commerce-categories', 'CommerceCategory\CommerceCategoriesController');
Route::post('branch-discount', 'Discount\DiscountController@branchDiscount');

Route::get('countries', 'Country\CountriesController@getCountries');
Route::get('states/{id}', 'Country\CountriesController@getStates');
Route::get('cities/{id}', 'Country\CountriesController@getCities');
