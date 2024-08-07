<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\AppHelper;
use App\Models\Comment;
use PhpParser\Parser\Multiple;
use Illuminate\Support\Collection;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function index()
    {
        $cart=[];
        if(!empty(AppHelper::userState())){
            $userId= AppHelper::userState()->id;
            $cart=User::select(['id','first_name'])->with('carts.product')->find($userId)->toArray();
          $comment=auth()->user()->comments()->get()->toArray();
          $cart['comment']=$comment[0];
          $subtotal=0;
          $taxAmount=0;
          $data= collect($cart['carts']);
          $shipping = 10;
          $tax      = 10; //in  % percentage
          $total    =0;
          $newdata = $data->map(function($value) use(&$subtotal){
            if(is_array($value) && isset($value['product'])) {
                  $price= !empty($value['product']['pr_sale_price']) && $value['product']['pr_sale_price'] > 0 ? ($value['product']['pr_sale_price'] * $value['pr_quantity']) : ($value['product']['pr_price'] * $value['pr_quantity']);
                  $subtotal+= $price;
            }
            return null;
           });

           $taxAmount= (($subtotal+$shipping)*$tax)/100;
           $total = $subtotal+$shipping+$taxAmount;
        //   Multiple way to access cart data
        // $cart = Cart::MemberCartData()->with('getProductData')->get();
        }
        return view('cart',['cartData'=>$cart,'total'=>$total,'taxAmount'=>$taxAmount,'tax'=>$tax,'shipping'=>$shipping,'subtotal'=>$subtotal]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $userId = AppHelper::userState()->id;
         $requestData= $request->except('_token');
         foreach($requestData['cartQty'] as $cartId => $quantity ){
            if( $quantity<1){
                Cart::where('id',$cartId)->delete();
            }else{
              Cart::where('id',$cartId)->update(['pr_quantity'=> $quantity]);
            }
        }
         Comment::where('user_id',$userId)->update(['body'=>$requestData['specialNotes']]);
         return redirect()->back()->with('success','Cart Updated Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        //
    }
}
