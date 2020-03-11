@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote.min.css" rel="stylesheet">

<style>
    .product_img_card .btn-danger {
        position: absolute;
        right: -5px;
        top: -5px;
        border-radius: 50%;
    }
</style>
@endsection


@section('content')

<form method="post" action="/home/product/update/{{$product->id}}" enctype="multipart/form-data">
    @csrf
    <div class="container">

        <h1>修改產品</h1>

        <div class="form-group">
            <label for="types_id">產品類型</label>
            <select class="form-control" id="types_id" name="types_id">
                @foreach ($productTypes as $item)
                    @if ($item->id == $product->types_id)
                        <option value="{{$item->id}}" selected>
                            {{$item->title}}
                        </option>
                    @else
                        <option value="{{$item->id}}">
                            {{$item->title}}
                        </option>
                @endif

              @endforeach
            </select>
          </div>

        <div class="form-group">
            <label for="img">現有IMG</label>
            <img width="250" src="{{$product->img}}" alt="">
        </div>

        <div class="form-group">
            <label for="img">修改IMG</label>
            <input type="file" class="form-control" id="img" name="img" value="{{$product->img}}">
        </div>
        <hr>
        {{-- <div class="row">
            現有多張圖片組

            @foreach ($product->product_imgs as $item)

            <div class="col-2 ">
                <div class="product_img_card" data-productimgid="{{$item->id}}">
                    <button type="button" class="btn btn-danger" data-productimgid="{{$item->id}}">X</button>
                    <img class="img-fluid" src="{{$item->product_url}}" alt="">
                    <input class="form-control" type="text" value="{{$item->sort}}" onchange="ajax_post_sort(this,{{$item->id}})">
                </div>
            </div>

            @endforeach
        </div>

        <hr>

        <div class="form-group">
            <label for="product_url">新增多張圖片組</label>
            <input type="file" class="form-control" id="product_url" name="product_url[]" multiple>
        </div> --}}

        <div class="form-group">
            <label for="title">產品名稱</label>
            <input type="text" class="form-control" id="title" name="title" value="{{$product->title}}">
        </div>

        <div class="form-group">
            <label for="text">TEXT</label>
            <textarea class="form-control" name="text" id="text" cols="30" rows="10">{!!$product->text!!}</textarea>
        </div>

        <div class="form-group">
            <label for="sort">SORT</label>
            <input type="number" min="0" class="form-control" id="sort" name="sort" value="{{$product->sort}}">
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

<script>
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.product_img_card .btn-danger').click(function(){
        var productimgid = this.getAttribute('data-productimgid');

        $.ajax({
                  url: "/home/ajax_delete_product_imgs",
                  method: 'post',
                  data: {
                     productimgid:productimgid,
                  },
                  success: function(result){
                     $(`.product_img_card[data-productimgid=${productimgid}]`).remove();
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
<script>
    $(document).ready(function() {
        $('#text').summernote({
            minHeight: 300,
        });
    });
</script>



@endsection
