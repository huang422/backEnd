<?php

namespace App\Http\Controllers;
use App\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(){
        $all_news = News::all();
        return view('auth/news/index',compact('all_news'));
    }

    public function create(){
        return view('auth/news/create');
    }

    public function store(Request $request){
        $news_data = $request->all();
        News::create($news_data);
        return redirect('/home/news');

    }

    public function edit($id){

        // $news = News::where('id','=','$id')->first();

        $news = News::find($id);

        return view('auth/news/edit',compact('news'));
    }

    public function update(Request $request,$id){

        $news = News::find($id);
        $news->img = $request->img;
        $news->title = $request->title;
        $news->text = $request->text;
        $news->save();

        // News::find($id)->update($request->all());

        return redirect('/home/news');
    }

    public function delete(Request $request,$id){
        News::find($id)->delete();
        return redirect('/home/news');
    }
}
