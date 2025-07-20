<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'carts';
    protected $primaryKey = 'id';

    protected $fillable = [
         'id',
         'user_id',
         'pr_quantity',
         'product_id',
         'created_at'
    ];

    // public function getProductData(){
    //    return  $this->hasMany(Product::class,'id','product_id');
    // }

    // public function scopeMemberCartData(Builder $query){
    //     return $query->where('user_id', auth()->user()->id ?? null);
    // }

    public function user(){
        return  $this->belongsTo(User::class);
    }

    public function product(){
        return  $this->belongsTo(Product::class);
    }

}
