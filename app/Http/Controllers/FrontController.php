<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Mail\OrderShipped;
use App\News;
use App\Order;
use App\OrderDetail;
use App\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use TsaiYiHua\ECPay\Checkout;
use TsaiYiHua\ECPay\Services\StringService;

class FrontController extends Controller
{

    protected $checkout;

    public function __construct(Checkout $checkout)
    {
        $this->checkout = $checkout;
    }

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
        return view('front/product_detail', compact('Product'));
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

    public function update_cart(Request $request, $product_id)
    {
        $quantity = $request->quantity;
        $userID = Auth::user()->id;
        \Cart::session($userID)->update($product_id, array(
            'quantity' => $quantity,
        ));
        return 'success';
    }

    public function delete_cart(Request $request, $product_id)
    {
        $userID = Auth::user()->id;
        \Cart::session($userID)->remove($product_id);
        return 'success';
    }

    public function total_cart()
    {
        $userID = Auth::user()->id;
        $items = \Cart::session($userID)->getContent()->sort();
        return view('front/cart', compact('items'));
    }

    public function cart_checkout()
    {
        $userID = Auth::user()->id;
        $items = \Cart::session($userID)->getContent()->sort();
        return view('front/cart_checkout', compact('items'));
    }

    public function post_cart_checkout(Request $request)
    {
        $recipient_name = $request->recipient_name;
        $recipient_phone = $request->recipient_phone;
        $recipient_address = $request->recipient_address;
        $shipment_time = $request->shipment_time;

        $userID = Auth::user()->id;
        $total_price = \Cart::session($userID)->getTotal();
        if ($total_price > 1200) {
            $shipment_price = 0;
        } else {
            $shipment_price = 120;
        }

        //建立訂單
        $order = new Order();
        $order->recipient_name = $recipient_name;
        $order->recipient_phone = $recipient_phone;
        $order->recipient_address = $recipient_address;
        $order->shipment_time = $shipment_time;
        $order->total_price = $total_price;
        $order->shipment_price = $shipment_price;
        $order->save();

        $items = [];

        //建立訂單明細
        $new_order_id = $order->id;
        $cart_contents = \Cart::session($userID)->getContent();
        foreach ($cart_contents as $row) {
            $order_detail = new OrderDetail();
            $order_detail->order_id = $new_order_id;
            $order_detail->product_id = $row->id;
            $order_detail->qty = $row->quantity;
            $order_detail->price = $row->price;
            $order_detail->save();

            $product = Product::find($row->id);
            $product_name = $product->title;

            $item = [
                'name' => $product_name,
                'qty' => $row->quantity,
                'price' => $row->price,
                'unit' => '個',

            ];
            array_push($items, $item);
        }

        if ($shipment_price > 0) {
            $shipment_item = [
                'name' => '運費',
                'qty' => 1,
                'price' => 120,
                'unit' => '個',
            ];
            array_push($items, $shipment_item);
        } else {
            $shipment_item = [
                'name' => '運費',
                'qty' => 1,
                'price' => 0,
                'unit' => '個',
            ];
            array_push($items, $shipment_item);
        }

        //產生訂單編號
        $order->order_no = 'hi' . Carbon::now()->format('Ymd') . $order->id;
        $order->save();

        //送出訂單至第三方支付
        $formData = [
            'UserId' => "", // 用戶ID , Optional
            'ItemDescription' => '產品簡介',
            'OrderId' => $order->order_no,
            'Items' => $items,
            'OrderId' => 'hi' . Carbon::now()->format('Ymd') . $order->id,
            // 'ItemName' => 'Product Name',
            // 'TotalAmount' => \Cart::getTotal(),
            'PaymentMethod' => 'ALL', // ALL, Credit, ATM, WebATM
        ];

        //清空購物車

        \Cart::session($userID)->clear();

        return $this->checkout->setNotifyUrl(route('notify'))->setReturnUrl(route('return'))->setPostData($formData)->send();
    }

    public function test_check_out()
    {
        $formData = [
            'UserId' => 1, // 用戶ID , Optional
            'ItemDescription' => '產品簡介',
            'ItemName' => 'Product Name',
            'TotalAmount' => '2000',
            'PaymentMethod' => 'Credit', // ALL, Credit, ATM, WebATM
        ];
        return $this->checkout->setPostData($formData)->send();
    }

    public function notifyUrl(Request $request)
    {
        $serverPost = $request->post();
        $checkMacValue = $request->post('CheckMacValue');
        unset($serverPost['CheckMacValue']);
        $checkCode = StringService::checkMacValueGenerator($serverPost);
        if ($checkMacValue == $checkCode) {
            return '1|OK';
        } else {
            return '0|FAIL';
        }
    }

    public function returnUrl(Request $request)
    {
        $serverPost = $request->post();
        $checkMacValue = $request->post('CheckMacValue');
        unset($serverPost['CheckMacValue']);
        $checkCode = StringService::checkMacValueGenerator($serverPost);
        if ($checkMacValue == $checkCode) {
            if (!empty($request->input('redirect'))) {
                return redirect($request->input('redirect'));
            } else {

                //付款完成，下面接下來要將購物車訂單狀態改為已付款
                //目前是顯示所有資料將其DD出來
                dd($this->checkoutResponse->collectResponse($serverPost));

                $order_no = $serverPost["MerchantTradeNo"];
                $order = Order::where('order_no', $order_no)->first();
                $order->status = "已完成";
                $order->save();
                return redirect("/checkoutend/{$order_no}");
            }
        }
    }
}
