@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
@endsection

@section('content')


<form method="post" action="/home/product/store" enctype="multipart/form-data">
    @csrf
    <div class="container">

        <h1>新增產品</h1>

        <div class="form-group">
            <label for="img">IMG</label>
            <input type="file" class="form-control" id="img" name="img" required    >

          </div>
          <div class="form-group">
            <label for="title">TITLE</label>
            <input type="text" class="form-control" id="title" name="title">

          </div>
          <div class="form-group">
            <label for="text">TEXT</label>
            <input type="text" class="form-control" id="text" name="text" placeholder="text">
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


