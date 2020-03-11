<?php

namespace App\Http\Controllers;
use DB;
use App\News;
use App\Contact;
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

    public function product(){
        $product_data = Product::orderBy('sort','desc')->get();
        return view('front/product',compact('product_data'));
    }

    public function contact(){
        return view('front/contact');
    }



    public function contact_login(Request $request){

        $request->validate([

            'g-recaptcha-response' => 'recaptcha',
            // OR since v4.0.0
            recaptchaFieldName() => recaptchaRuleName(),
        ]);

        $contact_data = $request->all();
        Contact::create($contact_data);
        return redirect('/contact');
    }
}
