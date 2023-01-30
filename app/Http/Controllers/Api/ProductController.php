<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Tag;
use App\Models\Type;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    public function index(Request $request)
    {
        $brand_filter = $request->query('brandFilter');
        $type_filter = $request->query('typeFilter');
        $category_filter = $request->query('categoryFilter');
        $tags_filter = $request->query('tagsFilter');
        if(!$tags_filter){
            $tags_filter = [];
        }

        $products = Product::when(!empty($type_filter), function ($q) {
            $q->where('type_id', request('typeFilter'));
        })
            ->when(!empty($category_filter), function ($q) {
                $q->where('category_id', request('categoryFilter'));
            })
            ->when(!empty($brand_filter), function ($q) {
                $q->where('brand_id', request('brandFilter'));
            })
        ->with('type','brand','category')->paginate(5);

        return response()->json([
            'success' => true,
            'results' => $products,
        ]);
    }

    public function show($slug){
        $product = Product::where('slug',$slug)->with('brand','type','category','tags')->first();
        if($product){
            return response()->json([
                'success' => true,
                'results' => $product
            ]);
        }else{
            return response()->json([
                'success' => false,
                'results' => 'Non hai trovato nessun prodotto'
            ]);
        }
        
    }

    public function properties(){
        $types = Type::all();
        $categories = Category::all();
        $brands = Brand::all();
        $tags = Tag::all();

        return response()->json([
            'success' => true,
            'types' => $types,
            'categories' => $categories,
            'brands' => $brands,
            'tags' => $tags,
        ]);
    }
}
