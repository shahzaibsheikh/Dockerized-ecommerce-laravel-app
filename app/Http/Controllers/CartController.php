<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\AppHelper;
use App\Models\Comment;
use App\Models\LineItems;
use PhpParser\Parser\Multiple;
use Illuminate\Support\Collection;
use App\Models\Orders;

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
          $subtotal= 0;
          $taxAmount= 0;
          $shipping =0;
          $tax      = 0; //in percentage %
          $total    =0;
          $userId=  !empty(AppHelper::userState()->id)?AppHelper::userState()->id: null;
          $cart=User::select(['id','first_name'])->with('carts.product')->find($userId)->toArray();

        if(!empty(AppHelper::userState()) && !empty($cart['carts']) ){
            $cart=User::select(['id','first_name'])->with('carts.product')->find($userId)->toArray();
            $comment=auth()->user()->comments()->get()->toArray();
            if(!empty($comment)) {
              $cart['comment']=$comment[0];
            }
            $data= collect($cart['carts']);
          $newdata = $data->map(function($value) use(&$subtotal){
            if(is_array($value) && isset($value['product'])) {
                  $price= !empty($value['product']['pr_sale_price']) && $value['product']['pr_sale_price'] > 0 ? ($value['product']['pr_sale_price'] * $value['pr_quantity']) : ($value['product']['pr_price'] * $value['pr_quantity']);
                  $subtotal+= $price;
            }
            return null;
           });
           $shipping = 10;
           $tax      = 10; //in percentage %

           $taxAmount= (($subtotal+$shipping)*$tax)/100;
           $total = round($subtotal+$shipping+$taxAmount);
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

    public function storeOrder(Request $request){
    $requestData= $request->all();
    // echo "<pre>";
    // print_r($requestData);
    // die();
    $userId= AppHelper::userState()->id;
    $cart=User::select(['id','first_name'])->with('carts.product')->find($userId)->toArray();
    $comment=Comment::where('user_id',$userId)->firstorfail();
    $subtotal=0;
    $taxAmount=0;
    $data= collect($cart['carts']);
    $shipping = 10;
    $tax      = 10; //in percentage %
    $total    =0;
    $newdata = $data->map(function($value) use(&$subtotal){
      if(is_array($value) && isset($value['product'])) {
            $price= !empty($value['product']['pr_sale_price']) && $value['product']['pr_sale_price'] > 0 ? ($value['product']['pr_sale_price'] * $value['pr_quantity']) : ($value['product']['pr_price'] * $value['pr_quantity']);
            $subtotal+= $price;
      }
      return null;
     });

     $taxAmount= (($subtotal+$shipping)*$tax)/100;
     $total = round($subtotal+$shipping+$taxAmount,4);
    $orderData=[
        'user_id'=>$userId,
        'comment'=>$comment->body,
        'order_sub_total'=>$subtotal,
        'order_shipping'=>$shipping,
        'order_tax_amount'=> $taxAmount,
        'order_tax_rate'=>$tax,
        'order_amount'=>$total,
        'created_at'=> now(),
        'updated_at'=> now()
    ];

    Orders::create($orderData);

    $orderId = Orders::select('id')->where('user_id',$userId)->latest()->firstorfail()->id;

       foreach($data as $key => $value){

        $totalPrice= round(!empty($value['product']['pr_sale_price']) && $value['product']['pr_sale_price'] > 0 ? ($value['product']['pr_sale_price'] * $value['pr_quantity']) : ($value['product']['pr_price'] * $value['pr_quantity']),4);
        $lineItemsData=[
            'user_id'=>$userId,
            'order_id'=>$orderId,
            'product_id'=>$value['product']['id'],
            'quantity'=>$value['pr_quantity'] ?? null,
            'product_price'=> !empty($value['product']['pr_sale_price']) && $value['product']['pr_sale_price'] > 0 ? round($value['product']['pr_sale_price'],4) : round($value['product']['pr_price'],4) ,
            'total_price'=>$totalPrice,
            'created_at'=> now(),
            'updated_at'=> now()
        ];

        LineItems::create($lineItemsData);
       }

       Cart::where('user_id',$userId)->delete();
       Comment::where('user_id',$userId)->delete();

       return redirect()->route('index-home')->with('success','Order placed successfully.');
    //    return redirect()->back()->with('success','Order placed successfully.');


    }
}
