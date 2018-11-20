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

Route::post('loginID', 'Auth\LoginController@authenticateID');

Route::post('search', 'Search\SearchController@getSearch');

Route::group(['middleware' => 'auth:api'], function() {

	//Logout
	Route::post('logout', 'UserController@logout');

	//Profile
	Route::group(["prefix" => "profile"], function () {
		Route::get('/', 'UserController@userDetail');
		Route::post('/', 'UserController@updateProfile');
	});

	//Localizacion 
	Route::get('/localization/{lat}/{lng}','UserController@updateLocalization');

	//Parametros
	Route::resource('params','Params\ParamsController',
		['except' => ['create','edit','update']
	]);
	Route::put('/params', 'Params\ParamsController@update');

	//Users
	Route::resource('users','UserController',
		['except' => ['create','edit']
	]);
	//Roles
	Route::resource('roles', 'RoleController',
		['except' => ['create','edit']
	]);

	//Tags
	Route::group(["prefix" => "tags"], function () {
		Route::get('/{id}', 'Tags\TagsController@show');
		Route::delete('/{id}', 'Tags\TagsController@destroy');
		Route::post('/', 'Tags\TagsController@store');
		Route::put('/', 'Tags\TagsController@update');
		Route::get('/search/{search}', 'Tags\TagsController@search');
	});
	
	//Permissions
	Route::resource('permissions', 'PermissionController',
		['except' => ['create','edit']
	]);

	//Permissions
	Route::get('/permissionsroles/{id}','RoleController@getPermisosRoles');
	Route::get('/permissionsuser/{id}','UserController@getPermisosUser');
	Route::put('/assignpermissionsuser/{id}','UserController@asignaPermisosUser');

	Route::get('/branchs-near','Branch\BranchsController@getBranchs');

	//Productos
	Route::resource('products','Product\ProductController',
		['except' => ['create','edit','update']
	]);

	Route::post('/products/{id}', 'Product\ProductController@update');

	//Tipos Productos
	Route::get('type-products','Product\ProductController@getTiposProductos');

	//Comercios por usuarios
	Route::get('commerces-user','UserController@getUserCommerces');

	Route::get('product-commerces/{commerce}/{producto}','Product\ProductController@getCommercesProduct');
	Route::post('update-stock','Product\ProductController@updateStock');
	Route::get('total-products','Product\ProductController@getTotalProducts');

});

Route::get('existEmail/{email}', 'Auth\LoginController@existEmail');

Route::get('/tags', 'Tags\TagsController@index');

Route::resource('discount','Discount\DiscountController');
Route::resource('discount-categories','DiscountCategory\DiscountCategoryController');
Route::resource('commerce', 'Commerce\CommercesController');
Route::resource('branch', 'Branch\BranchsController');
Route::resource('commerce-categories', 'CommerceCategory\CommerceCategoriesController');

Route::post('branch-discount', 'Discount\DiscountController@branchDiscount');
Route::get('branch-discount/{id}', 'Discount\DiscountController@getBranchDiscount');
Route::get('branch-commerce/{id}', 'Discount\DiscountController@getBranchCommerce');
Route::get('branch-select/{id}/{commerce}', 'Discount\DiscountController@getBranchDiscountSelect');
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

//Discount-tags
Route::get('tags-discount/{id}', 'Discount\DiscountController@getTagsDiscount');

//Commerce-tags
Route::get('tags-commerce/{id}', 'Commerce\CommercesController@getTagsCommerce');

//Route::get('all-commerces', 'HomeInit\HomeInitController@allCommerce');
Route::match(array('GET', 'POST'), 'all-commerces', 'HomeInit\HomeInitController@allCommerce');
// Route::get('all-discounts', 'HomeInit\HomeInitController@allDiscount');s
Route::match(array('GET', 'POST'), 'all-discounts', 'HomeInit\HomeInitController@allDiscount');
Route::get('detail-commerce/{id}', 'HomeInit\HomeInitController@commerce_detail');
Route::get('detail-commerce/{id}/random', 'HomeInit\HomeInitController@commerce_detail_random');
Route::get('detail-discount/{id}', 'HomeInit\HomeInitController@discount_detail');
Route::get('commerce-detail-branchs/{id}', 'HomeInit\HomeInitController@commerce_detail_branchs');
Route::get('commerce-detail-discounts/{id}', 'HomeInit\HomeInitController@commerce_detail_discount');
Route::get('filter-tags/{id}', 'HomeInit\HomeInitController@filterTagsCommerce');
Route::get('filter-tags-discount/{id}', 'HomeInit\HomeInitController@filterTagsDiscount');


Route::post('user-has-discount','HomeInit\HomeInitController@saveUserHasDiscount');
Route::get('client', 'Cliente\ClienteController@index');

Route::get('client-user-discount/{id}', 'Cliente\ClienteController@detailUserDiscount');
Route::get('user-has-discount', 'UserHasDiscountController@listUserHasDiscount');
Route::get('authorize-discount/{id}', 'UserHasDiscountController@authorizeDiscount');
Route::get('not-authorize-discount/{id}', 'UserHasDiscountController@notAuthorize');
Route::get('cancel-discount/{id}', 'UserHasDiscountController@cancelDiscount');
Route::get('search-charcode/{charcode}', 'UserHasDiscountController@searchCharcode');
Route::get('redeemed-discount/{id}', 'UserHasDiscountController@redeemedDiscount');


Route::post('user-has-discount','HomeInit\HomeInitController@saveUserHasDiscount');
Route::get('client/{id}', 'Cliente\ClienteController@index');
Route::post('user-has-discount','HomeInit\HomeInitController@saveUserHasDiscount');
Route::get('client', 'Cliente\ClienteController@index');

Route::get('client-user-discount/{id}', 'Cliente\ClienteController@detailUserDiscount');
Route::get('user-has-discount/{iduser}', 'UserHasDiscountController@listUserHasDiscount');
Route::get('authorize-discount/{id}', 'UserHasDiscountController@authorizeDiscount');
Route::get('not-authorize-discount/{id}', 'UserHasDiscountController@notAuthorize');
Route::get('cancel-discount/{id}', 'UserHasDiscountController@cancelDiscount');
Route::get('search-charcode/{charcode}/{iduser}', 'UserHasDiscountController@searchCharcode');
Route::get('redeemed-discount/{id}', 'UserHasDiscountController@redeemedDiscount');
Route::get('client-user-discount/{id}', 'Cliente\ClienteController@detailUserDiscount');
Route::get('client/cancel-discount/{id}', 'Cliente\ClienteController@cancelUserHasDiscount');
Route::get('user-has-discount', 'UserHasDiscountController@listUserHasDiscount');
Route::get('authorize-discount/{id}', 'UserHasDiscountController@authorizeDiscount');
Route::get('not-authorize-discount/{id}', 'UserHasDiscountController@notAuthorize');
Route::get('cancel-discount/{id}', 'UserHasDiscountController@cancelDiscount');
Route::get('search-charcode/{charcode}', 'UserHasDiscountController@searchCharcode');
Route::get('redeemed-discount/{id}', 'UserHasDiscountController@redeemedDiscount');

Route::post('message-send', 'Message\MessageController@messageSend');
Route::post('message-send-conversation', 'Message\MessageController@messageSendConversation');
Route::get('all-messages/{id}', 'Message\MessageController@index');
Route::get('all-messages/{id}', 'Message\MessageController@index');
Route::get('find-thread/{id}', 'Message\MessageController@find');
Route::get('message-read/{id}', 'Message\MessageController@read');
	