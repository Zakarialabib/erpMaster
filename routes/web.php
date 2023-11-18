<?php

declare(strict_types=1);

use App\Http\Controllers\Front\ErrorController;
use App\Http\Controllers\Front\FrontController;
use App\Http\Controllers\Front\UploadController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use App\Livewire\Front\DynamicPage;
use App\Livewire\Vendor\Dashboard as VendorDashboard;
use App\Livewire\Account\Index as AccountIndex;
use App\Livewire\Front\Blogs as FrontBlogs;
use App\Livewire\Front\DeviceShow;
use App\Livewire\Front\BlogShow as FrontBlogShow;
use App\Livewire\Front\Brands as FrontBrands;
use App\Livewire\Front\BrandPage as FrontBrandPage;
use App\Livewire\Front\Catalog as FrontCatalog;
use App\Livewire\Front\Categories as FrontCategories;
use App\Livewire\Front\Checkout as CheckoutIndex;
use App\Livewire\Front\ProductShow;
use App\Livewire\Front\SubcategoryPage;
use App\Livewire\Front\ThankYou;
use Livewire\Livewire;

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

require __DIR__.'/auth.php';

Route::get('/docs', function () {
    View::addExtension('html', 'php'); // allows .html

    return view('docs.index'); // loads /public/docs/index.html
});

Route::get('/catalog', FrontCatalog::class)->name('front.catalog');
Route::get('/categories', FrontCategories::class)->name('front.categories');
Route::get('/categorie/{slug}', [FrontController::class, 'categoryPage'])->name('front.categoryPage');
Route::get('/categories/{slug}', SubcategoryPage::class)->name('front.subcategoryPage');
Route::get('/marques', FrontBrands::class)->name('front.brands');
Route::get('/marque/{slug}', FrontBrandPage::class)->name('front.brandPage');
Route::get('/catalog/{slug}', ProductShow::class)->name('front.product');

Route::get('/panier', [FrontController::class, 'cart'])->name('front.cart');
Route::get('/confirmation-panier', CheckoutIndex::class)->name('front.checkout');

Route::get('/blogs', FrontBlogs::class)->name('front.blogs');
Route::get('/blog/{slug}', FrontBlogShow::class)->name('front.blogPage');

Route::get('/page/{slug}', DynamicPage::class)->name('front.dynamicPage');

Route::get('/device-model/{slug}', DeviceShow::class)->name('front.deviceshow');

Route::get('/generate-sitemap', [FrontController::class, 'generateSitemaps'])->name('generate-sitemaps');

Route::middleware('guest:customer')->group(function () {
    Route::get('myaccount', AccountIndex::class)->name('front.myaccount');
    Route::get('/merci-pour-votre-commande/{id}', ThankYou::class)->name('front.thankyou');
});

Route::post('/uploads', [UploadController::class, 'upload'])->name('upload');

Route::get('/lang/{lang}', [FrontController::class, 'changeLanguage'])->name('changelanguage');


Route::group(['prefix' => 'vendor', 'as' => 'vendor.', 'middleware' => ['auth', 'role:vendor']], function () {
    Route::get('/dashboard', VendorDashboard::class)->name('dashboard');
});

Route::get('/{slug?}', DynamicPage::class)->name('front.dynamicPage');

// Route::fallback(function (Request $request) {
//     return app()->make(ErrorController::class)->notFound($request);
// });

Livewire::setUpdateRoute(function ($handle) {
    return Route::post('/custom/livewire/update', $handle);
});
