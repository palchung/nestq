<?php

return array(
    'home' => 'localhost/nestq/public',
    'FREE' => true,
    'USER_PUBLISH_NOS' => 2,
    'POST_PERIOD' => 3, // 3 months
    // app useage setting
    'SEARCH_PRICE_RANGE' => null,
    'SEARCH_SIZE_RANGE' => null,
    'SEARCH_NOS_OF_RESULT' => 20,
    // Facebook
    'FACEBOOK_CLIENT_ID' => '247631415370862',
    'FACEBOOK_CLIENT_SECRET' => '065cef540dd26d196edfec08b27fca66',
    'FACEBOOK_SCOPE' => array('email'),
    // Google
    'GOOGLE_CLIENT_ID' => '761145058868.apps.googleusercontent.com',
    'GOOGLE_CLIENT_SECRET' => 'gHY2Cslp5dbK_meRA87DcQ5z',
    'GOOGLE_SCOPE' => array('userinfo_email', 'userinfo_profile'),
    //Payment Gateway
    'PAYPAL_USERNAME' => 'pal_1361681741_biz_api1.gmail.com',
    'PAYPAL_PASSWORD' => '7TVS762ZCRHP3KT9',
    'PAYPAL_SIGNATURE' => 'AN5wsBL8WmA82BlYz3jB-S3-gNOdADmsqW7.hDymMkMAcYe0QPtyklox',
    'PAYPAL_TEST_MODE' => True,
    'PAYPAL_CANCELURL' => 'http://127.0.0.1/nestq/public/payment/pricepage',
    'PAYPAL_RETURNURL' => 'http://127.0.0.1/nestq/public/paypal/ipn',
    'PAYMENT_CURRENCY' => 'HKD',
    'PAYPAL_API_END_POINT' => 'https://api-3t.sandbox.paypal.com/nvp', //sandbox
    //email
    'ADMIN_EMAIL' => 'palchung@gmail.com',
    'SERVICE_EMAIL' => 'service@nestq.com',
    //service ID
    'POSTING_PROPERTY_ID' => 1,
    'ACTIVE_PUSH_ID' => 2,
    'ACTIVE_MAIL_ID' => 3,
    'MESSENGER_ID' => 4,
    'REQUISITION_ID' => 5,
    'ACTIVE_PUSH_INTERVAL' => 14000, // 1000 = 1s
    // payment
    'PERMISSION_PERIOD' => 7, // 7 days
    //Log code
    'REQUEST_SUCCESS' => 1, // successfully handover
    'RESPONSIBLE_EXPIRE' => 2, // A agent service expire, property return to owner


);
