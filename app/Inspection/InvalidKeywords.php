<?php

namespace App\Inspection;

use Exception;

class InvalidKeywords
{
    protected $keywords = [
            'Yahoo Customer Support',
    ];

    public function detect($body)
    {
        foreach ($this->keywords as $keyword) {
            if (stripos($body, $keyword) !== false) {
                throw new Exception('Your Replay contain spam');
            }
        }
    }
}
