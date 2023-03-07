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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'Auth\LoginController@login');
    Route::post('register', 'Auth\RegisterController@register');
    Route::post('insertToken','Auth\LoginController@insertToken');


});
   Route::post('imageUpload','HomeController@imageUpload');
    Route::group([
      'middleware' => 'auth:api-deliveryPartner'
    ], function() {
          Route::get('logout', 'Auth\LoginController@logout');
          Route::get('user', 'Auth\LoginController@user');

    });
          Route::post('resendOtp','Auth\LoginController@resendOtp');
          Route::post('otpVerify', 'Auth\LoginController@otpVerify');
          
          Route::post('todayTasks','HomeController@todayTasks');
          Route::post('getDeliveryRequests','HomeController@getDeliveryRequests');
          Route::post('acceptOrder','HomeController@acceptOrder');
          Route::post('getAllDeliveryRequests','HomeController@getAllDeliveryRequests');
          
          Route::post('getInformation','HomeController@getInformation');
          
          Route::post('getPendingOrders','HomeController@getPendingOrders');
          Route::post('completedTasks','HomeController@completedTasks');
          Route::post('orderDetail','HomeController@orderDetail');
          Route::post('deliveryDetail','HomeController@deliveryDetail');
          Route::post('pickupDetail','HomeController@pickupDetail');
          Route::post('orderConfirm','HomeController@orderConfirm');
          Route::post('updateDeliveryStatus','HomeController@updateDeliveryStatus');
          Route::post('register','HomeController@register');
          Route::post('fileUpload','HomeController@fileUpload');
          Route::post('updateStatus','HomeController@updateStatus');
          Route::post('getStatus','HomeController@getStatus');
          Route::post('addBank','HomeController@addBank');
          Route::post('addKYC','HomeController@addKYC');
          Route::post('fileDelete','HomeController@fileDelete');
          Route::post('getEarnings','HomeController@getEarnings');
          Route::post('getProfile','HomeController@getProfile');
          Route::post('submitHelp','HomeController@submitHelp');
          Route::post('updateLocation','HomeController@updateLocation');
          Route::post('getPayouts','HomeController@getPayouts');
          Route::get('cronPayout','HomeController@cronPayout');
          
          
          