<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //

    public function dashboard() : View
    {
        return view('admin.dashboard');
    }

    public function login() : View
    {
        return view('admin.auth.login');
    }

     /**
     * Get subcategories
     */
    public function getSubCategories(Request $request)
    {
        $subcategories = Category::findOrFail($request->id)->activeSubcategories;
        return $subcategories;
    }

     /**
     * Get subcategories
     */
    public function getChildCategories(Request $request)
    {
        $childcategories = SubCategory::findOrFail($request->id)->activeChildcategories;
        return $childcategories;
    }
}
