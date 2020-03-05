@extends('layouts/nav')

@section('content')


<section class="engine"><a href="https://mobirise.info/x">css templates</a></section><section class="features3 cid-rRF3umTBWU pt-5 mt-5" id="features3-7">


    <div class="container">
        <div class="media-container-row flex-wrap">



            {{-- {{$news_data}} --}}


            @foreach ($news_data->news_imgs as $item)

            <img src="{{$item->news_url}}" alt="">


            @endforeach


        </div>
    </div>
</section>

@endsection
