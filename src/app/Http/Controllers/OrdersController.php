<?php

namespace App\Http\Controllers;

use App\Models\LineItems;
use Illuminate\Http\Request;
use App\Models\Orders;

class OrdersController extends Controller
{

    public function index(Request $request){
     $orders = Orders::with('user')->get();
    //  echo "<pre>";
    //  print_r($orders[0]->user->full_name);
    //  die();
     return view('admin.orders_list',['orders'=>$orders]);
    }

    public function updateOrderStatus(Request $request,Orders $order){
        // mark order status
        $order->order_status = $request->order_status;
        $order->save();

       return redirect()->back()->with('success','Order Status Changes Successfully.');
    }

    public function getLineItems(Request $request,Orders $order){

        $items = LineItems::where('order_id', $order->id)->with(['productData','user'])->get();
        // echo "<pre>";
        // print_r($items[0]->user->full_name);
        // print_r($items[0]->productData->pr_name);
        // die();
        return view('admin.lineitems_list',['lineitems'=> $items]);

    }


}
