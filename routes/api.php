<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Company\ListAllCompaniesController;

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


// route group
Route::get('companies', 'CompanyController@index');
Route::get('companies/{company}', 'CompanyController@show');
Route::post('companies', 'CompanyController@create');
Route::put('companies/{company}', 'CompanyController@update');
Route::delete('companies/{company}', 'CompanyController@delete');

Route::get('stations/{station}', 'StationController@show');
Route::get('stations', 'StationController@index');
Route::post('stations', 'StationController@create');
Route::put('stations/{station}', 'StationController@update');
Route::delete('stations/{station}', 'StationController@delete');
