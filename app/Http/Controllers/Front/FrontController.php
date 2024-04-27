<?php

declare(strict_types=1);

namespace App\Http\Controllers\Front;

use App\Models\Blog;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\Page;
use App\Models\Product;
use App\Models\Subcategory;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Throwable;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class FrontController extends Controller
{
    public function index()
    {
        $products = Product::active()->paginate(3);

        return view('front.index', ['products' => $products]);
    }

    public function changeLanguage($lang)
    {
        $availableLanguages = cache()->get('languages');

        if (array_key_exists($lang, $availableLanguages)) {
            Session::put('language', $lang);
        }

        return redirect()->back();
    }

    public function catalog()
    {
        return view('front.catalog');
    }

    public function productShow($slug)
    {
        $product = Product::where('slug', $slug)->first() ?? abort(404);

        return view('front.product', ['product' => $product]);
    }

    public function categories()
    {
        return view('front.categories');
    }

    public function categoryPage($slug)
    {
        $category = Category::where('slug', $slug)->first() ?? abort(404);

        return view('front.category-page', ['category' => $category]);
    }

    public function subcategories()
    {
        return view('front.subcategories');
    }

    public function SubcategoryPage($slug)
    {
        $subcategory = Subcategory::where('slug', $slug)->first() ?? abort(404);

        return view('front.subcategory-page', ['subcategory' => $subcategory]);
    }

    public function brands()
    {
        return view('front.brands');
    }

    public function brandPage($slug)
    {
        $brand = Brand::where('slug', $slug)->first() ?? abort(404);

        return view('front.brand-page', ['brand' => $brand]);
    }

    public function cart()
    {
        return view('front.cart');
    }

    public function checkout()
    {
        return view('front.checkout');
    }

    public function contact()
    {
        return view('front.contact');
    }

    public function about()
    {
        return view('front.about');
    }

    public function blog()
    {
        $blogs = Blog::with('category')->get();

        return view('front.blog', ['blogs' => $blogs]);
    }

    public function blogPage($slug)
    {
        $blog = Blog::where('slug', $slug)->first() ?? abort(404);

        return view('front.blog-page', ['blog' => $blog]);
    }

    // thanks page
    public function thankyou(Order $order)
    {
        return view('front.order-summary', ['order' => $order]);
    }

    public function dynamicPage($slug)
    {
        $page = Page::where('slug', $slug)->first() ?? abort(404);

        return view('front.dynamic-page', ['page' => $page]);
    }

    public function myaccount(User $customer)
    {
        $customer = User::where('id', auth()->user()->id)->get();

        return view('front.user-account', ['customer' => $customer]);
    }

    public function generateSitemaps()
    {
        try {
            Artisan::call('generate:sitemap');

            Log::info('Sitemap generated successfully!');

            return back();
        } catch (Throwable $throwable) {
            Log::info('Sitemap generation failed!', $throwable->getMessage());

            return back();
        }
    }
}
