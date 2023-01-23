<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {

        $products = Product::with('brand', 'type', 'category')->paginate(5);

        return response()->json([

            'success' => true,
            'results' => $products,

        ]);
    }
}
