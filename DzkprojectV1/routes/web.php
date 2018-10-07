<?php

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

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/ejemplo', function () {
    return view('ejemplo/index');
});

//Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Authentication Routes...
$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('login', 'Auth\LoginController@authenticate');
$this->post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
$this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
$this->post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Auth\ResetPasswordController@reset');

//Countries, States, Cities
$this->get('getcountries', 'CountryController@getCountries');
$this->get('getstates/{id}', 'CountryController@getStates');
$this->get('getcities/{id}', 'CountryController@getCities');

// Validations Account new
$this->get('/desactivateaccount/{user}', 'UserController@desactivateAccount');

//Valid Account
$this->get('/register/verify/{code}', 'Auth\RegisterController@emailValidation');
$this->post('/activationaccount', 'Auth\RegisterController@activationAccount');

// Profile
$this->get('profile', 'UserController@showProfileForm')->name('profile');
$this->post('profile', 'UserController@updateProfile');
// Resend Email Activation
$this->get('resendemail', 'Auth\ResendController@showResendEmailForm'); 
$this->post('resendemail', 'Auth\ResendController@resendEmail'); 
// Unlocked Account
$this->get('emailunlocked', 'Auth\ResendController@showUnlockedEmailForm'); 
$this->post('emailunlocked', 'Auth\ResendController@unlockedEmail');
$this->get('/account/verify/{code}', 'Auth\ResendController@unlockedAccount'); 
$this->post('/accountunlocked', 'Auth\ResendController@accountUnlock'); 

