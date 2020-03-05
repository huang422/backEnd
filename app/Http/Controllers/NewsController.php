<?php

namespace App\Http\Controllers;

use App\News;
use App\NewsImgs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class NewsController extends Controller
{
    public function index()
    {
        $all_news = News::all();
        return view('auth/news/index', compact('all_news'));
    }

    public function create()
    {
        return view('auth/news/create');
    }

    public function store(Request $request)
    {
        //單張圖上傳
        $news_data = $request->all();
        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $path = $this->fileUpload($file, 'news');
            $news_data['img'] = $path;
        }

        $news_news = News::create($news_data);

        // 多張圖上傳



        if($request->hasFile('news_url'))
        {
            $files = $request->file('news_url');
            foreach ($files as $file) {
                //上傳圖片
                $path = $this->fileUpload($file,'news');

                //新增資料進DB
                $news_imgs = new NewsImgs;
                $news_imgs->news_id = $news_news->id;
                $news_imgs->news_url = $path;
                $news_imgs->save();

            }
        }

        return redirect('/home/news');
    }

    public function edit($id)
    {

        // $news = News::where('id','=','$id')->first();

        $news = News::find($id);

        return view('auth/news/edit', compact('news'));
    }

    public function update(Request $request, $id)
    {

        // $news = News::find($id);
        // $news->img = $request->img;
        // $news->title = $request->title;
        // $news->sort = $request->sort;
        // $news->text = $request->text;
        // $news->save();

        // News::find($id)->update($request->all());

        $item = News::find($id);
        $requset_data = $request->all();
        if ($request->hasFile('img')) {

            //刪除舊圖
            $old_img = $item->img;
            File::delete(public_path() . $old_img);

            //上傳新圖
            $file = $request->file('img');
            $path = $this->fileUpload($file, 'news');
            $requset_data['img'] = $path;
        }

        $item->update($requset_data);
        return redirect('/home/news');
    }

    public function delete(Request $request, $id)
    {
        $item = News::find($id);

        $old_image = $item->img;
        if(file_exists(public_path().$old_image)){
            File::delete(public_path().$old_image);
        }
        $item->delete();
        return redirect('/home/news');
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


    public function ajax_delete_news_imgs(Request $request){
        $newsimgid = $request->newsimgid;

        $item = NewsImgs::find($newsimgid);
        $old_image = $item->news_url;

        if(file_exists(public_path().$old_image)){
            File::delete(public_path().$old_image);
        }
        $item->delete();


        return "delete success".$newsimgid;
    }
}
