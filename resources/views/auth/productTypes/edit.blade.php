@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote.min.css" rel="stylesheet">

<style>
    .news_img_card .btn-danger {
        position: absolute;
        right: -5px;
        top: -5px;
        border-radius: 50%;
    }
</style>
@endsection


@section('content')

<form method="post" action="/home/productTypes/update/{{$productTypes->id}}" enctype="multipart/form-data">
    @csrf
    <div class="container">

        {{-- <h1>修改產品類型</h1>

        <div class="form-group">
            <label for="title">現有IMG</label>
            <img width="250" src="{{$productTypes->img}}" alt="">
        </div>

        <div class="form-group">
            <label for="text">修改IMG</label>
            <input type="file" class="form-control" id="img" name="img" value="{{$productTypes->img}}">
        </div>

        <hr> --}}
        {{-- <div class="row">
            現有多張圖片組

            @foreach ($productTypes->news_imgs as $item)

            <div class="col-2 ">
                <div class="news_img_card" data-newsimgid="{{$item->id}}">
                    <button type="button" class="btn btn-danger" data-newsimgid="{{$item->id}}">X</button>
                    <img class="img-fluid" src="{{$item->news_url}}" alt="">
                    <input class="form-control" type="text" value="{{$item->sort}}" onchange="ajax_post_sort(this,{{$item->id}})">
                </div>
            </div>

            @endforeach
        </div> --}}

        <hr>

        {{-- <div class="form-group">
            <label for="news_url">新增多張圖片組</label>
            <input type="file" class="form-control" id="news_url" name="news_url[]" multiple>
        </div> --}}



        <div class="form-group">
            <label for="title">TITLE</label>
            <input type="text" class="form-control" id="title" name="title" value="{{$productTypes->title}}">
        </div>

        <div class="form-group">
            <label for="sort">SORT</label>
            <input type="number" min="0" class="form-control" id="sort" name="sort" value="{{$productTypes->sort}}">
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>

@endsection


@section('js')

<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote.min.js"></script>

<script>
    $(document).ready(function() {
    $('#example').DataTable();
    } );
</script>

{{-- <script>
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.news_img_card .btn-danger').click(function(){
        var newsimgid = this.getAttribute('data-newsimgid');

        $.ajax({
                  url: "/home/ajax_delete_news_imgs",
                  method: 'post',
                  data: {
                     newsimgid:newsimgid,
                  },
                  success: function(result){
                     $(`.news_img_card[data-newsimgid=${newsimgid}]`).remove();
                  }
               });
    });

    function ajax_post_sort(element,img_id){
        var img_id;
        var sort_value = element.value;

        $.ajax({
                  url: "/home/ajax_post_sort",
                  method: 'post',
                  data: {
                     img_id:img_id,
                     sort_value:sort_value,
                  },
                  success: function(result){

                  }
               });
    }

</script>


{{-- summernote --}}
{{-- <script>
    $(document).ready(function() {
        $('#text').summernote({
            minHeight: 300,
        });
    });
</script> --}}



@endsection
