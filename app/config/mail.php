<?php

return array(
    'driver' => 'smtp',
    'host' => 'smtp.gmail.com',
    'port' => 587, //465
    'from' => array('address' => 'service@nestq.com', 'name' => 'Nestq'),
    'encryption' => 'tls', //ssl
    'username' => 'pallastimpression@gmail.com',
    'password' => '123456qwe',
    'sendmail' => '/usr/sbin/sendmail -bs',
    'pretend' => false,
);
