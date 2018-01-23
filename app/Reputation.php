<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Reputation extends Model
{
    protected $guarded = [];

    protected $table = 'reputation';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}