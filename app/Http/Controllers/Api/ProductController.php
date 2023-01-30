<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
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

    public function purchase(Request $request){
        $new_order = new Order();
        $new_order->email = $request->email;
        $new_order->address = $request->address;
        $last_order = Order::latest()->first();
        if($last_order){
            $new_code = intval(substr($last_order->code, 1));
            $new_code++;
            $new_order->code = '#' . $new_code;
        }else{
            $new_order->code = '#1';
        }
        $new_order->save();

        $list_item = [];
        foreach($request->items as $item){
            $key = $item['id'];
            $quantity = $item['quantity'];
            $list_item[$key] = ['quantity' => $quantity];
        }
        $new_order->products()->attach($list_item);
        return response()->json([
            'success' => true,
        ]);
    }
}
