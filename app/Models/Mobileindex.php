<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mobileindex extends Model
{
    protected $table = 'mobileindices';

    protected $fillable = [
        'mobile_images',
    ];

    protected $casts = [
        'mobile_images' => 'array',
    ];
}
