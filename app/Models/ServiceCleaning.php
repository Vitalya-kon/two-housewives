<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceCleaning extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'service',
        'url_image',
        'description',
        'from_price',
        'to_price',
        'from_last_price',
        'to_last_price'
    ];
}
