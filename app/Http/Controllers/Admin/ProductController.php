<?php

namespace App\Http\Controllers\Admin;

use App\Functions\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Type;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Product $product)
    {
        $types = Type::all();
        $brands = Brand::all();
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.products.create', compact('product', 'types', 'brands', 'categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        $slug = Helpers::generateSlug($request->name);
        $data['slug'] = $slug;
        if($request->hasFile('image')) {
            $path = Storage::put('images', $request->image);
            $data['image'] = $path;
        }
        $new_product = Product::create($data);
        if ($request->has('tags')) {
            $new_product->tags()->attach($request->tags);
        }

        return redirect()->route('admin.products.show', $new_product->slug);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $types = Type::all();
        $brands = Brand::all();
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.products.edit', compact('product', 'types', 'brands', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();
        $slug = Helpers::generateSlug($request->name);
        $data['slug'] = $slug;
        if($request->hasFile('image')){
            if ($product->image) {
                Storage::delete($product->image);
            }

            $path = Storage::put('images', $request->image);
            $data['image'] = $path;
        }
        $updated = $product->name;
        $product->update($data);
        
        if($request->has('tags')){
            $product->tags()->sync($request->tags);
        } else {
            $product->tags()->sync([]);
        }

        return redirect()->route('admin.products.index')->with('message', "$updated updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
