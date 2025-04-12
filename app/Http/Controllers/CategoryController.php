<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CategoryController extends Controller
{
    public function showGenderCategories(Request $request, $gender_category)
{
    $gender_category = strtolower($gender_category);

    // Base query with gender
    $query = Product::where('gender_category', $gender_category);

    // If specific clothes category is selected
    if ($request->has('category')) {
        $query->where('clothes_category', $request->category);
    }

    $products = $query->get();

    // Still show all available clothes categories under this gender
    $category = Product::where('gender_category', $gender_category)
                       ->select('clothes_category')
                       ->distinct()
                       ->get()
                       ->toArray();

    return view('product', compact('products', 'category'));
}

}