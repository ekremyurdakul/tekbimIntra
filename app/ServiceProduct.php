<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\EventDispatcher\Tests\Service;

class ServiceProduct extends Model
{
    protected $fillable = [
        'model', 'sno', 'customer_id','fault_description','general_description','person','user_id','priority','service_status_id'
    ];
    
    public function customer(){
        return $this->belongsTo('App\Customer','customer_id');
    }

    public function technician(){
        return $this->belongsTo('App\User','technician_id');
    }

    public function details(){

        return ServiceProductDetail::where('service_product_id',$this->id);

    }
    public function user(){
        return $this->belongsTo('App\User','user_id');
    }

    public function status(){

        return $this->belongsTo('App\ServiceStatus','service_status_id');

    }
}
