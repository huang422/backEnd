@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
@endsection

@section('content')


{{-- <form method="post" action="/home/news/store">
    @csrf --}}
<div class="container">
    <a href="/home/product/create" class="btn btn-success">新增產品</a>
    <hr>

    <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>

                <th>產品類型</th>
                <th>img</th>
                <th>title</th>
                <th>text</th>
                <th>sort</th>
                <th>price</th>
                <th width="130">功能</th>
            </tr>
        </thead>
        <tbody>





            @foreach ($all_product as $item)

            <tr>

                <td>{{$item->product_types->title}}</td>
                <td><img width="200" src="{{$item->img}}" alt=""></td>
                <td>{{$item->title}}</td>
                <td>{{$item->text}}</td>
                <td>{{$item->sort}}</td>
                <td>{{$item->price}}</td>

                <td>
                    <a href="/home/product/edit/{{$item->id}}" class="btn btn-success btn-sm">修改</a>
                    <button class="btn btn-danger btn-sm" onclick="show_confirm({{$item->id}})">刪除</button>
                    <form id="delete-form-{{$item->id}}" action="/home/product/delete/{{$item->id}}" method="POST"
                        style="display: none;">
                        @csrf
                    </form>
                </td>
            </tr>

            @endforeach


        </tbody>
    </table>

</div>
</form>

@endsection

@section('js')

<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
    $('#example').DataTable({"order": [[ 3, 'desc' ] ]} );
    } );

    function show_confirm(id){

        var r = confirm("確認刪除?")
        if (r==true){

            // document.getElementById('delete-form-'+id).submit();
            // document.getElementById(`delete-form-${id}`).submit();
            document.querySelector(`#delete-form-${id}`).submit();
        }
    }

</script>

@endsection
