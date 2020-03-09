<?php

namespace App\Http\Controllers;

use App\ProductTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductTypesController extends Controller
{
    public function index()
    {
        $all_productTypes = ProductTypes::all();
        return view('auth/productTypes/index', compact('all_productTypes'));
    }

    public function create()
    {
        return view('auth/productTypes/create');
    }


    public function store(Request $request)
    {
        $productTypes_data = $request->all();


        ProductTypes::create($productTypes_data);
        return redirect('/home/productTypes');
    }

    public function edit($id)
    {

        $productTypes = ProductTypes::find($id);
        return view('auth/productTypes/edit', compact('productTypes'));
    }

    public function update(Request $request, $id)
    {

        $productTypes = ProductTypes::find($id);
        $productTypes->title = $request->title;
        $productTypes->sort = $request->sort;
        $productTypes->save();

        ProductTypes::find($id)->update($request->all());


        return redirect('/home/productTypes');
    }

    public function delete(Request $request, $id)
    {
        $item = ProductTypes::find($id);
        $item->delete();
        return redirect('/home/productTypes');
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
