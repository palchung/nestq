<?php

// Route::any("/property/create", [
//     "as"   => "/property/create",
//     "uses" => "PropertyController@postCreate"
// ]);


Route::controller('property', 'PropertyController');
Route::controller('account', 'AccountController');
Route::controller('oauth', 'OauthController');
Route::controller('inquiry', 'InquiryController');
Route::controller('conversation', 'ConversationController');
Route::controller('payment', 'PaymentController');
Route::controller('paypal', 'PaypalController');
Route::controller('backoffice', 'BackofficeController');
Route::controller('reminders', 'RemindersController');
Route::controller('inquiry', 'InquiryController');
Route::controller('search', 'SearchController');





//Route::any("search/property", [
//    "as"   => "search/property",
//    "uses" => "SearchController@getProperty"
//]);



Route::group(['prefix' => 'messenger'], function ()
{
    Route::post('/save_message', 'ConversationController@saveMessage');
    Route::post('/load_conversation', 'ConversationController@loadConversation');
    Route::post('/load_message', 'ConversationController@loadMessage');
});


Route::any("/angularJS", [
    "as"   => "chat/angularJS",
    "uses" => "MessengerController@Messenger"
]);

Route::get('/messengerMessage/{conversationId}', 'MessengerController@Messages');

Route::any("/notification", [
    "as"   => "chat/notification",
    "uses" => "messengerController@Notification"
]);


Route::any("/activepush", [
    "as"   => "imc/push",
    "uses" => "PushController@ActivePush"
]);

Route::any("/count_active_push", [
    "as"   => "imc/count_active_push",
    "uses" => "PushController@CountActivePush"
]);





Route::group(array('before' => 'admin'), function ()
{
    Route::controller('adminDocumentation', 'AdminDocumentationController');
    Route::controller('adminOrder', 'AdminOrderController');
    Route::controller('adminPricing', 'AdminPricingController');
    Route::controller('adminContent', 'AdminContentController');
    Route::controller('adminAccount', 'AdminAccountController');
});


Route::any("/admin", [
    "as"   => "/backoffice",
    "uses" => "BackofficeController@IndexAction"
]);


Route::any("/", [
    "as"   => "/",
    "uses" => "IndexController@IndexAction"
]);
