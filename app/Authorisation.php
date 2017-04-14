<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Authorisation extends Model
{

    protected $fillable = ['user_id','module_id','authorisation_type_id'];

    public function user(){
        return $this->belongsTo('App\User','user_id');
    }

    public function module(){
        return $this->belongsTo('App\Module','module_id');
    }

    public function authorisation(){
        return $this->belongsTo('App\AuthorisationType','authorisation_type_id');
    }

   

}
