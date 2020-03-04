<?php

namespace App\Http\Controllers;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

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
        if($request->hasFile('img')){
            $file = $request->file('img');
            $path = $this->fileUpload($file, 'product');
            $product_data['img'] = $path;
        }

        Product::create($product_data);
        return redirect('/home/product');
    }

    public function edit($id){
        $product = Product::find($id);
        return view('auth/product/edit',compact('product'));
    }

    public function update(Request $request,$id){
        // $product = Product::find($id);
        // $product->img = $request->img;
        // $product->title = $request->title;
        // $product->sort = $request->sort;
        // $product->text = $request->text;
        // $product->save();

        $item = Product::find($id);
        $request_data = $request->all();
        if($request->hasFile('img')){

            //刪除舊圖
            $old_img = $item->img;
            File::delete(public_path() . $old_img);

            //上傳新圖
            $file = $request->file('img');
            $path = $this->fileUpload($file, 'product');
            $request_data['img'] = $path;
        }
        $item->update( $request_data);
        return redirect('/home/product');
    }

    public function delete(Request $request,$id){
        $item = Product::find($id);

        $old_image = $item->img;
        if(file_exists(public_path().$old_image)){
            File::delete(public_path().$old_image);
        }
        $item->delete();
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
