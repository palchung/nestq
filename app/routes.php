<?php





Route::get('/account/dashboard/{dashboard_content}', 'AccountController@getDashboard');


Route::controller('account', 'AccountController');
Route::controller('oauth', 'OauthController');
Route::controller('property', 'PropertyController');
Route::controller('inquiry', 'InquiryController');
Route::controller('conversation', 'ConversationController');
Route::controller('payment', 'PaymentController');
Route::controller('paypal', 'PaypalController');
Route::controller('backoffice', 'BackofficeController');
Route::controller('reminders', 'RemindersController');

//Route::controller('inquiry', 'InquiryController');
//


Route::group(['prefix' => 'inquiry'], function ()
{
    Route::get('/category/{categoryId}', 'InquiryController@getCategory');
    Route::get('/document/{categoryId}/{subcategoryId}', 'InquiryController@getDocument');
    Route::get('/guide', 'InquiryController@getGuide');
    Route::get('/search', 'InquiryController@getSearch');
});


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

//Route::any("/messengerMessage", [
//    "as"   => "chat/message",
//    "uses" => "MessengerController@Messages"
//]);

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



Route::any("search/property", [
    "as"   => "search/property",
    "uses" => "SearchController@getProperty"
]);


//
//Route::group(['prefix' => 'adminDocumentation'], function ()
//{
//    Route::get('/index', 'AdminDocumentationController@getIndex');
//    Route::get('/new', 'AdminDocumentationController@getNew');
//    Route::get('/category', 'AdminDocumentationController@getCategory');
//    Route::post('/createCategory', 'AdminDocumentationController@postCreateCategory');
//    Route::post('/createSubCategory', 'AdminDocumentationController@postCreateSubCategory');
//    Route::post('/deleteCategory', 'AdminDocumentationController@postDeleteCategory');
//    Route::post('/deleteSubCategory', 'AdminDocumentationController@postDeleteSubCategory');
//    Route::post('/editSubCategory', 'AdminDocumentationController@postEditSubCategory');
//    Route::post('/editCategory', 'AdminDocumentationController@postEditCategory');
//    Route::post('/createDocumentation', 'AdminDocumentationController@postCreateDocumentation');
//});





Route::controller('adminDocumentation', 'AdminDocumentationController');
Route::controller('adminOrder', 'AdminOrderController');
Route::controller('adminPricing', 'AdminPricingController');
Route::controller('adminContent', 'AdminContentController');
Route::controller('adminAccount', 'AdminAccountController');




Route::any("/admin", [
    "as"   => "/backoffice",
    "uses" => "BackofficeController@IndexAction"
]);


Route::any("/", [
    "as"   => "/",
    "uses" => "IndexController@IndexAction"
]);
