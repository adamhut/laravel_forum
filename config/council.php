<?php 

return [
    'recaptcha' => [
        'key'       => env('RECAPTCHA_KEY'),
        'secret'    => env('RECAPTCHA_SECRET'),
    ],
    'reputation' => [
        'thread_published'  => 10,
        'reply_posted'=> 2,
        'best_reply_awarded' => 50,
        'reply_favorited' => 5,
    ],
];