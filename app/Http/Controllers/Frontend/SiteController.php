<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\FlashSale;
use App\Models\FlashSaleItem;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SiteController extends Controller
{
    //
    /**
     * Index Page
     */

    public function index() : View
    {
        $sliders = Slider::where('status', 1)->orderBy('serial')->get();
        $flashSale = FlashSale::first();
        $flashSaleItems = FlashSaleItem::active()->home()->get();
        return view('frontend.index', compact('sliders', 'flashSale', 'flashSaleItems'));
    }

    /**
     * Flash Sales Page
     */
    public function flashSales()
    {
        $flashSale = FlashSale::first();
        $flashSaleItems = FlashSaleItem::active()->orderBy('id', 'ASC')->paginate(12);
        return view('frontend.flash-sale', compact('flashSale', 'flashSaleItems'));
    }

    /**
     * Products Page
     */
    public function products()
    {

    }

    /**
     * Product Detail
     */
    public function product(Product $product)
    {
        $product = Product::with(['brand', 'category', 'vendor', 'images', 'variants'])->find($product->id);
        return view('frontend.product', compact('product'));
    }

    public function getProduct($id)
    {
        $product = Product::with(['brand', 'images', 'active_variants'])->find($id);
        return json_encode($product);
    }
}
