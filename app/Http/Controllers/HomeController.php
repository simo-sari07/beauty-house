<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::with([
            'products' => function ($query) {
                $query->where('status', 'active')
                    ->latest()
                    ->take(4);
            }
        ])->get();

        // Since Eloquent 'take' inside 'with' doesn't limit *per parent* efficiently in standard eager loading without window functions,
        // and 'featuredProducts' is no longer the main focus, we will iterate and load manually or just accept the query usage if categories are few.
        // Better approach for small number of categories:

        // Cache the entire home page categories query for 30 minutes
        $categories = \Illuminate\Support\Facades\Cache::remember('home_categories_products', 1800, function () {
            $cats = Category::all();
            foreach ($cats as $category) {
                $category->setRelation('products', $category->products()->where('status', 'active')->with('images')->latest()->take(4)->get());
            }
            return $cats;
        });

        // Collect all products for the JS Quick View
        $featuredProducts = $categories->pluck('products')->flatten();

        return view('frontend.home', compact('categories', 'featuredProducts'));
    }
}
