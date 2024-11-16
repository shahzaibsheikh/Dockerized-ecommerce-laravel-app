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
use Illuminate\Support\Facades\Validator;

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
          $subtotal=  0;
          $taxAmount= 0;
          $shipping = 0;
          $tax      = 0; //in percentage %
          $total    = 0;
          
        if(!empty(AppHelper::userState()) && !empty($cart['carts']) ){
            $cart=User::select(['id','first_name'])->with('carts.product')->find(AppHelper::userState()->id)->toArray();
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

    public function addToCart(Request $request){
        $data = $request->except('_token');
        // Define validation rules
        $rules = [
               'product_id' => 'required|integer',
               'pr_quantity' => 'required|integer|min:1'
        ];

        $messages = [
            'product_id.required' => 'Product ID is required.',
            'product_id.string' => 'Product ID must be an integer.',
            'pr_quantity.required' => 'Quantity is required.',
            'pr_quantity.integer' => 'Quantity must be a valid number.',
            'pr_quantity.min' => 'Quantity must be at least 1.',
        ];

        // Create a validator instance
        $validator = Validator::make($data, $rules,$messages);

        if(empty(AppHelper::userState())){
            return response()->json([
                'status' => false,
                'errors' => 'User must Log In.'
             ], 423);
        }

        if ($validator->fails()) {
            return response()->json([
            'status' => false,
            'errors' => $validator->errors()->toArray()
         ], 422);
        }

       // Add to Cart
        $data['user_id'] = auth()->user()->id;
        Cart::create($data);

        return response()->json(['message' => 'Product added successfully!'],200);
    }
}
