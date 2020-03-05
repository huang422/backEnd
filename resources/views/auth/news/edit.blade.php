@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">

<style>


</style>


@endsection

@section('content')


<form method="post" action="/home/news/update/{{$news->id}}" enctype="multipart/form-data">
    @csrf
    <div class="container">

        <h1>修改最新消息</h1>

        <div class="form-group">
            <label for="img">現有IMG</label>
            <img width="250" src="{{$news->img}}" alt="">
        </div>

        <div class="form-group">
            <label for="img">修改IMG</label>
            <input type="file" class="form-control" id="img" name="img" value="{{$news->img}}">
        </div>
        <hr>
        <div class="row">
            現有多張圖片組

            @foreach ($news->news_imgs as $item)

            <div class="col-2">
                <div class="news_img_card">
                    <button type="button" class="btn btn-danger">X</button>
                    <img class="img-fluid" src="{{$item->news_url}}" alt="">
                    <input class="form-control" type="text" value="{{$item->sort}}">
                </div>
            </div>

            @endforeach
        </div>

        <hr>

        <div class="form-group">
            <label for="news_url">新增多張圖片組</label>
            <input type="file" class="form-control" id="news_url" name="news_url[]" multiple required >
        </div>

        <div class="form-group">
            <label for="title">TITLE</label>
            <input type="text" class="form-control" id="title" name="title" value="{{$news->title}}">
        </div>

        <div class="form-group">
            <label for="text">TEXT</label>
            <textarea class="form-control" name="text" id="text" cols="30" rows="10">{{$news->text}}</textarea>
        </div>

        <div class="form-group">
            <label for="sort">SORT</label>
            <input type="number" min="0" class="form-control" id="sort" name="sort" value="{{$news->sort}}">
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>

@endsection

@section('js')

<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
    $('#example').DataTable();
    } );
</script>

@endsection
