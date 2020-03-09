<?php

namespace App\Http\Controllers;
use DB;
use App\News;
use App\Product;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index(){
        return view('front/index');
    }

    public function news(){
        $news_data = News::orderBy('sort','desc')->get();
        return view('front/news',compact('news_data'));
    }

    public function news_detail($id){

        $news_data = News::with('news_imgs')->find($id);

        return view('front/news_detail',compact('news_data'));
    }

    public function productTypes(){
        // $news_data = News::orderBy('sort','desc')->get();
        return view('front//productTypes');
    }







    public function product(){
        $product_data = Product::orderBy('sort','desc')->get();
        return view('front/product',compact('product_data'));
    }
}
