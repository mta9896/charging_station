<?php

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

Route::prefix('companies')->group(function () {
    Route::get('/', 'CompanyController@index');
    Route::get('/{companyId}', 'CompanyController@show');
    Route::post('/', 'CompanyController@create');
    Route::put('/{companyId}', 'CompanyController@update');
    Route::delete('/{companyId}', 'CompanyController@delete');
    Route::get('/{companyId}/stations', 'CompanyController@getStationsByCompany');
});

Route::prefix('stations')->group(function () {
    Route::get('/', 'StationController@index');
    Route::get('/{stationId}', 'StationController@show');
    Route::post('/', 'StationController@create');
    Route::put('/{stationId}', 'StationController@update');
    Route::delete('/{stationId}', 'StationController@delete');
});

