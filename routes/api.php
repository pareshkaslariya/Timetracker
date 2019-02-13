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

Route::group(['as' => 'timetracker', 'prefix' => 'timetracker', 'middleware' => [
  // 'rest.api.auth',
  // 'input.trim'
  ]], function () {
  
  
  /* START REGISTER API ROUTES*/
	Route::post('register', 'Api\ApiRegisterController\ApiRegisterController@register');
	/* END*/

  /* WorkedShift api*/
  Route::post('clock-in', 'Api\ApiWorkedShifts\ApiWorkedShiftsController@checkIn');
  Route::post('clock-out', 'Api\ApiWorkedShifts\ApiWorkedShiftsController@checkOut');
  /*END*/
	
	Route::middleware('auth:api')->get('/trueadd', function (Request $request) {
   return true;
});


	

});