<?php

namespace App\Http\Controllers\Backend\Vendor;

use App\DataTables\Vendor\ProductImageDataTable;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;

class ProductImageController extends Controller
{
    use ImageTrait;


    /**
     * Display a listing of the resource.
     */
    public function index(Product $product)
    {        
        $this->authorize('update', $product);

        $datatable =  new ProductImageDataTable($product);
        return $datatable->render('vendor.product.images.index', compact('product'));
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Product $product, Request $request)
    {
        $this->authorize('update', $product);

        $request->validate([
            'image' => ['required', 'array'],
            'image.*' => ['image', 'max:2048']
        ]);

        $imgPaths = $this->uploadImages($request, $product->slug, 'products');
        if($imgPaths != null){
            foreach ($imgPaths as $path) {
                $product->images()->create(['image' => $path]);
            }
            toastr()->success('Images Uploaded');
        }
        else{
            toastr()->error('Images not Uploaded!');
        }

        return back();
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product, ProductImage $image)
    {
        $this->authorize('update', $product);

        $this->deleteImage('product/'.$image->image);
        if($image->delete()){
            return response(['status' => 'success', 'message' => 'Image Deleted!']);
        }
        return response(['status' => 'error', 'message' => 'Image not Deleted!']);
    }
}
