<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\CouponDataTable;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CouponDataTable $datatable)
    {
        return $datatable->render('admin.coupon.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.coupon.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:100'],
            'code' => ['required', 'unique:coupons,code'],
            'quantity' => ['required', 'integer'],
            'max_use' => ['required', 'integer'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'discount_type' => ['required', 'in:percentage,amount'],
            'discount_value' => ['required', 'integer'],
            'status' => ['required', 'integer']
        ]);
        
        $coupon = Coupon::create($request->all());

        if($coupon){
            return back()->with('success', 'Coupon Created!');
        }
        return back()->with('error', 'Coupon not Created!');

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Coupon $coupon)
    {
        return view('admin.coupon.edit', compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Coupon $coupon)
    {
        $request->validate([
            'name' => ['required', 'max:100'],
            'code' => ['required', Rule::unique('coupons')->ignore($coupon)],
            'quantity' => ['required', 'integer'],
            'max_use' => ['required', 'integer'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'discount_type' => ['required', 'in:percentage,amount'],
            'discount_value' => ['required', 'numeric'],
            'status' => ['required', 'integer']
        ]);
        
        if($coupon->update($request->all())){
            return back()->with('success', 'Coupon Updated!');
        }
        return back()->with('error', 'Coupon not Updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Coupon $coupon)
    {
        if($coupon->delete()){
            return response(['status' => 'success', 'message' => 'Coupon Deleted!']);
        }
        return response(['status' => 'error', 'message' => 'Coupon not Deleted!']);
    }

      /**
     * Change status of coupon
     */
    public function changeStatus(Request $request)
    {
        $coupon = Coupon::findOrFail($request->id);
        $coupon->status = $request->status == 'true' ? 1 : 0;
        if($coupon->save()){
            return response(['status' => 'success', 'message' => 'Status Updated!']);
        }
        return response(['status' => 'error', 'message' => 'Status not Updated!']);

    }
}
