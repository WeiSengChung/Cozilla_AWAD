<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductSpecific;
use App\Models\Product;
use App\Models\User;
use App\Models\UserProfile;
class TestDB extends Controller
{
    //
    public function testDB(){
        $productspecifics = Product::all();
        return view('welcome', ['data'=> $productspecifics]);
    }
}
