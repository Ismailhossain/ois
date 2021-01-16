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
//    return view('welcome');
    return View('layouts.master');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');



// For User/agents Management

Route::get('bank_accounts', [
    'uses' => 'BankAccountController@index',
]);

Route::post('bank_accounts/store', [
    'uses' => 'BankAccountController@store',
]);

Route::post('bank_accounts/edit', [
    'uses' => 'BankAccountController@edit',
]);
Route::post('bank_accounts/update', [
    'uses' => 'BankAccountController@update',
]);

Route::post('bank_accounts/destroy', [
    'uses' => 'BankAccountController@destroy',
]);


// For User/agents Management

Route::get('user', [
    'uses' => 'UserController@index',
]);

Route::post('user/store', [
    'uses' => 'UserController@store',
]);

Route::post('user/edit', [
    'uses' => 'UserController@edit',
]);
Route::post('user/update', [
    'uses' => 'UserController@update',
]);

Route::post('user/destroy', [
    'uses' => 'UserController@destroy',
]);


// Property Management

Route::get('property', [
    'uses' => 'PropertyController@index',
]);
Route::post('property/store', [
    'uses' => 'PropertyController@store',
]);

Route::post('property/edit', [
    'uses' => 'PropertyController@edit',
]);

Route::post('property/update', [
    'uses' => 'PropertyController@update',
]);

Route::post('property/destroy', [
    'uses' => 'PropertyController@destroy',
]);


// Report Management

Route::get('report', [
    'uses' => 'ReportController@index',
]);

Route::post('agent/name/autocomplete', [
    'uses' => 'ReportController@nameSearch',
]);

Route::post('agent/report', [
    'uses' => 'ReportController@agentReport',
]);

Route::get('agent/report/export/{ID}', [
    'uses' => 'ReportController@agentReportExport',
]);
