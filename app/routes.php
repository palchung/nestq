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

//Route::controller('inquiry', 'InquiryController');
//


Route::group(['prefix' => 'inquiry'], function ()
{
    Route::get('/category/{categoryId}', 'InquiryController@getCategory');
    Route::get('/document/{categoryId}/{subcategoryId}', 'InquiryController@getDocument');
    Route::get('/guide', 'InquiryController@getGuide');
    Route::get('/search', 'InquiryController@getSearch');
});


Route::group(['prefix' => 'adminDocumentation'], function ()
{
    Route::get('/index', 'AdminDocumentationController@getIndex');
    Route::get('/new', 'AdminDocumentationController@getNew');
    Route::get('/category', 'AdminDocumentationController@getCategory');
    Route::post('/createCategory', 'AdminDocumentationController@postCreateCategory');
    Route::post('/createSubCategory', 'AdminDocumentationController@postCreateSubCategory');
    Route::post('/deleteCategory', 'AdminDocumentationController@postDeleteCategory');
    Route::post('/deleteSubCategory', 'AdminDocumentationController@postDeleteSubCategory');
    Route::post('/editSubCategory', 'AdminDocumentationController@postEditSubCategory');
    Route::post('/editCategory', 'AdminDocumentationController@postEditCategory');
    Route::post('/createDocumentation', 'AdminDocumentationController@postCreateDocumentation');
});


Route::group(['prefix' => 'adminOrder'], function ()
{
    Route::get('/index', 'AdminOrderController@getIndex');
    Route::post('/searchAccount', 'AdminOrderController@postAccount');
});


Route::group(['prefix' => 'adminPricing'], function ()
{
    Route::get('/index', 'AdminPricingController@getIndex');
    Route::post('/edit', 'AdminPricingController@postEdit');
    Route::post('/delete', 'AdminPricingController@postDelete');
    Route::post('/editScheme', 'AdminPricingController@postEditScheme');
    Route::post('/deleteScheme', 'AdminPricingController@postDeleteScheme');
    Route::post('/create', 'AdminPricingController@postCreate');
    Route::post('/createScheme', 'AdminPricingController@postCreateScheme');
});


Route::group(['prefix' => 'adminContent'], function ()
{
    Route::get('/index', 'AdminContentController@getIndex');
    Route::post('/delete', 'AdminContentController@postDelete');
    Route::post('/deactivate', 'AdminContentController@postDeactivate');
    Route::post('/activate', 'AdminContentController@postActivate');
    Route::post('/edit', 'AdminContentController@postEdit');
    Route::post('/create', 'AdminContentController@postCreate');
    Route::get('content/{whatToLoad}', 'AdminContentController@getContent');
});

Route::group(['prefix' => 'adminAccount'], function ()
{
    Route::get('/index', 'AdminAccountController@getIndex');
    Route::post('/search', 'AdminAccountController@postSearch');
});


Route::any("/admin", [
    "as"   => "/backoffice",
    "uses" => "BackofficeController@IndexAction"
]);


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


Route::any("/resetpassword", [
    "as"   => "account/resetpassword",
    "uses" => "AccountController@postResetpassword"
]);


Route::any("/reset", [
    "as"   => "account/reset",
    "uses" => "AccountController@postReset"
]);


Route::any("/", [
    "as"   => "/",
    "uses" => "IndexController@IndexAction"
]);
