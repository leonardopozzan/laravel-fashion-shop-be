<?php

namespace App\Http\Controllers\Admin;

use App\Functions\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::paginate(10);
        return view('admin.brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBrandRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->storeValidation($request->all());
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator, 'store_errors');
        }
        $data = $validator->validated();
        $slug = Helpers::generateSlug($request->new_name);
        $data['slug'] = $slug;
        Brand::create($data);
        return redirect()->back()->with('message', "Language {$slug} added successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBrandRequest  $request
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Brand $brand)
    {
        // dd($request->isMethod('patch'));

        $validator = $this->updateValidation($request->all(),$brand);
        if ($validator->fails()) {
            return redirect()->back()->with('brand_id',$brand->id)->withErrors($validator, "update_errors");
        }
        $data = $validator->validated();
        $slug = Helpers::generateSlug($request->name);
        $data['slug'] = $slug;
        $brand->update($data);
        return redirect()->back()->with('message', "Language {$slug} updates successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();

        return redirect()->back()->with('message', "language {$language->name} removed successfully");
    }

    private function storeValidation($request){
        $rules = [
            'name' => 'required|unique:brands|max:45'
        ];
        $messages = [
            'name.required' => 'il nome è obbligatorio',
            'name.unique' => 'il nome esiste già',
            'name.max' => 'il nome non può superare i :max caratteri',
        ];
        $validator = Validator::make($request, $rules , $messages);
        return $validator;
    }
    private function updateValidation($request, $brand){
        $rules = [
            'name' => ['required',Rule::unique('brands')->ignore($brand),'max:45']
        ];
        $messages = [
            'name.required' => 'il nome è obbligatorio',
            'name.unique' => 'il nome esiste già',
            'name.max' => 'il nome non può superare i :max caratteri',
        ];
        $validator = Validator::make($request, $rules , $messages);
        return $validator;
    }
}
