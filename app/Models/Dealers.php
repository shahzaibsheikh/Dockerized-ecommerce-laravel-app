<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dealers extends Model
{
    use HasFactory;

        public function brands(){
    	return $this->belongsTo(Brands::class,'id');
    }

}
