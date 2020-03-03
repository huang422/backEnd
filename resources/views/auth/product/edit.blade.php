@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
@endsection

@section('content')


<form method="post" action="/home/product/update/{{$product->id}}">
    @csrf
    <div class="container">

        <div class="form-group">
            <label for="img">IMG</label>
            <input type="text" class="form-control" id="img" name="img" value="{{$product->img}}">

          </div>
          <div class="form-group">
            <label for="title">TITLE</label>
            <input type="text" class="form-control" id="title" name="title" value="{{$product->title}}">

          </div>
          <div class="form-group">
            <label for="text">TEXT</label>
            <textarea class="form-control" name="text" id="text" cols="30" rows="10">{{$product->text}}</textarea>
          </div>

          <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>

@section('js')

<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
    $('#example').DataTable();
    } );
</script>

@endsection

@endsection
