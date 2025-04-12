<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        // Fetch all products from the database
        $products = Product::all();

        // Return the view with the products data
        return view('admin.manageproducts', ['products' => $products]);
    }
    public function search(Request $request)
    {
        $query = $request->input('query');
        $referer = $request->header('referer');

        if ($query) {
            $products = Product::where('name', 'like', "%{$query}%")
                ->orWhere('clothes_category', 'like', "%{$query}%")
                ->orWhere('gender_category', 'like', "%{$query}%")
                ->get();
        } else {
            $products = collect();
        }

        // Check if the user is coming from a product detail page
        if ($referer && strpos($referer, '/product/') !== false) {
            // Extract the product ID from the referer URL
            preg_match('/\/product\/(\d+)/', $referer, $matches);

            if (isset($matches[1])) {
                $productId = $matches[1];
                // Get the current product being viewed
                $product = DB::table('products')->where('id', $productId)->first();

                if ($product) {
                    // Return the product detail view with search results
                    return view('productdetail', compact('product', 'products'));
                }
            }
        }

        // Default: return homepage view with search results
        return view('homepage', compact('products'));
    }

    public function show($id)
    {
        $product = DB::table('products')->where('id', $id)->first();

        if (! $product) {
            return redirect()->route('homepage')->with('error', 'Product not found');
        }

        // Get related products (same category)
        $relatedProducts = DB::table('products')
            ->where('clothes_category', $product->clothes_category)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();

        return view('productdetail', compact('product', 'relatedProducts'));
    }

    public function create()
    {
        return view('admin.addproduct');
    }

    public function edit($id)
    {
        $product = DB::table('products')->where('id', $id)->first();

        if (! $product) {
            return redirect()->route('homepage')->with('error', 'Product not found');
        }

        return view('admin.editproduct', compact('product'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string|max:1000',
        ]);

        $product = new Product();
        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->description = $request->input('description');
        $product->save();
        return redirect(route('admin.manageproducts'))->with('success', 'Product added successfully!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string|max:1000',
        ]);
        $product = Product::find($request->id);
        if (! $product) {
            return redirect()->route('homepage')->with('error', 'Product not found');
        }
        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->description = $request->input('description');
        $product->save();

        return redirect(route('admin.manageproducts'))->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if (! $product) {
            return redirect()->route('homepage')->with('error', 'Product not found');
        }
        $product->delete();

        return redirect(route('admin.manageproducts'))->with('success', 'Product deleted successfully!');
    }
}
