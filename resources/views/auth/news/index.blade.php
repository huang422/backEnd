@extends('layouts/app')

@section('content')


<form method="post" action="/home/news/store">
    @csrf
    <div class="container">
        <div class="form-group">
            <label for="img">IMG</label>
            <input type="text" class="form-control" id="img" name="img">

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
