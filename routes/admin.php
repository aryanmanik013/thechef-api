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

/* Route::get('/', function () {
    return view('welcome');
});
 */
Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('autocompleteajax','HomeController@autoCompleteAjax');
Route::resource('state', 'StateController');
Route::resource('country', 'CountryController');
Route::resource('faq', 'FaqController');
Route::resource('kitchen', 'KitchenController');


//Route::get('edit_profile', 'Auth\LoginController@editProfile');
Route::resource('customer', 'CustomerController');
Route::resource('coupon', 'CouponController');
Route::resource('food_category', 'FoodCategoryController');
Route::resource('payout_group', 'PayoutGroupController');
Route::get('kitchen_payout_requests', ['as'=>'kitchen_payout_requests','uses'=>'PayoutRequestController@kitchen']);
Route::get('get-kitchen-bank', ['as'=>'get-kitchen-bank','uses'=>'PayoutRequestController@getKitchenBank']);
Route::get('get-delivery-bank', ['as'=>'get-delivery-bank','uses'=>'PayoutRequestController@getDeliveryBank']);
Route::get('delivery_partner_payout_requests', ['as'=>'delivery_partner_payout_requests','uses'=>'PayoutRequestController@deliveryPartner']);


Route::get('kitchen_complete_payout', ['as'=>'kitchen_complete_payout','uses'=>'PayoutRequestController@kitchenCompletePayout']);
Route::get('delivery_partner_complete_payout', ['as'=>'delivery_partner_complete_payout','uses'=>'PayoutRequestController@deliveryPartnerCompletePayout']);
Route::resource('banner', 'BannerController');
Route::get('get_state', ['as'=>'get_state','uses'=>'KitchenController@getState']);
Route::resource('delivery-partner', 'DeliveryPartnerController');
Route::resource('delivery-charge', 'DeliveryChargeController');
Route::resource('feedback', 'FeedbackController');
Route::resource('settings', 'SettingsController');
Route::resource('information', 'InformationController');
Route::resource('kitchen-food', 'KitchenFoodController');
Route::resource('review', 'ReviewController');
Route::resource('user', 'UserController');
Route::get('order/{id}/invoice', 'OrderController@invoice')->name('invoice');
Route::resource('order', 'OrderController');
Route::get('order_cancel', ['as'=>'order_cancel','uses'=>'OrderController@updateStatus']);
Route::get('kitchen_approve', ['as'=>'kitchen_approve','uses'=>'KitchenController@kitchenApprove']);
Route::post('updateStatus', ['as'=>'updateStatus','uses'=>'OrderController@updateStatus']);
Route::post('changeReviewStatus', ['as'=>'changeReviewStatus','uses'=>'ReviewController@changeReviewStatus']);
Route::post('changeCustomerStatus', ['as'=>'changeCustomerStatus','uses'=>'CustomerController@changeCustomerStatus']);
Route::resource('history', 'OrderHistoryController');
Route::get('food-schedule/{day}/{kitchen_id}/create', 'FoodScheduleController@create')->name('food-schedule.new');
Route::get('food-schedule/{kitchen_id}', 'FoodScheduleController@index')->name('food-schedule.view');
Route::resource('food-schedule', 'FoodScheduleController');
Route::resource('notification', 'NotificationController');
Route::resource('report', 'ReportController');
Route::resource('role', 'RoleController');
Route::resource('sms-notification', 'SmsNotificationController');
Route::get('delivery_partner_approve', ['as'=>'delivery_partner_approve','uses'=>'DeliveryPartnerController@deliveryPartnerApprove']);

Route::get('image-gallery-delete', ['as'=>'image-gallery-delete','uses'=>'KitchenFoodController@imageGalleryDelete']);
Route::get('image-kitchen-gallery-delete', ['as'=>'image-kitchen-gallery-delete','uses'=>'KitchenController@imageKitchenGalleryDelete']);
Route::get('image-kitchen-slider-delete', ['as'=>'image-kitchen-slider-delete','uses'=>'KitchenController@imageKitchenSliderDelete']);

Route::get('report','ReportController@index')->name('report');
Route::post('reportFilter','ReportController@reportFilter')->name('reportFilter');

Route::get('cancelledReport','ReportController@cancelledReport')->name('cancelledReport');
Route::post('cancelledReportFilter','ReportController@cancelledReportFilter')->name('cancelledReportFilter');

Route::get('couponReport','ReportController@couponReport')->name('couponReport');
Route::post('couponReportFilter','ReportController@couponReportFilter')->name('couponReportFilter');

Route::resource('kitchen-food-schedule', 'KitchenFoodScheduleController');
Route::get('get-state', ['as'=>'get-state','uses'=>'CountryController@getState']);
Route::post('getstates', 'CountryController@state')->name('getstates');
Route::resource('inappropriate-report', 'KitchenInappropriateReportController');
Route::get('logout', 'Auth\LoginController@logout', function () {
    return abort(404);
});