<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Brand extends Model
{
    use HasFactory;

    protected $table = 'brands';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'description',
        'image',
        'is_active'
    ];

    public function setNameAttribute($value){
        $this->attributes['name'] = strtoupper($value);
    }

    public function getNameAttribute($value){
        // $value = $this->attributes['name'];
        return str_replace('_', ' ', $value);

    }
}
