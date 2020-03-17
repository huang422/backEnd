<?php

namespace App\Http\Controllers;

use App\News;
use App\Order;
use App\Contact;
use App\Product;
use App\Mail\OrderShipped;
use App\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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

    public function contact_store(Request $request)
    {

        $request->validate([

            'g-recaptcha-response' => 'recaptcha',
            // OR since v4.0.0
            recaptchaFieldName() => recaptchaRuleName(),
        ]);

        //store
        $contact_data = $request->all();
        $content = Contact::create($contact_data);
        //寄信
        Mail::to($contact_data['email'])->send(new OrderShipped($content)); //to user
        Mail::to('b29791fad1-5e6f9f@inbox.mailtrap.io')->send(new OrderShipped($content)); //to admin
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

    public function update_cart(Request $request,$product_id)
    {
        $quantity = $request->quantity;
        $userID = Auth::user()->id;
        \Cart::session($userID)->update($product_id, array(
            'quantity' => $quantity,
        ));
        return 'success';
    }

    public function delete_cart(Request $request,$product_id)
    {
        $userID = Auth::user()->id;
        \Cart::session($userID)->remove($product_id);
        return 'success';
    }

    public function total_cart()
    {
        $userID = Auth::user()->id;
        $items = \Cart::session($userID)->getContent()->sort();
        return view('front/cart',compact('items'));
    }

    public function cart_checkout()
    {
        $userID = Auth::user()->id;
        $items = \Cart::session($userID)->getContent()->sort();
        return view('front/cart_checkout',compact('items'));
    }

    public function post_cart_checkout(Request $request)
    {
        $recipient_name = $request->recipient_name;
        $recipient_phone = $request->recipient_phone;
        $recipient_address = $request->recipient_address;
        $shipment_time = $request->shipment_time;

        $userID = Auth::user()->id;
        $total_price = \Cart::session($userID)->getTotal();
        if($total_price > 1200){
            $shipment_price = 0;
        }else{
            $shipment_price = 1200;
        }

        $order = new Order();
        $order->recipient_name = $recipient_name;
        $order->recipient_phone = $recipient_phone;
        $order->recipient_address = $recipient_address;
        $order->shipment_time = $shipment_time;
        $order->total_price = $total_price;
        $order->shipment_price = $shipment_price;
        $order->save();

        $new_order_id = $order->id;
        $items = \Cart::session($userID)->getContent();
        foreach($items as $row){
            $order_detail = new OrderDetail();
            $order_detail->order_id = $new_order_id;
            $order_detail->product_id = $row->id;
            $order_detail->qty = $row->quantity;
            $order_detail->price = $row->price;
            $order_detail->save();
        }
    }
}
