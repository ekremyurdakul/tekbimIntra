<?php
/**
* Created by PhpStorm.
* User: EKREM
* Date: 21.11.2016
* Time: 17:58
*/
namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{

    protected $table = 'sessions';
    protected $fillable = ['name','user_id'];

    public function groups(){
        return $this->belongsToMany('App\Group');
    }

    public function canCreateGroup($user){
        foreach ($this->groups as $g){
            if($g->memberOf($user)){
                return false;
            }
        }

        return true;
    }

}