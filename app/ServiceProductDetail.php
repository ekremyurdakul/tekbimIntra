<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceProductDetail extends Model
{
    protected $fillable = [
        'service_product_id', 'user_id', 'operation_type_id','sno','operation_description',
    ];

    public function operation(){
        return $this->belongsTo('App\OperationType','operation_type_id');
    }

    public function technician(){
        return $this->belongsTo('App\User','user_id');
    }

    public function product(){
        return $this->belongsTo('App\ServiceProduct','service_product_id');
    }
}
