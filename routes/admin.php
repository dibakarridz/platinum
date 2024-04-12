<?php

use Illuminate\Support\Facades\Route;

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

//Auth
Route::match(['get', 'head'], 'login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

//password reset
Route::match(['get', 'head'], 'password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::match(['get', 'head'], 'password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
Route::get('/store', 'DashboardController@store')->name('store');
Route::get('quoted/create', 'DashboardController@create')->name('quoted.create');
// Dashboard
Route::middleware(['auth'])->group(function () {
   
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard.index');
    Route::resource('/profile','ProfileController')->only('index','update');
    Route::get('/change-password','ProfileController@change_password')->name('change.password');
    Route::post('/update-password/{id}','ProfileController@update_password')->name('update.password');

    //user
    Route::resource('/users','User\UserController');
    Route::put('user/status/{id}', 'User\UserController@status')->name('users.status');
    Route::post('user/active/action', 'User\UserController@action')->name('users.active.action');
    Route::resource('/user/trashed','User\TrashedController')->only('index','destroy');
    Route::post('/user/trashed/action','User\TrashedController@action')->name('user.trashed.action');
    Route::get('/user/trashed/restore/{id}','User\TrashedController@restore')->name('user.trashed.restore');
    
    //setting
    Route::resource('/settings','Setting\SettingController')->only('edit','update');
    //Application Seting
    Route::get('cache-settings','Setting\SettingController@cacheSettings')->name('cache.setting');
    Route::get('cache-update/{id}','Setting\SettingController@cacheUpdate')->name('cache.update');
   
    //Vehicle
    Route::resource('/vehicles','Vehicle\VehicleController')->only('index','create','store','edit','update','destroy');
    Route::put('vehicles/status/{id}', 'Vehicle\VehicleController@status')->name('vehicle.status');
    Route::post('vehicle/active/action', 'Vehicle\VehicleController@action')->name('vehicle.active.action');
    Route::get('/vehicle/trashed','Vehicle\TrashedController@index')->name('vehicle.trashed.index');
    Route::post('vehicle/trashed/action', 'Vehicle\TrashedController@action')->name('vehicle.trashed.action');
    Route::get('vehicle/trashed/restore/{id}', 'Vehicle\TrashedController@restore')->name('vehicle.trashed.restore');
    Route::delete('vehicle/trashed/destroy/{id}', 'Vehicle\TrashedController@destroy')->name('vehicle.trashed.destroy');
    Route::get('items', 'Vehicle\VehicleController@item')->name('items');
    Route::post('/vehicle/position/change','Vehicle\VehicleController@position_change')->name('vehicle.position.change');
    //Domain
    Route::resource('/domains','Domain\DomainController')->only('index','create','store','edit','update','destroy');
    Route::put('domains/status/{id}', 'Domain\DomainController@status')->name('domain.status');
    Route::post('domain/active/action', 'Domain\DomainController@action')->name('domain.active.action');
    Route::get('/domain/trashed','Domain\TrashedController@index')->name('domain.trashed.index');
    Route::post('domain/trashed/action', 'Domain\TrashedController@action')->name('domain.trashed.action');
    Route::get('domain/trashed/restore/{id}', 'Domain\TrashedController@restore')->name('domain.trashed.restore');
    Route::delete('domain/trashed/destroy/{id}', 'Domain\TrashedController@destroy')->name('domain.trashed.destroy');
    Route::get('/domain/mail/{id}','Domain\DomainController@mail')->name('domain.mail');
    Route::post('/domain/send/mail/{id}','Domain\DomainController@sendMail')->name('domain.send.mail');

    //New Quotes
    Route::resource('/quotes','Quote\QuotesController')->only('index','edit','update','show','destroy');
    Route::get('/quotes/book/{id}','Quote\QuotesController@booked')->name('quotes.book');
    Route::put('quotes/change/status/{id}', 'Quote\QuotesController@status')->name('quotes.change.status');
    Route::get('quotes/print/{id}','Quote\QuotesController@printView')->name('quotes.print.view');

    //Quoted
    Route::resource('/quoted','Quote\QuotedController')->only('index');
    Route::get('/quotes/quoted/{id}','Quote\QuotedController@show')->name('quotes.quoted.show');
    Route::post('/quotes/send/quotation/{id}','Quote\QuotedController@send')->name('quotes.send.quotation');
    Route::put('/quotes/resend/quotation/{quote}/{quoted}','Quote\QuotedController@resend')->name('quotes.resend.quotation');
    //Booked
    Route::resource('/booked','Book\BookedController')->only('index');
    Route::get('/quotes/book/{id}','Book\BookedController@book')->name('quotes.book');
    Route::put('/quotes/book/store/{id}','Book\BookedController@store')->name('quotes.book.store');

    //Removed
    Route::resource('/removed','Remove\RemoveController')->only('index','show','destroy');
    Route::get('/removed-list','Remove\RemoveController@list')->name('removed.list');
    Route::get('removed/restore/{id}', 'Remove\RemoveController@restore')->name('removed.restore');

    //Forward
    Route::resource('/forwarded','Forward\ForwardController')->only('index');
    Route::get('/quotes/forward/{id}','Forward\ForwardController@forward')->name('quotes.forward');
    Route::put('/quotes/forward/store/{id}','Forward\ForwardController@store')->name('quotes.forward.store');

    //insert table data demo controller
    Route::get('quries/copy/data','DemoController@index')->name('query.copy.data');
    Route::get('booking/copy/data','DemoController@booking')->name('book.copy.data');
    Route::get('quoted/copy/data','DemoController@quoted')->name('quote.copy.data');
    Route::get('forward/copy/data','DemoController@forward')->name('forward.copy.data');
    Route::get('vehicle/copy/data','DemoController@vehicle')->name('vehicle.copy.data');
    Route::get('domain/copy/data','DemoController@domain')->name('domain.copy.data');
    Route::get('migrate-update', 'DemoController@migrateUpdate')->name('migrate.update');

});