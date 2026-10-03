<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ControllerShop extends Controller
{
    public function index(Request $request)
{
    // Retrieve query parameters with default values
    $size = $request->query('size') ? (int) $request->query('size') : 12;
    $order_column = "";
    $order_order = "";
    $order = $request->query('order') ? (int) $request->query('order') : -1;
    $brand_filter = $request->query('brands') ? explode(',', $request->query('brands')) : [];
    $categories_filter = $request->query('categories') ? explode(',', $request->query('categories')) : [];
    $minimum_price = $request->query('min') ? (float) $request->query('min') : 1;
    $maximum_price = $request->query('max') ? (float) $request->query('max') : 1000000;

    // Determine sorting order
    switch ($order) {
        case 6:
            $order_column = "created_at";
            $order_order = "DESC";
            break;

        case 5:
            $order_column = "created_at";
            $order_order = "ASC";
            break;

        case 1:
            $order_column = "name";
            $order_order = "ASC";
            break;

        case 2:
            $order_column = "name";
            $order_order = "DESC";
            break;

        case 3:
            $order_column = "sales_price";
            $order_order = "ASC";
            break;

        case 4:
            $order_column = "sales_price";
            $order_order = "DESC";
            break;

        default:
            $order_column = "id";
            $order_order = "DESC";
    }

    // Retrieve brands and categories for filters
    $brands = Brand::orderBy('name', 'ASC')->get();
    $categories = Category::orderBy('name', 'ASC')->get();

    // Filter products based on brands, categories, and price range
    $products = Product::when(!empty($brand_filter), function ($query) use ($brand_filter) {
            $query->whereIn('brand_id', $brand_filter);
        })
        ->when(!empty($categories_filter), function ($query) use ($categories_filter) {
            $query->whereIn('category_id', $categories_filter);
        })
        ->where(function ($query) use ($minimum_price, $maximum_price) {
            $query->whereBetween('regular_price', [$minimum_price, $maximum_price])
                  ->orWhereBetween('sales_price', [$minimum_price, $maximum_price]);
        })
        ->orderBy($order_column, $order_order)
        ->paginate($size);

    // Return the shop view with the necessary data
    return view('shop', compact(
        'products', 'size', 'order', 'brands', 'brand_filter', 'categories', 'categories_filter', 'minimum_price', 'maximum_price'
    ));
}

    public function details_product($product_slug)
    {
            $product = Product::where('slug', $product_slug)->first();

            if (!$product) {
                abort(404, 'Product not found'); // Handle the case where the product does not exist
            }

            $otherProducts = Product::where('slug', '!=', $product_slug)
                        ->where('category_id', $product->category_id)
                        ->take(10)
                        ->get();


            return view('product_detail', compact('product','otherProducts'));
    }

}
