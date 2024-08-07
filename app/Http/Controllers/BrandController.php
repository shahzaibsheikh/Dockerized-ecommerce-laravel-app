<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::all();
        return view('admin.brands_list',['Brands'=>$brands]);
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.brands_add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // echo"<pre>";
        // print_r($request->all());
        // print_r($request->file('image')->getClientOriginalName());
        // die();
        $request->validate([
            'product_name'=>'required|min:5|string',
            'description'=>'required|min:10',
            'status'=>'required|in:0,1',
            'image'=>'required|mimes:jpg,jpeg,png|max:106696'
            ]);
        
       $requestData = $request->except(['_token','_method','update']);
       $imgData = 'br_'.rand().'.'.$request->file('image')->getClientOriginalName();
       $request->image->move(public_path('brands/'),$imgData);
       $requestData['image'] = $imgData;
       $requestData['name'] = $requestData['product_name'];
       $requestData['description'] = $requestData['description'];
       $requestData['is_active'] = $requestData['status'];

       $brand = Brand::create($requestData);

       return redirect()->route('Brand.create')->with('success','Brand added successfully.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $Brand)
    {
        $brand['brand']=$Brand;
        return view('admin.brands_edit',['brand'=>$brand]);
        // echo"<pre>";
        // print_r($Brand->name);
        // die();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Brand $Brand)
    {
        $request->validate([
            'name'=>'required|min:5|string',
            'description'=>'required|min:10',
        ]);

        $Brand->name= $request->name?? NULL;
        $Brand->description= $request->description??NULL;
        $Brand->save();

        return redirect()->route('Brand.index')->with('success','Brand updated successfully.');
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

    }

    public function brandUpdatePicture(Request $request,Brand $Brand){
           
           $this->validate($request,[
            'image'=>'required|mimes:jpg,jpeg,png|max:106696'
            ]);

             if(empty($Brand)){
                return redirect()->route('Brand.index')->with('danger','Something went wrong.');
             }

           $brandExistingImage = $Brand->image ?? null ;

           if(file_exists(public_path('brands/'.$brandExistingImage))){
               unlink(public_path('brands/'.$brandExistingImage));
             }

             $imgData = 'br_'.rand().'.'.$request->file('image')->getClientOriginalName();
             $request->image->move(public_path('brands/'),$imgData);

             $Brand->image = $imgData;
             $Brand->save();

             return redirect()->route('Brand.edit',[$Brand])->with('success','Brand Image updated Successfully.');

    }

    public function brandUpdateStatus(Brand $Brand,$status=null)
    {
        if(!empty($Brand) && isset($status)){
            $Brand->is_active= $status;
            $Brand->save(); 
            return redirect()->route('Brand.index')->with('success','Brand Status Updated Successfully.');
        }
   
        return redirect()->route('Brand.index')->with('danger','Something went wrong.');
    }
}
