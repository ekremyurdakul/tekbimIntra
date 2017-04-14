<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceProductHandover extends Model
{
    protected $fillable = [
        'service_product_id', 'user_id', 'person','notes',
    ];

}
