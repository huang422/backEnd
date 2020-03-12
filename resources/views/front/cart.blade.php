@extends('layouts/nav')

@section('css')

<style>
    .product-name {
        font-size: 40px;
        font-weight: 400;
        line-height: 48px;
    }

    .product-card .color {

        padding: 10px 20px;
        width: 160px;
        min-height: 58px;
        height: 100%;
        font-size: 16px;
        line-height: 20px;
        color: #757575;
        text-align: center;
        border: 1px solid #eee;
        background-color: #fff;
        -webkit-user-select: none;
        -ms-user-select: none;
        user-select: none;
        transition: opacity, border .2s linear;
        cursor: pointer;

    }

    .product-card .color.active {
        color: #424242;
        border-color: #ff6700;
        transition: opacity, border .2s linear;
    }
</style>

@endsection

@section('content')


<section class="features3 cid-rRF3umTBWU pt-5 mt-5" id="features3-7">


    <div class="container">
        <div class="row">
            <div class="col-6">

            </div>
            <div class="col-6">
                <div class="product-name mb-3">
                    <span> Redmi Note 8 Pro</span>
                </div>
                <div class="product-tip mb-3">
                    <span>6GB+64GB, 冰翡翠</span><br>
                    <span>NT$6,599</span>
                </div>
                <div class="product-capacity mb-3">
                    <div class="product-card">
                        <div class="row">
                            <div class="col-12">容量</div>
                            <div class="col-4">
                                <div class="color" data-capacity="6GB+64GB">6GB+64GB</div>
                            </div>
                            <div class="col-4">
                                <div class="color" data-capacity="6GB+128GB">6GB+128GB</div>
                            </div>


                        </div>
                    </div>
                </div>
                <div class="product-color mb-3">
                    <div class="product-card">
                        <div class="row">
                            <div class="col-12">顏色</div>
                            <div class="col-4">
                                <div class="color" data-color="紅">紅</div>
                            </div>
                            <div class="col-4">
                                <div class="color" data-color="黃">黃</div>
                            </div>
                            <div class="col-4">
                                <div class="color" data-color="綠">綠</div>
                            </div>
                            <div class="col-4">
                                <div class="color" data-color="藍">藍</div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="product-qty mb-3">
                    <div>數量</div>
                    <a id="minus" href=""> - </a>
                    <input type="number" value="1" id="qty" min="0">
                    <a id="plus" href=""> + </a>
                </div>
                <div class="product-tatal mb-3">
                    <span> Redmi Note 8 Pro</span>
                    <span>冰翡翠</span>
                    <span>6GB+64GB</span> * <span>1</span>
                    <span>NT$6,599</span>
                </div>
                <input type="text" name="capacity" id="capacity" value="">
                <input type="text" name="color" id="color" value="">
                <button>立即購買</button>

            </div>
        </div>
    </div>
</section>

@endsection

@section('js')

<script>
    $('.product-color .product-card .color').click(function () {

        $('*').removeClass('active');
        $(this).addClass('active');
        $('#color').attr('value',`${$(this).attr('data-color')}`);

    });

    $('.product-capacity .product-card .color').click(function () {

        $('*').removeClass('active');
        $(this).addClass('active');
        $('#capacity').attr('value',`${$(this).attr('data-capacity')}`);

    });

    $(function(){

        var valueElement = $('#qty');
        function incrementValue(e){
            
            //get now value
            var now_number = $('#qty').val();

            //add increment value
            var new_number = Math.max(e.data.increment + parseInt(now_number));
            $('#qty').val(new_number);

            return false;
        }

        $('#plus').bind('click', {increment: 1}, incrementValue);
        $('#minus').bind('click', {increment: -1}, incrementValue);
    });

</script>

@endsection
