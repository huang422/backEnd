<?php

namespace App\Http\Controllers;
use App\Product;
use App\ProductTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index()
    {
        $all_product = Product::all();
        $types = ProductTypes::all();
        return view('auth/product/index', compact('all_product','types'));
    }


    public function create()
    {
        $productTypes = ProductTypes::all();
        return view('auth/product/create',compact('productTypes'));
    }


    public function store(Request $request)
    {
        //單張圖上傳
        $product_data = $request->all();
        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $path = $this->fileUpload($file, 'product');
            $product_data['img'] = $path;
        }

        Product::create($product_data);

        // 多張圖上傳

        // if($request->hasFile('product_url'))
        // {
        //     $files = $request->file('product_url');
        //     foreach ($files as $file) {
        //         //上傳圖片
        //         $path = $this->fileUpload($file,'product');

        //         //新增資料進DB
        //         $product_imgs = new productImgs;
        //         $product_imgs->product_id = $new_product->id;
        //         $product_imgs->product_url = $path;
        //         $product_imgs->save();
        //     }
        // }

        return redirect('/home/product');
    }

    public function edit($id)
    {
        // $product = product::where('id','=','$id')->first();
        $productTypes = ProductTypes::all();
        $product = Product::find($id);
        return view('auth/product/edit', compact('productTypes','product'));
    }

    public function update(Request $request, $id)
    {

        // $product = product::find($id);
        // $product->img = $request->img;
        // $product->title = $request->title;
        // $product->sort = $request->sort;
        // $product->text = $request->text;
        // $product->save();

        // product::find($id)->update($request->all());

        $item = Product::find($id);
        $requset_data = $request->all();
        if ($request->hasFile('img')) {

            //刪除舊圖
            $old_img = $item->img;
            File::delete(public_path() . $old_img);

            //上傳新圖
            $file = $request->file('img');
            $path = $this->fileUpload($file, 'product');
            $requset_data['img'] = $path;
        }

        $item->update($requset_data);
        return redirect('/home/product');
    }

    public function delete(Request $request, $id)
    {
        //單張刪除
        $item = Product::find($id);

        $old_image = $item->img;
        if(file_exists(public_path().$old_image)){
            File::delete(public_path().$old_image);
        }
        $item->delete();

        //多張刪除
        // $product_imgs = productImgs::where('product_id',$id)->get();

        // foreach($product_imgs as $product_img){

        //     $old_image = $product_img->product_url;

        //     if(file_exists(public_path().$old_image)){
        //     File::delete(public_path().$old_image);
        //     }

        //     $product_img->delete();
        // }
        return redirect('/home/product');
    }



    private function fileUpload($file, $dir)
    {
        //防呆：資料夾不存在時將會自動建立資料夾，避免錯誤
        if (!is_dir('upload/')) {
            mkdir('upload/');
        }
        //防呆：資料夾不存在時將會自動建立資料夾，避免錯誤
        if (!is_dir('upload/' . $dir)) {
            mkdir('upload/' . $dir);
        }
        //取得檔案的副檔名
        $extension = $file->getClientOriginalExtension();
        //檔案名稱會被重新命名
        $filename = strval(time() . md5(rand(100, 200))) . '.' . $extension;
        //移動到指定路徑
        move_uploaded_file($file, public_path() . '/upload/' . $dir . '/' . $filename);
        //回傳 資料庫儲存用的路徑格式
        return '/upload/' . $dir . '/' . $filename;
    }
}
