<?php

namespace App\Http\Controllers\Backend\Vendor;

use App\DataTables\Vendor\ProductDataTable;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\Product;
use App\Models\SubCategory;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    use ImageTrait;

    public function __construct()
    {
        $this->authorizeResource(Product::class, 'product');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(ProductDataTable $datatable)
    {
        return $datatable->render('vendor.product.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('status', 1)->get();
        $brands = Brand::all();
        return view('vendor.product.create', compact('categories', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:200'], 
            'category' => ['required'], 
            'brand' => ['required'],
            'thumb_img' => ['required', 'image', 'max:3000'],
            'quantity' => ['required'], 
            'price' => ['required'], 
            'sku' => ['nullable', 'unique:products'],
            'short_desc' => ['required', 'max:600'], 
            'description' => ['required'], 
            'video_link' => ['nullable', 'url'],
            'offer_start' => ['nullable', 'date'], 
            'offer_end' => ['nullable', 'date'], 
            'seo_title' => ['nullable', 'max:200'],
            'seo_description' => ['nullable', 'max:250'],
            'status' => ['required']
        ]); 

        $product = Product::create($request->except('thumb_img') + 
         [
            'vendor_id' => auth()->user()->vendor->id,
            'category_id' => $request->category,
            'subcategory_id' => $request->subcategory,
            'child_category_id' => $request->child_category,
            'brand_id' => $request->brand,
            'slug' => Str::slug($request->name),
         ]);
        if($product){
            $product->thumb_img = $this->uploadImage($request, Str::slug($product->name).rand(10,99), 'products', 'thumb_img');
            $product->save();
            return back()->with('success', 'Product Created!');
        }
        
        return back()->with('error', 'Product not Created!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {

        $categories = Category::where('status', 1)->get();
        $subcategories = SubCategory::where('category_id', $product->category_id)->where('status', 1)->get();
        $child_categories = ChildCategory::where('sub_category_id', $product->subcategory_id)->where('status', 1)->get();
        $brands = Brand::all();
        return view('vendor.product.edit', compact('categories', 'brands', 'product', 'subcategories', 'child_categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
    
        $request->validate([
            'name' => ['required', 'string', 'max:200'], 
            'category' => ['required'], 
            'brand' => ['required'],
            'thumb_img' => ['nullable', 'image', 'max:3000'],
            'quantity' => ['required'], 
            'price' => ['required'], 
            'short_desc' => ['required', 'max:600'], 
            'description' => ['required'], 
            'video_link' => ['nullable', 'url'],
            'offer_start' => ['nullable', 'date'], 
            'offer_end' => ['nullable', 'date'], 
            'seo_title' => ['nullable', 'max:200'],
            'seo_description' => ['nullable', 'max:250'],
            'status' => ['required'],
            'sku' => ['required', Rule::unique('products')->ignore($product)]
        ]); 

        if($product->update($request->except('thumb_img') + 
         [
            'vendor_id' => auth()->user()->vendor->id,
            'category_id' => $request->category,
            'subcategory_id' => $request->subcategory,
            'child_category_id' => $request->child_category,
            'brand_id' => $request->brand,
            'slug' => Str::slug($request->name),
         ]))
         {
            $oldPath = 'product/'.$product->thumb_img;
            $filename = Str::slug($product->name).rand(10,99);
            $img = $this->updateImage($request, $filename, 'products', $oldPath, 'thumb_img');
            if($img != null){
                $product->thumb_img = $img;
                $product->save(); 
            }
            return back()->with('success', 'Product Updated!');
        }
        
        return back()->with('error', 'Product not Updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //Delete images
        $images = $product->images;
        foreach ($images as $image ) {
            $this->deleteImage('product/'. $image->image);
            $image->delete();
        }

        //Delete variants
        $variants = $product->variants;
        foreach ($variants as $variant) {
            //delete items in variant
            $variant->items()->delete();
            $variant->delete();
        }

        //Delete product thumnail
        $this->deleteImage('product/'.$product->thumb_img);
        if($product->delete()){
            return response(['status' => 'success', 'message' => 'Product Deleted!']);
        }
        return response(['status' => 'error', 'message' => 'Product not Deleted!']);

    }

    /**
     * Change status of product
     */
    public function changeStatus(Request $request)
    {
        
        $product = Product::findOrFail($request->id);
        $this->authorize('update', $product);
        $product->status = $request->status == 'true' ? 1 : 0;
        if($product->save()){
            return response(['status' => 'success', 'message' => 'Status Updated!']);
        }
        return response(['status' => 'error', 'message' => 'Status not Updated!']);

    }
}
