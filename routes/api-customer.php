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

 Route::post('checkout/getAcceptedDelivery','CheckoutController@getAcceptedDelivery');
    Route::group([
      'middleware' => 'auth:api-customer'
    ], function() {
      Route::get('logout', 'Auth\LoginController@logout');
      Route::get('user', 'Auth\LoginController@user');
      Route::post('cancelOrder','OrderController@cancelOrder');
      
      Route::post('cart/store', 'CartController@store');
      Route::post('cart/storeCart', 'CartController@storeCart');
      Route::post('cart/updateItem','CartController@updateItem');
      Route::post('cart/removeItem', 'CartController@destroy');
      Route::post('cart/getCartDetails', 'CartController@getCartDetails');
      Route::post('cart/clearCart', 'CartController@clearCart');
      Route::post('cart/menuDetail', 'CartController@getMenuDeatail');
      Route::post('checkOut','CheckoutController@index');
      Route::post('checkout/store','CheckoutController@store');
      Route::post('checkout/searchDelivery','CheckoutController@searchDeliveryPartner');
     
      Route::post('checkout/cancelDelivery','CheckoutController@cancelAcceptedDelivery');
      
      
      Route::post('updateProfile','CustomerController@updateProfile');
      Route::post('submitUpdateProfile','CustomerController@submitUpdateProfile');
      Route::post('getAddressById','CustomerController@getAddressById');
      Route::post('getNotifications','HomeController@getNotifications');
      Route::post('reportKitchen','HomeController@reportKitchen');
      Route::post('reportDelivery','HomeController@reportDelivery');
    }); 
    Route::post('feedback','HomeController@sendFeedback');
    Route::post('cart/checkAvailable', 'CartController@checkAvailable');
    Route::post('cart/updateQuantity','CartController@updateQuantity');
    Route::post('cart/getCartDetails', 'CartController@getCartDetails');
    Route::post('resendOtp','Auth\LoginController@resendOtp');
    Route::post('otpVerify', 'Auth\LoginController@otpVerify');
    Route::post('setProfileName', 'Auth\LoginController@setProfileName');
    Route::post('coupon','CheckoutController@coupon');
    Route::post('applyCoupon','CheckoutController@applyCoupon');
    Route::post('searchDeliveryPartner','CheckoutController@searchDeliveryPartner');
    Route::post('allCategories','HomeController@getAllCategories');
    Route::post('popularCategories','HomeController@getPopularCategories');
    Route::post('allBanners','HomeController@getAllBanners');
    Route::post('allKitchens','HomeController@getKitchens');
    Route::post('search','HomeController@search');
    Route::post('allMenus','HomeController@getMenus');
    Route::post('allKitchens/{category_id}','HomeController@getKitchens');
    // Route::post('allMenus','HomeController@getMenus');
    Route::post('menuDetail','HomeController@getMenuDetail');
    Route::post('kitchenDetail','HomeController@getKitchenDetail');
    Route::post('kitchenMenu','HomeController@getKitchenMenu');
    Route::post('kitchenGallery','HomeController@getKitchenGallery');
    Route::post('kitchenReview','HomeController@getKitchenReview');
    Route::post('kitchenDeliveryType','HomeController@getKitchenDeliveryType');
    Route::post('kitchenAbout','HomeController@getKitchenAbout');
    Route::post('GetKitchenByCategory','HomeController@GetKitchenByCategory');
    Route::post('orderList','OrderController@index');
    Route::post('addOrderRating','OrderController@addOrderRating');
    Route::post('orderDetail','OrderController@getOrderDetail');
    Route::post('orderTracking','OrderController@orderTracking');
    Route::post('orderStatus','OrderController@orderStatus');
    Route::post('getCancellationReasons','OrderController@getCancellationReasons'); 
    Route::post('cancelOrder','OrderController@cancelOrder');
    Route::get('address','CustomerController@getAddress');
    Route::post('addAddress','CustomerController@addAddress');
    Route::post('deleteAddress','CustomerController@deleteAddress');
    Route::post('editAddress','CustomerController@editAddress');
    Route::post('setAsDefault','CustomerController@setAsDefault');
    Route::post('getDefaultAddress','CustomerController@getDefaultAddress');
    Route::post('getInformation','CustomerController@getInformation');
    Route::post('getFaq','CustomerController@getFaq');
    Route::post('getFavoriteKitchen','CustomerController@getFavoriteKitchen');
    Route::post('favoriteKitchen','CustomerController@favoriteKitchen');
    Route::post('removeFavorite','CustomerController@removeFavorite');
    
    
    Route::get('makePayment/{orderId}','PaymentController@index');
    Route::post('paymentStatus','PaymentController@status');
    Route::get('paymentSuccess/{orderId}','PaymentController@success');
    Route::get('paymentFailure/{orderId}','PaymentController@failure');
    
    Route::post('getReportReasons','HomeController@getReportReasons'); 
          
        Route::get('test','CheckoutController@test');


