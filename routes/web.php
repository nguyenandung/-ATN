<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UploadImage;

use App\Http\Controllers\ADMIN\HomeController as AdminHomeController;
use App\Http\Controllers\ADMIN\ProductController as AdminProductController;
use App\Http\Controllers\ADMIN\CategoryController as AdminCategoryController;
use App\Http\Controllers\ADMIN\OrderController as AdminOrderController;
use App\Http\Controllers\ADMIN\PostController;
use App\Http\Controllers\ADMIN\VoucherController;
use App\Http\Controllers\ADMIN\SettingController;


use App\Http\Controllers\Client\HomeController as ClientHomeController;
use App\Http\Controllers\Client\AuthController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\OrderController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', [ClientHomeController::class,'index'])->name('home');

Route::get('/login', function (){
    return view('client.page.auth.login');
});
Route::get('/register', function (){
    return view('client.page.auth.register');
});
Route::post('/login', [AuthController::class,'login'])->name('login');
Route::get('/tin-tuc', [ClientHomecontroller::class,'tintuc'])->name('tintuc');
Route::get('/hosocuatoi',[AuthController::class, 'profile'])->name('user.profile');
Route::post('/hosocuatoi',[AuthController::class, 'updateProfile'])->name('user.update.profile');

Route::post('/register', [AuthController::class,'register'])->name('register');
Route::get('/logout', [AuthController::class,'logout'])->name('logout');
Route::post('goiytimkiem',[ClientHomecontroller::class,'goiysearch']);
Route::post('/add-address',[AuthController::class,'addAddress']);
Route::post('/edit-address',[AuthController::class,'updateAddress']);
Route::post('/remove-address',[AuthController::class,'removeAddress']);
Route::get('/cuahang', [ClientHomeController::class,'cuahang'])->name('cuahang');
Route::get('/chitiet/{name}', [ClientHomeController::class,'chitietsanpham'])->name('chitietsanpham');
Route::get('/cuahang', [ClientHomeController::class,'locsanpham'])->name('locsanpham');
Route::post('/deleteOrder',[OrderController::class,'deleteOrder']);
Route::get('/chitietdonhang/{id}',[OrderController::class,'detailOrder'])->name('chitietdonhang');
Route::get('/danhanhang/{id}',[OrderController::class,'danhanhang'])->name('danhanhang');
Route::post('/comment', [OrderController::class,'postcomment'])->name('comment');
    Route::get('/post/{slug}',[ClientHomeController::class,'post'])->name('post.detail');
    Route::get('/emptyCart',[CartController::class,'emptyCart'])->name('emptyCart');

Route::middleware('api')->group(function(){
    Route::get('/getaddress', [AuthController::class,'getAddress'])->name('getaddress');
    Route::get('/comment/{id}', [OrderController::class,'comment'])->name('product.comment');
});
// Route::get('/getaddress',);





// Cart

Route::post('/addToCart', [CartController::class,'addToCart']);
Route::get('/giohang',[CartController::class,'index'])->name('giohang');
Route::post('/deleteCartItem',[CartController::class, 'deleteCartItem']);
Route::post('/updatequantity',[CartController::class, 'updatequantity'])->name('updatequantity');

// Order 
Route::get('/donhangcuatoi',[OrderController::class,'ordered'])->name('ordered');
Route::post('/fetchOrderByStatus',[OrderController::class,'fetchOrderByStatus'])->name('fetchOrderByStatus');
Route::get('/thanhtoan',[OrderController::class, 'index'])->name('thanhtoan');
Route::get('/responseVNPAY',[OrderController::class, 'responseVNPAY'])->name('responseVNPAY');
Route::post('/checkout',[OrderController::class, 'checkout'])->name('checkout');
// checkvoucher
Route::post('/checkvoucher',[OrderController::class,'checkvoucher'])->name('checkvoucher');




Route::get('admin/login',function(){
    return view('admin.components.login');
});
Route::post('admin/login',[AdminHomeController::class,'AdminLogin'])->name('admin.login');
Route::middleware(['adminLogin'])->prefix('admin')->group(function () {
    Route::post('/upload',[UploadImage::class,'upload'])->name('upload');

    Route::get('/dashboard',[AdminHomeController::class,'dashboard'])->name('dashboard');
    Route::post('/thongke',[AdminHomeController::class,'thongke'])->name('thongke');
    Route::get('/logout',[AdminHomeController::class,'logout'])->name('admin.logout');

    //category 

    Route::resource('category', AdminCategoryController::class);
    Route::post('/category/changeStatus', [AdminCategoryController::class,'changeStatus']);
    //product
    Route::resource('product', AdminProductController::class);

    Route::post('/product/changeStatus', [AdminProductController::class,'changeStatus']);
    Route::post('/product/deleteProduct', [AdminProductController::class,'deleteProduct']);
    Route::post('/updateProductDetail', [AdminProductController::class,'updateProductDetail']);
    Route::post('/deleteItemProductDetail', [AdminProductController::class,'deleteItemProductDetail']);
    Route::get('/themsanpham',[AdminProductController::class,'store'])->name('admin.product.store');
    Route::post('/deleteImage',[AdminProductController::class,'deleteImageByPro'])->name('product.deleteImage');
     

    // order
    Route::resource('order',AdminOrderController::class );
    Route::post('/order/changeStatus', [AdminOrderController::class,'changeStatus'])->name('order.changeStatus');
    Route::post('/order', [AdminOrderController::class,'filter'])->name('order.filter');
    // Route::get('/product',[AdminProductController::class,'showProduct'])->name('admin.product');

    //post
    Route::resource('post',PostController::class);
    Route::post('/post/xoa',[PostController::class,'xoa'])->name('post.delete');

    //voucher
    Route::resource('voucher', VoucherController::class);
    Route::post('voucher/delete', [VoucherController::class,'deleteVoucher'])->name('voucher.delete');

    //setting
    Route::get('/setting',[SettingController::class,'index'])->name('admin.setting.website');
    Route::get('/setting/slide/{id}',[SettingController::class,'edit'])->name('admin.setting.slide');
});

