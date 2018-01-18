<?php

namespace App\Rules;

use App\Inspection\Spam;

class SpamFree
{
    public function passes($attribute, $value)
    {
        try {
            return ! resolve(Spam::class)->detect($value);
        } catch (\Exception $e) {
            return false;
        }
    }
}
