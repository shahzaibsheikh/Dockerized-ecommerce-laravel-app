<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class LineItems extends Model
{
    use HasFactory;

    protected $table = 'line_items';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'order_id',
        'product_id',
        'quantity',
        'product_price',
        'total_price',
        'created_at	',
        'updated_at'
    ];


    public function user(){
        $this->belongsTo(User::class,'user_id','id');
    }
}
