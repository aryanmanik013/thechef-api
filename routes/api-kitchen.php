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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group([
    'prefix' => 'auth'
], function () {
        Route::post('login', 'Auth\LoginController@login');
        Route::post('register', 'Auth\RegisterController@register');
        Route::post('insertToken','Auth\LoginController@insertToken');
});
        Route::post('imageUpload','HomeController@imageUpload');
        Route::group([
          'middleware' => 'auth:api-kitchen'
        ], function() {
              Route::get('logout', 'Auth\LoginController@logout');
              Route::post('getUser', 'Auth\LoginController@user');
        });
        Route::post('resendOtp','Auth\LoginController@resendOtp');
        Route::post('otpVerify', 'Auth\LoginController@otpVerify');
        
        Route::post('allCategories','HomeController@getAllCategories');
        Route::post('menu','HomeController@getMenu');
        Route::post('getAllMenu','HomeController@getAllMenu');
        Route::post('getInformation','HomeController@getInformation');
        Route::post('getFaq','HomeController@getFaq');
        Route::post('addMenu','HomeController@addMenu');
        Route::post('editMenu','HomeController@editMenu');
        Route::post('updateMenu','HomeController@updateMenu');
        Route::post('updateMenuStatus','HomeController@updateMenuStatus');
        Route::post('updateOrderStatus','HomeController@updateOrderStatus');
        Route::post('orders','HomeController@index');
        Route::post('getAllOrders','HomeController@getAllOrders');
        Route::post('salesInfo','HomeController@salesInfo');
        Route::post('orderDetail','HomeController@getOrderDetail');
        Route::post('profile','KitchenController@getKitchen');
        Route::post('repostMenu','HomeController@RepostMenu');
        Route::post('foodDelete','KitchenController@foodDelete');
        Route::post('foodSchedule','KitchenController@foodSchedule');
        Route::post('scheduleFood','KitchenController@scheduleFood');
        Route::post('addFood','KitchenController@addFood');
        Route::post('getProfile','KitchenController@getProfile');
        Route::post('getFiles','KitchenController@getFiles');
        Route::post('profileStatus','KitchenController@profileStatus');
        Route::post('register','KitchenController@register');
        Route::post('kitchenAbout','KitchenController@getKitchenAbout');
        Route::post('editKitchen','KitchenController@editKitchen');
        Route::post('updateKitchen','KitchenController@updateKitchen');
        Route::post('support','KitchenController@support');
        Route::post('notifications','KitchenController@getNotifications');
        Route::post('updateStatus','KitchenController@updateStatus');
        Route::post('fileUpload','KitchenController@fileUpload');
        Route::post('imageDelete','KitchenController@imageDelete');
        Route::post('insight','KitchenController@insight');
        Route::post('report','ReportController@index');
        Route::post('cancelledReport','ReportController@cancelledReport');
        Route::post('completedReport','ReportController@completedReport');
        Route::post('couponReport','ReportController@couponReport');
        Route::post('mapReport','ReportController@mapReport');
        Route::post('getNotifications','HomeController@getNotifications');
        Route::post('getPayouts','KitchenController@getPayouts');
        Route::get('cronFoodSchedule','KitchenController@cronFoodSchedule');
        Route::get('cronManageFood','KitchenController@cronManageFood');
        Route::get('cronPayout','KitchenController@cronPayout');