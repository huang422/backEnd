<?php

namespace App\Http\Controllers;

use App\Contact;
use App\News;
use App\Product;
use Illuminate\Http\Request;

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

    public function cart()
    {
        return view('front/cart');
    }

    public function add_cart()
    {
        $Product = Product::find($productId); // assuming you have a Product model with id, name, description & price
        $rowId = 456; // generate a unique() row ID
        $userID = 2; // the user ID to bind the cart contents

// add the product to cart
        \Cart::session($userID)->add(array(
            'id' => $rowId,
            'name' => $Product->name,
            'price' => $Product->price,
            'quantity' => 4,
            'attributes' => array(),
            'associatedModel' => $Product,
        ));

    }

    public function total_cart()
    {

    }
}
