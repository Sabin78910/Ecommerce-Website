<?php

namespace App\Http\Controllers;

use App\Models\Slide;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $slides = slide::where('status', 1)->get()->take(3);
        $categories = Category::orderBy('name')->get();
        $on_sale_products = Product::whereNotNull('sales_price')->where('sales_price', '<>', '')->inRandomOrder()->get()->take(8);
        $featured_products = Product::where('featured', 1)->inRandomOrder()->get()->take(8);
        return view('index', compact('slides', 'categories', 'on_sale_products', 'featured_products'));
    }

    public function product_search(Request $request)
    {
        $query = $request->input('query');

        if (!$query) {
            return response()->json(['error' => 'Query parameter is required'], 400);
        }

        $results = Product::where('name', 'LIKE', "%{$query}%")
            ->select('id', 'name', 'slug', 'image')
            ->take(8)
            ->get();

        if ($results->isEmpty()) {
            return response()->json(['message' => 'No products found'], 404);
        }

        return response()->json($results);
    }

}
