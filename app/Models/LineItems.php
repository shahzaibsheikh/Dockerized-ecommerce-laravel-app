<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Product;
use App\Models\Orders;

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
      return $this->belongsTo(User::class,'user_id','id');
    }
    public function ItemOrderDetail(){
        return $this->hasOne(Orders::class,'id','order_id')->select('id','order_status','order_shipping');
      }

    public function productData(){
       return $this->hasOne(Product::class,'id','product_id')->select('pr_name','id');
    }
}
