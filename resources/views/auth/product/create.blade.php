@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote.min.css" rel="stylesheet">
@endsection

@section('content')


<form method="post" action="/home/product/store" enctype="multipart/form-data">
    @csrf
    <div class="container">

        <h1>新增產品</h1>

        <div class="form-group">
            <label for="types_id">產品類型</label>
            <select class="form-control" id="types_id" name="types_id">
                @foreach ($productTypes as $item)

                    <option value="{{$item->id}}">{{$item->title}}</option>

                @endforeach
            </select>
          </div>

         <div class="form-group">
            <label for="img">IMG</label>
            <input type="file" class="form-control" id="img" name="img" required>
          </div>

          {{-- <div class="form-group">
            <label for="news_url">多張IMG</label>
            <input type="file" class="form-control" id="news_url" name="news_url[]" multiple>
          </div> --}}

          <div class="form-group">
            <label for="title">產品名稱</label>
            <input type="text" class="form-control" id="title" name="title">
          </div>

          <div class="form-group">
            <label for="text">text</label>
            <input type="text" class="form-control" id="text" name="text">
          </div>

          <div class="form-group">
            <label for="sort">sort</label>
            <input type="text" class="form-control" id="sort" name="sort">
          </div>
          <div class="form-group">
            <label for="price">price</label>
            <input type="text" class="form-control" id="price" name="price">
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




@endsection


