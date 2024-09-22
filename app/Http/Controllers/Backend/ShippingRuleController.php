<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ShippingRuleDataTable;
use App\Http\Controllers\Controller;
use App\Models\ShippingRule;
use Illuminate\Http\Request;

class ShippingRuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ShippingRuleDataTable $datatable)
    {
        return $datatable->render('admin.shipping-rule.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.shipping-rule.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:100'],
            'type' => ['required', 'in:flat_fee,min_cost'],
            'min_cost' => ['nullable', 'required_if:type,min_cost', 'numeric'],
            'cost' => ['required', 'numeric'],
            'status' => ['required']
        ]);

        $shippingRule = ShippingRule::create($request->all());

        if($shippingRule){
            return back()->with('success', 'Shipping rule Created!');
        }
        else{
            return back()->with('error', 'Shipping rule not Created!');

        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShippingRule $shippingRule)
    {
        return view('admin.shipping-rule.edit', compact('shippingRule'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ShippingRule $shippingRule)
    {
        $request->validate([
            'name' => ['required', 'max:100'],
            'type' => ['required', 'in:flat_fee,min_cost'],
            'min_cost' => ['nullable', 'required_if:type,min_cost', 'numeric'],
            'cost' => ['required', 'numeric'],
            'status' => ['required']
        ]);


        if($shippingRule->update($request->all())){
            return back()->with('success', 'Shipping rule Updated!');
        }
        else{
            return back()->with('error', 'Shipping rule not Updated!');

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShippingRule $shippingRule)
    {
        if($shippingRule->delete()){
            return response(['status' => 'success', 'message' => 'Shipping Rule Deleted!']);
        }
        return response(['status' => 'error', 'message' => 'Shipping Rule not Deleted!']);
    }

      /**
     * Change status of coupon
     */
    public function changeStatus(Request $request)
    {
        $shippingRule = ShippingRule::findOrFail($request->id);
        $shippingRule->status = $request->status == 'true' ? 1 : 0;
        if($shippingRule->save()){
            return response(['status' => 'success', 'message' => 'Status Updated!']);
        }
        return response(['status' => 'error', 'message' => 'Status not Updated!']);

    }
}
