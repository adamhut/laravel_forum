<?php

return [
    'recaptcha' => [
        'key'       => env('RECAPTCHA_KEY'),
        'secret'    => env('RECAPTCHA_SECRET'),
    ],
    'reputation' => [
        'reply_posted'=> 2,
        'reply_favorited' => 5,
        'thread_published'  => 10,
        'best_reply_awarded' => 50,
    ],
    'administrators' => [
        'ahuang@bacera.com'
    ],
];
