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
Route::get('companies', 'Company\ListAllCompaniesController');
Route::get('companies/{company}', 'Company\ShowSingleCompanyController');
Route::post('companies', 'Company\CreateCompanyController');
Route::put('companies/{company}', 'Company\UpdateCompanyController');
Route::delete('companies/{company}', 'Company\DeleteCompanyController');

Route::get('companies/{company}/stations', 'Station\ListCompanyStationsController');

Route::get('stations/{station}', 'Station\ShowSingleStationController');
Route::get('stations', 'Station\ListAllStationsController');
Route::post('stations', 'Station\CreateStationController');
Route::put('stations/{station}', 'Station\UpdateStationController');
Route::delete('stations/{station}', 'Station\DeleteStationController');
