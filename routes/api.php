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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('companies', 'CompanyController@index');
Route::get('companies/{companyId}', 'CompanyController@show');
Route::post('companies', 'CompanyController@create');
Route::put('companies/{companyId}', 'CompanyController@update');
Route::delete('companies/{companyId}', 'CompanyController@delete');

Route::post('stations', 'StationController@create');
Route::put('stations/{stationId}', 'StationController@update');
Route::delete('stations/{stationId}', 'StationController@delete');

Route::get('stations', 'StationListController@index');
Route::get('stations/{stationId}', 'StationListController@show');
Route::get('stations/list/point', 'StationListController@getAllStationsWithinRadius');
Route::get('companies/{companyId}/stations', 'StationListController@getAllStationsByCompany');
