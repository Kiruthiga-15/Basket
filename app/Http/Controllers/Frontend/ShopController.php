<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        // Get all active products with relationships
        $products = Product::with(['category', 'images', 'variationTypeSize', 'variationValueSize', 'variationTypeColor', 'variationValueColor'])
            ->where('status', 1)
            ->paginate(12);

        // Get all categories for filter
        $categories = Category::where('status', 1)->get();

        // Get user's wishlisted product IDs if authenticated
        $wishlistedProductIds = [];
        if (Auth::check()) {
            $wishlistedProductIds = Auth::user()->wishlists->pluck('product_id')->toArray();
        }

        return view('shop.shop', compact('products', 'categories', 'wishlistedProductIds'));
    }

    public function getProducts(Request $request)
    {
        $query = Product::with(['category', 'images', 'variationTypeSize', 'variationValueSize', 'variationTypeColor', 'variationValueColor'])
            ->where('status', 1);

        // Filter by category if provided
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        // Filter by price range if provided
        if ($request->has('min_price') && $request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->has('max_price') && $request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }

        // Search by name if provided
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->paginate(12);

        // Get user's wishlisted product IDs
        $wishlistedProductIds = [];
        if (Auth::check()) {
            $wishlistedProductIds = Auth::user()->wishlists->pluck('product_id')->toArray();
        }

        return response()->json([
            'products' => $products,
            'wishlisted' => $wishlistedProductIds,
            'pagination' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total()
            ]
        ]);
    }
}