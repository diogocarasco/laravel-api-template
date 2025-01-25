<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    //

    protected $keyType = 'string';

    protected $fillable = [
        'user_id',
        'message_id',
    ];
}
