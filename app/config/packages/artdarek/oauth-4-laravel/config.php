<?php

return array(
    /*
      |--------------------------------------------------------------------------
      | oAuth Config
      |--------------------------------------------------------------------------
     */

    /**
     * Storage
     */
    'storage' => 'Session',
    /**
     * Consumers
     */
    'consumers' => array(
        /**
         * Facebook
         */
        'Facebook' => array(
            'client_id' => Config::get('nestq.FACEBOOK_CLIENT_ID'),
            'client_secret' => Config::get('nestq.FACEBOOK_CLIENT_SECRET'),
            'scope' => Config::get('nestq.FACEBOOK_SCOPE'),
        ),
        /**
         * Google
         */
        'Google' => array(
            'client_id' => Config::get('nestq.GOOGLE_CLIENT_ID'),
            'client_secret' => Config::get('nestq.GOOGLE_CLIENT_SECRET'),
            'scope' => Config::get('nestq.GOOGLE_SCOPE'),
        ),
    )
);
