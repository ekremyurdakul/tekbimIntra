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

class Group extends Model
{
    use Notifiable;

    protected $table = 'groups';
    protected $fillable = ['name'];

    public function users(){
        return $this->belongsToMany('App\User');
    }

    public function owner(){
        return $this->belongsTo('App\User','user_id');
    }

    public function memberOf($user){

        foreach($this->users as $u){
            if($u->id == $user->id){
                return true;
            }
        }

        return false;
    }
    
    public function sessions(){
        return $this->belongsToMany('App\Session');
    }


}