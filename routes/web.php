<?php
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\App;
use App\Providers\LanguageServiceProvider;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function (\App\PaymentServices\NewPayPal $payment) {
//   dd($payment->pay());
//      dd(app());
//     return view('welcome');
// });
Route::get('/debug-locale', function () {

    // dd( __('lang.2') );
     // Instantiate the LanguageServiceProvider
     $provider = new LanguageServiceProvider(app());

     // Call the `boot` method directly
     $provider->boot();

    //  return response()->json([
    //      'message' => 'LanguageServiceProvider boot method executed successfully.'
    //  ]);
})->name('guest');


Route::controller(\App\Http\Controllers\HomeController::class)->group(function(){
    Route::get('/','index')->name('index-home');
    Route::get('/view-product/{product:pr_code}','productInfo')->name('product_info');
    Route::get('/view-list','productList')->name('product-list');
});

// Route::get('/',[ProductController::class,'index'])->name('products.index');
Route::get('product/create',[ProductController::class,'create'])->name('products.create');
Route::post('product/store',[ProductController::class,'store'])->name('product.store');


Route::controller(\App\Http\Controllers\AuthenticationController::class)->group(function(){
    Route::get('/register','register')->name('register');
    Route::post('/register','storeUser')->name('store-user');
    Route::get('/login-user','login')->name('login');
    Route::post('/login','UserLogin')->name('authenticate');
    Route::get('/forget-password','forgetPassword')->name('forget-password');
    Route::post('/user-forget-password','SendForgetUserPasswordEmail')->name('forget-User-Password-Email');
    Route::get('/logout','UserLogout')->name('user-logout');
});

Route::controller(\App\Http\Controllers\UserController::class)->group(function(){
  Route::get('/profile','UserProfile')->name('user-profile');
  Route::put('/Profile-Update','UserProfileUpdate')->name('profile-update');
  Route::post('/Profile-Image-Update','UserProfileImageUpdate')->name('profile-img-update');

});

Route::group(['prefix'=>'/admin','middleware'=>['auth.custom']],function(){
    Route::controller(\App\Http\Controllers\admincontroller::class)->group(function(){
        Route::get('/','index')->name('admin-home');
        Route::get('/user-list','usersList')->name('admin-user-list');
        Route::get('/edit-user/{id}','userEdit')->name('admin-user-edit');
        Route::put('/update-user/{id}','userUpdate')->name('admin-user-update');
        Route::put('/update-user-picture/{id}','userUpdatePicture')->name('admin-user-update-picture');
        Route::get('/update-user-status/{id}/{status?}','userUpdateStatus')->name('admin-user-update-status');
      });

});

Route::resource('Brand',\App\Http\Controllers\BrandController::class)->middleware(['auth.custom']);
Route::middleware(\App\Http\Middleware\EnsureAuthenticated::class)->group(function(){
    Route::put('Brand/brand-user-picture/{Brand}',[\App\Http\Controllers\BrandController::class,'brandUpdatePicture'])->name('admin-brand-update-picture');
    Route::get('/update-brand-status/{Brand}/{status?}',[\App\Http\Controllers\BrandController::class,'brandUpdateStatus'])->name('admin-brand-update-status');
});

Route::resource('Product',\App\Http\Controllers\ProductController::class)->middleware(['auth.custom']);
Route::get('/update-product-status/{Product}/{status?}',[\App\Http\Controllers\ProductController::class,'productUpdateStatus'])->name('admin-product-update-status');


Route::resource('Cart',\App\Http\Controllers\CartController::class);
Route::get('store-order',[\App\Http\Controllers\CartController::class,'storeOrder'])->name('Store-Order');
Route::post('add-to-cart', [\App\Http\Controllers\CartController::class, 'addToCart'])->name('Add_to_cart');

Route::group(['prefix'=>'/admin','middleware'=>['auth.custom'],'controller'=>\App\Http\Controllers\OrdersController::class],function(){
    Route::get('/Orders','index')->name('order-index');
    Route::post('/Order-Status/{order}','updateOrderStatus')->name('update-order-status');
    Route::get('/Order-LineItems/{order}','getLineItems')->name('order-line-items');
});
