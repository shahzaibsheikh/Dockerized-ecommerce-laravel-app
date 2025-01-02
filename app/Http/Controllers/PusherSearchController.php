<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Events\ProductSearching;
class PusherSearchController extends Controller
{
    public function index(Request $request){
        $product = $request->get("product");
        // event(new ProductSearching($request->all())); // multipe ways to trigger event for pusher (websocket).
        broadcast(new ProductSearching($request->all()));
        // ProductSearching::dispatch($request->all()); using queue for event trigger for pusher (websocket).
        return redirect()->back();
    }
}
