<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'id';

    protected $fillable=[
    'brand_id',
    'pr_name',
    'pr_price',
    'pr_sale_price',
    'pr_color',
    'pr_code',
    'pr_gender',
    'pr_function',
    'pr_stock',
    'pr_description',
    'pr_image',
    'is_active'
    ];

    // protected $casts = [
    //     'is_active' => 'string',
    // ];

    public function productBrandData(){
        return $this->hasOne(Brand::class,'id','brand_id');
    }

    public function UserProductsData(){
        return  $this->belongsToMany(User::class,'carts');

    }

    public function comments(){
        return $this->morphMany(Comment::class,'commentable');
    }
}
