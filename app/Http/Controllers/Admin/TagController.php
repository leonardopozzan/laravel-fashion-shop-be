<?php

namespace App\Http\Controllers\Admin;

use App\Functions\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::paginate(10);
        return view('admin.tags.index', compact('tags'));
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
     * @param  \App\Http\Requests\StoreTagRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->validationStore($request->all());
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator, 'store_errors');
        }
        $data = $validator->validated();
        $slug = Helpers::generateSlug($request->name);
        $data['slug'] = $slug;
        Tag::create($data);
        $added = $request->name;
        return redirect()->back()->with('message', "Tag $added added successfully!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTagRequest  $request
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        $validator = $this->validationUpdate($request->all(), $tag);
        if ($validator->fails()) {
            return redirect()->back()->with('tag_id',$tag->id)->withErrors($validator, "update_errors");
        };
        $data = $validator->validated();
        $slug = Helpers::generateSlug($request->name);
        $data['slug'] = $slug;
        $tag->update($data);
        $updated = $tag->name;
        return redirect()->back()->with('message', "Tag $updated updates successfully!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();
        $cancelled = $tag->name;

        return redirect()->route('admin.tags.index')->with('message', "$cancelled delete successfully!");
    }
    private function validationStore($data){
        $validator = Validator::make($data, [
            'name' => 'required|unique:tags|max:45|min:3',
        ],
        [
            'name.required' => 'Il nome è obbligatorio.',
            'name.min' => 'Il nome deve essere lungo almeno :min caratteri.',
            'name.max' => 'Il nome non può superare i :max caratteri.',
        ]
        );
        return $validator;
    }

    private function validationUpdate($data, $tag){
        $validator = Validator::make($data, [
            'name' => ['required', Rule::unique('tags')->ignore($tag), 'max:45', 'min:3'],
        ],
        [
            'name.required' => 'Il nome è obbligatorio.',
            'name.min' => 'Il nome deve essere lungo almeno :min caratteri.',
            'name.max' => 'Il nome non può superare i :max caratteri.',
        ]
        );
        return $validator;
    }
}

