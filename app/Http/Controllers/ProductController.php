<?php

namespace App\Http\Controllers;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){
        $all_product = Product::all();
        return view('auth/product/index',compact('all_product'));
    }

    public function create(){
        return view('auth/product/create');
    }

    public function store(Request $request){
        $product_data = $request->all();
        Product::create($product_data);
        return redirect('/home/product');

    }
}
