<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductSpecific;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class ProductController extends Controller
{
    public function indexAdmin()
    {
        // Fetch all products from the database
        $products = Product::orderBy('id', 'asc')->get();

        // Return the view with the products data
        return view('admin.manageproducts', ['products' => $products]);
    }

    public function search(Request $request)
    {
        if (! Auth::check()) {
            return redirect('/login')->with('message', "You must log in before search products");
        }

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
            'description' => 'required|string|max:1000',
            'price' => 'required|numeric|min:0',
            'gender_category' => 'required|string|max:255',
            'top_bottom_category' => 'required|string|max:255',
            'clothes_category' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);
        $imagePath = $request->file('image')->store('admin/uploads', 'public');

        $product = new Product();
        $product->fill($request->all());
        $product->image_path = $imagePath;
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

    // public function index(Request $request)
    // {
    //     $category = $request->query('category');

    //     $products = Product::when($category, function ($query, $category) {
    //         return $query->where('clothes_category', $category);
    //     })->get();

    //     $category = Product::select('clothes_category')->distinct()->get();

    //     return view('product', [
    //         'products' => $products,
    //         'category' => $category,
    //     ]);
    // }
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->has('category')) {
            $query->where('clothes_category', $request->category);
        }

        $products = $query->get();

        // Optional: load all categories for display
        $category = Product::select('clothes_category')->distinct()->get()->toArray();

        return view('product', compact('products', 'category'));
    }


    public function updateInventory(Request $request)
    {
        $productId = $request->input('product_id');
        $stockData = $request->input('stock');

        // Validate product exists
        $product = Product::findOrFail($productId);

        // Process each size and color combination
        foreach ($stockData as $size => $colors) {
            foreach ($colors as $color => $quantity) {
                // Find existing inventory record or create new one
                ProductSpecific::where([
                    'product_id' => $productId,
                    'size' => $size,
                    'color' => $color,
                ])->update(['stock_quantity' => $quantity]); // Delete existing record if it exists
            }
        }

        return redirect()->route('admin.manageproducts')->with('success', 'Product inventory updated successfully');
    }



    public function getProductInventory($productId)
    {
        $inventory = ProductSpecific::where('product_id', $productId)->get();

        return json_encode($inventory);
    }
}
