<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Product extends Model
{

    protected $fillable = [
        'productcode', 'description1', 'description2','barcode','location','imagepath',
    ];

    public function quantity($sessionId){

        $quantity = DB::select('select product_id, sum(quantity) as \'quantity\' from transactions where group_id in (select group_id from group_session where session_id = ?) group by product_id',[$sessionId])->quantity;
        return $quantity;
    }
}
