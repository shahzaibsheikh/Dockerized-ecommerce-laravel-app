<?php

namespace App\Http\Controllers;

use App\Models\Brands;
use App\Models\Dealers;
use Illuminate\Http\Request;

class BrandsController extends Controller
{
    public function index(Request $request)
    {
        var_dump("lllll");
        die();
        return view('admin.brands_list');
        //
    }

    public function getBrandsData(Request $request){

         echo "<pre>";
        print_r(Brands::with('dealers')->get()->toArray());

    }

     public function getDealersData(Request $request){
         echo "<pre>";
        print_r(Dealers::with('brands')->get()->toArray());

    }
}
