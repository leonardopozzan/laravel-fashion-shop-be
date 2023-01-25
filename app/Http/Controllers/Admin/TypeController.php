<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Functions\Helpers;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types = Type::paginate(10);
        return view('admin.types.index', compact('types'));
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
     * @param  \App\Http\Requests\StoreTypeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->storeValidation($request->all());
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator, 'store_errors');
        }
        $data = $validator->validated();
        $slug = Helpers::generateSlug($request->name);
        $data['slug'] = $slug;
        Type::create($data);
        return redirect()->back()->with('message', "Type {$request->name} added successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function show(Type $type)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function edit(Type $type)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTypeRequest  $request
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Type $type)
    {
        $validator = $this->updateValidation($request->all(),$type);
        if ($validator->fails()) {
            return redirect()->back()->with('type_id',$type->id)->withErrors($validator, "update_errors");
        }
        $data = $validator->validated();
        $slug = Helpers::generateSlug($request->name);
        $data['slug'] = $slug;
        $type->update($data);
        return redirect()->back()->with('message', "Type {$type->name} updates successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function destroy(Type $type)
    {
        $type->delete();

        return redirect()->back()->with('message', "Type {$type->name} removed successfully");
    }

    private function storeValidation($request){
        $rules = [
            'name' => 'required|unique:types|max:45'
        ];
        $messages = [
            'name.required' => 'il nome è obbligatorio',
            'name.unique' => 'il nome esiste già',
            'name.max' => 'il nome non può superare i :max caratteri',
        ];
        $validator = Validator::make($request, $rules , $messages);
        return $validator;
    }
    private function updateValidation($request, $type){
        $rules = [
            'name' => ['required',Rule::unique('types')->ignore($type),'max:45']
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
