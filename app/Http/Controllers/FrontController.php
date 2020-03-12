<?php

namespace App\Http\Controllers;

use App\News;
use App\Contact;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontController extends Controller
{
    public function index()
    {
        return view('front/index');
    }

    public function news()
    {
        $news_data = News::orderBy('sort', 'desc')->get();
        return view('front/news', compact('news_data'));
    }

    public function news_detail($id)
    {

        $news_data = News::with('news_imgs')->find($id);
        return view('front/news_detail', compact('news_data'));
    }

    public function product()
    {
        $product_data = Product::orderBy('sort', 'desc')->get();
        return view('front/product', compact('product_data'));
    }

    public function contact()
    {
        return view('front/contact');
    }

    public function contact_login(Request $request)
    {

        $request->validate([

            'g-recaptcha-response' => 'recaptcha',
            // OR since v4.0.0
            recaptchaFieldName() => recaptchaRuleName(),
        ]);

        $contact_data = $request->all();
        Contact::create($contact_data);
        return redirect('/contact');
    }

    public function product_detail($productId)
    {
        $Product = Product::find($productId);
        return view('front/product_detail',compact('Product'));
    }

    public function add_cart($productId)
    {
        $Product = Product::find($productId); // assuming you have a Product model with id, name, description & price
        $rowId = $productId; // generate a unique() row ID
        $userID = Auth::user()->id; // the user ID to bind the cart contents

        // add the product to cart
        \Cart::session($userID)->add(array(
            'id' => $rowId,
            'name' => $Product->title,
            'price' => $Product->price,
            'quantity' => 1,
            'attributes' => array(),
            'associatedModel' => $Product,
        ));
        return redirect('/cart');
    }

    public function total_cart()
    {
        $userID = Auth::user()->id;
        $items = \Cart::session($userID)->getContent();
        dd($items);
        return view('front/cart',compact('items'));
    }
}
