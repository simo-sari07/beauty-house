<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        // Select only necessary columns and eager load relationships
        $query = Product::select('id', 'name', 'slug', 'price', 'stock', 'category_id', 'status', 'description')
            ->where('status', 'active')
            ->with(['images', 'category:id,name']); // Optimize relationship loading

        // Category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Search
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Price filter
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Sorting
        $sort = $request->get('sort', 'default');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'newest':
                $query->latest();
                break;
            default:
                $query->latest();
                break;
        }

        // Pagination with distinct to avoid potential duplicates if joins were involved (though not currently)
        $products = $query->distinct()->paginate(12)->appends($request->except('page'));
        
        // Cache categories for performance (60 minutes)
        $categories = \Illuminate\Support\Facades\Cache::remember('shop_categories', 60, function () {
            return Category::select('id', 'name')->get();
        });

        return view('frontend.shop', compact('products', 'categories'));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('status', 'active')
            ->with(['images', 'category', 'promotion'])
            ->firstOrFail();

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'active')
            ->with('images') // Optimization: select specific columns if needed
            ->take(4)
            ->get();

        return view('frontend.product', compact('product', 'relatedProducts'));
    }

    public function suggestions(Request $request)
    {
        $query = $request->get('query');
        
        $productsQuery = Product::select('id', 'name', 'slug', 'price') // Select only what's needed
            ->where('status', 'active');

        if ($query && strlen($query) >= 2) {
            $productsQuery->where('name', 'like', "%{$query}%");
        } else {
            // "Popular" or default suggestions (e.g., latest or random)
            $productsQuery->inRandomOrder(); // Or ->latest()
        }

        $products = $productsQuery->take(10)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price, // Optional if we want to show price
                    'slug' => $product->slug
                ];
            });

        return response()->json($products);
    }
}
