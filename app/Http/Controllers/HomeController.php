<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use Carbon\Carbon;
use App\Jobs\EmailJob;
use App\Helpers\AppHelper;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request){

        // if(!empty(AppHelper::userState())){
        //     $userData= AppHelper::userState();
        //    //   Syncrnous dispatch for debugging
        //     // EmailJob::dispatchSync($userData);
        //       // job to dipatch through queue worker
        //     // EmailJob::dispatch($userData);
        // }

        $startDate = Carbon::now()->subMonths(6);
        $endDate = Carbon::now()->lastOfMonth();
        $products = Product::whereBetween('created_at',[$startDate,$endDate])->inRandomOrder()->limit(10)->get()->toArray();
        return view('index_user',['products'=>$products]);
    }

    public function productInfo(Request $request,Product $product){
        // $productDetail = Product::where('id','=',$id)->first();
        $relatedProduct = Product::where('pr_gender',$product->pr_gender)->where('pr_function',$product->pr_function)->inRandomOrder()->limit(4)->get()->toArray();
        return view('product_detail',['Product'=>$product,'RelatedProduct'=>$relatedProduct]);
    }

    public function productList(Request $request){
        $requestData = $request->all();
        // $Brands = Brand::select('id','name')->get();
         $Brands = Brand::pluck('name','id');
         $products = Product::query();
         if(!empty($requestData['gender'])){
            $products = $products->where('pr_gender',$requestData['gender']);
         }

         if(!empty($requestData['price'])){

            switch($requestData['price']){
                case 'less_than_1500':
                $products = $products->where(function($query) use($requestData){
                            $query->where('pr_price','<',1500);
                            $query->orWhere('pr_sale_price','<',1500);
                });
                // $products = $products->where('pr_price','<',1500);
                break;

                case 'between_1500_5k':
                    $products = $products->where(function($query) use($requestData){
                        $query->whereBetween('pr_price',[1500,5000]);
                        $query->orWhereBetween('pr_sale_price',[1500,5000]);
            });
                    // $products = $products->whereBetween('pr_price',[1500,5000]);
                    break;

                case 'between_5k_10k':
                        $products = $products->where(function($query) use($requestData){
                            $query->whereBetween('pr_price',[5000,10000]);
                            $query->orWhereBetween('pr_sale_price',[5000,10000]);
                });
                        // $products = $products->whereBetween('pr_price',[5000,10000]);
                        break;
                 case 'between_10k_30k':
                            $products = $products->where(function($query) use($requestData){
                                $query->whereBetween('pr_price',[10000,30000]);
                                $query->orWhereBetween('pr_sale_price',[10000,30000]);
                    });
                            // $products = $products->whereBetween('pr_price',[10000,30000]);
                            break;
                 case 'greater_than_30k':
                                $products = $products->where(function($query) use($requestData){
                                    $query->where('pr_price','>',30000);
                                    $query->orWhere('pr_sale_price','>',30000);
                        });
                                // $products = $products->where('pr_price','>',30000);
                                break;
            }
         }

         if(!empty($requestData['color'])){
            $products = $products->where('pr_color',$requestData['color']);
         }
         if(!empty($requestData['function'])){
            $products = $products->where('pr_function',$requestData['function']);
         }
         if(!empty($requestData['brand'])){
            $products = $products->where('brand_id',$requestData['brand']);
         }
         if(!empty($requestData['sort_by'])){
            switch($requestData['sort_by']){
                case 'lower_to_higher':
                $products = $products->orderBy('pr_price','ASC');
                break;
                case 'higher_to_lower':
                    $products = $products->orderBy('pr_price','DESC');
                    break;
                case 'model_a_z':
                        $products = $products->orderBy('pr_name','ASC');
                        break;
                case 'model_z_a':
                        $products = $products->orderBy('pr_name','DESC');
                            break;
            }
         }

           $products = $products->paginate(12);
        //    ->toSql();
        //    echo "<pre>";
        //    print_r($products);
        //    die();
       return view('product_list',['brands'=>$Brands,'products'=>$products]);

    }
}
