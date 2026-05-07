<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class WishlistController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'auth',
        ];
    }

    public function index()
    {
        $wishlists = Wishlist::with('product.images', 'product.category')
            ->where('user_id', Auth::id())
            ->paginate(12);

        return view('wishlist.index', compact('wishlists'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $existing = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($existing) {
            return response()->json([
                'status' => false,
                'message' => 'Product already in wishlist'
            ]);
        }

        Wishlist::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Product added to wishlist'
        ]);
    }

    public function remove(Request $request, $productId)
    {
        $wishlist = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();

        if (!$wishlist) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found in wishlist'
            ]);
        }

        $wishlist->delete();

        return response()->json([
            'status' => true,
            'message' => 'Product removed from wishlist'
        ]);
    }

    public function check(Request $request)
    {
        $request->validate([
            'product_ids' => 'required|array',
            'product_ids.*' => 'exists:products,id'
        ]);

        $wishlistedProducts = Wishlist::where('user_id', Auth::id())
            ->whereIn('product_id', $request->product_ids)
            ->pluck('product_id')
            ->toArray();

        return response()->json([
            'status' => true,
            'wishlisted' => $wishlistedProducts
        ]);
    }
}
