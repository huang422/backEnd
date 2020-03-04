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

         //上傳檔案
         $file_name = $request->file('img')->store('', 'public');
         $product_data['img'] = $file_name;

        Product::create($product_data);
        return redirect('/home/product');
    }

    public function edit($id){
        $product = Product::find($id);
        return view('auth/product/edit',compact('product'));
    }

    public function update(Request $request,$id){
        $product = Product::find($id);
        $product->img = $request->img;
        $product->title = $request->title;
        $product->sort = $request->sort;
        $product->text = $request->text;
        $product->save();

        return redirect('/home/product');
    }

    public function delete(Request $request,$id){
        Product::find($id)->delete();
        return redirect('/home/product');
    }
}
