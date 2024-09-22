<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\SliderDataTable;
use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use App\Traits\ImageTrait;
use Illuminate\Support\Str;

class SliderController extends Controller
{
    use ImageTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(SliderDataTable $dataTable)
    {
        return $dataTable->render('admin.slider.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.slider.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'slider' => ['required', 'image', 'max:4192'],
            'type' => ['sometimes', 'string', 'max:200'],
            'title' => ['required', 'string', 'max:200'],
            'starting_price' => ['required', 'numeric'],
            'url' => ['required', 'url'],
            'button_text' => ['required', 'string', 'max:50'],
            'serial' => ['required', 'numeric'],
            'status' => 'required'
        ]);

        $slider = Slider::create($request->except('slider'));
        if($slider){
            $slider->slider = $this->uploadImage($request, Str::slug($slider->title).rand(10,99), 'sliders', 'slider');
            $slider->save();
            return back()->with('success', 'Slider Created!');
        }
        else{
            return back()->with('error', 'Slider not Created!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Slider $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slider $slider)
    {
        return view('admin.slider.edit', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            'slider' => ['nullable', 'image', 'max:4192'],
            'type' => ['sometimes', 'string', 'max:200'],
            'title' => ['required', 'string', 'max:200'],
            'starting_price' => ['required', 'numeric'],
            'url' => ['required', 'url'],
            'button_text' => ['required', 'string', 'max:50'],
            'serial' => ['required', 'numeric'],
            'status' => 'required'
        ]);

        if($slider->update($request->except('slider'))){
            $oldPath = 'sliders/'.$slider->slider;
            $filename = Str::slug($slider->title).rand(10,99);
            $banner = $this->updateImage($request, $filename, 'sliders', $oldPath, 'slider');
            if($banner != null){
                $slider->slider = $banner;
                $slider->save(); 
            }
            return redirect()->route('admin.sliders.edit', ['slider' => $slider])->with('success', 'Slider Updated!');
        }
        return back()->with('error', 'Slider not Updated!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slider $slider)
    {
        $this->deleteImage('sliders/'.$slider->slider);
        if($slider->delete()){
            return response(['status' => 'success', 'message' => 'Slider Deleted!']);
        }
        return response(['status' => 'error', 'message' => 'Slider not Deleted!']);
    }
}
