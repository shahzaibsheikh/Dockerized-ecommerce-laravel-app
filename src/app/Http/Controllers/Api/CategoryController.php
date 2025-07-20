<?php

namespace App\Http\Controllers\Api;
use App\Models\Brands;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //

    public function index()
    {
      
      return Brands::all();

    }

    public function show(Brands $category){
    	
    	return $category;
    }
}
