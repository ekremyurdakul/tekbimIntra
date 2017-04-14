<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{

    protected $fillable = [
        'product_id', 'group_id', 'location','notes','quantity'
    ];

    public function product(){
        return $this->belongsTo('App\Product','product_id');
    }

    public function group(){
        return $this->belongsTo('App\Group','group_id');
    }
}
