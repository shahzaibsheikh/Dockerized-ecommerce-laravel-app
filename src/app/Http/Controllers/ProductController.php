<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return view('admin.product_list',['products'=>$products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         $brands = Brand::all();
        return view('admin.product_add',['brands'=> $brands]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'pr_name'=>'required|min:5|string',
            'pr_price'=>'required|numeric',
            'pr_sale_price'=>'required|numeric',
            'pr_color'=>'required|string',
            'brand_id'=>'required|exists:brands,id',
            'pr_code'=>'required|min:5',
            'pr_gender'=>'required|in:male,female,children,unisex',
            'pr_function'=>'nullable|string|max:50',
            'pr_stock'=>'required|numeric',
            'pr_description'=>'required|string|max:500',
            'pr_image'=>'nullable|mimes:jpg,jpeg,png'
            ]);

            $requestData = $request->except(['_token']);
            $imgData = 'pr_'.rand().'.'.$request->file('pr_image')->getClientOriginalName();
            $request->pr_image->move(public_path('products/'),$imgData);
            $requestData['pr_image'] = $imgData;
            $product = Product::create($requestData);

            return redirect()->route('Product.create')->with('success','Product added successfully.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }

    public function productUpdateStatus($product,$status=null){

        if(!empty($product) && isset($status)){
            $products =  Product::find($product);
            $requestData['is_active']= $status;
            $products->update($requestData);
            return redirect()->route('Product.index')->with('success','Product Status Updated Successfully.');
        }
        return redirect()->route('Product.index')->with('danger','Something went wrong.');
    }
}
