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

    public function store(Request $request)
    {
        $product_data = $request->all();


        Product::create($product_data);
        return redirect('/home/product');
    }

    public function edit($id)
    {

        $product = Product::find($id);
        return view('auth/product/edit', compact('product'));
    }

    public function update(Request $request, $id)
    {

        $productTypes = Product::find($id);
        $productTypes->title = $request->title;
        $productTypes->sort = $request->sort;
        $productTypes->save();

        Product::find($id)->update($request->all());


        return redirect('/home/product');
    }

    public function delete(Request $request, $id)
    {
        $item = Product::find($id);
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
