<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Orders extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'comment',
        'order_sub_total',
        'order_shipping',
        'order_tax_amount',
        'order_tax_rate',
        'order_amount',
        'order_status'
    ];


    public function user(){
        $this->belongsTo(User::class,'user_id','id');
    }
}
