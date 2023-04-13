@extends('catalog.layout')
@section('title', 'Товары')

@section('style')
    <style>
        .bs {
            box-shadow: rgba(0, 0, 0, 0.1) 0px 2px 4px 0px;
            z-index: 2;
        }

        .breadcrumbs-wrapper {
            overflow: hidden;
        }

        .nw-breadcrumbs {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 20px;
            margin-bottom: -20px;
            height: 60px;
            overflow-x: scroll;
            -webkit-overflow-scrolling: touch;
        }

        .item {
            white-space: nowrap;
            font-size: 18px;
            line-height: 24px;

            margin: 4px;
            height: 32px;
            background: rgb(243, 243, 247);
            color: rgb(92, 99, 112);
            font-weight: 500;
            line-height: 38px;
            padding: 0px 16px;
            border-radius: 16px;
            flex: 0 0 auto;
            text-decoration: none;
        }
    </style>
@endsection

@section('navbar')
    <div class="container pt-3 pb-3 position-fixed bg-light bs">
        <div class="body">
            <div class="breadcrumbs-wrapper">
                <div class="nw-breadcrumbs">
                    @foreach($list as $el)
                        <div class="col">
                            <a href="#{{$el['group_slug']}}" class="item">{{$el['group_name']}}</a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <section class="container" style="padding-top: 100px; z-index: 1;">

        @foreach($list as $el)
            <h3 id="{{$el['group_slug']}}">{{$el['group_name']}}</h3>
            @foreach($el['products'] as $product)
                <div class="row">
                    <div class="col-12 pb-5 pt-4 pr-2 pl-2">
                        <div class="row">
                            <div class="col-12">
                                <img src="{{env('ROOT')}}{{$product->image}}" class="mw-100" alt=""
                                     style="object-fit: contain;">
                            </div>
                            <div class="col-12 pt-2">
                                <h4 class="card-title">{{$product->name}}</h4>
                                @isset($product->description)
                                    {!!  $product->description !!}
                                @endisset
                                @if($product->price == 0)
                                    <div class="fw-bold fs-2 mt-4 col-3 rounded-pill text-center"
                                         style="background-color: rgb(255, 240, 230);"
                                         onclick="create_order({{$product->id}})">
                                        ∞
                                    </div>
                                @else
                                    <div class="fw-bold fs-2 mt-4 col-3 rounded-pill text-center"
                                         style="background-color: rgb(255, 240, 230);"
                                         onclick="create_order({{$product->id}})">
                                        {{$product->price}} ₽
                                    </div>
                                @endif


                            </div>

                        </div>
                    </div>
                </div>
                <hr>
            @endforeach
        @endforeach
    </section>
    <script>
        async function create_order(id) {
            let data = {
                table: {{$table}},
                product_id: id
            };
            let response = await fetch('https://proxy.profpotok.ru/test/api/table_orders', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json;charset=utf-8'
                },
                body: JSON.stringify(data)
            })
        }
    </script>
@endsection

@section('content')
    <div class="row d-flex justify-center align-middle mt-4">
        @foreach($list as $el)
            <h3 id="{{$el['group_slug']}}">{{$el['group_name']}}</h3>
            @foreach($el['products'] as $product)
                <div class="col-sm-3 ">
                    <div class="card mb-3 w-100 overflow-hidden rounded">
                        <div class="d-flex justify-content-center" style="height: 320px">
                            <img src="{{env('ROOT')}}{{$product->image}}" class="h-100 mw-100" alt=""
                                 style="object-fit: contain;">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{$product->name}} {{$product->price}} руб.</h5>
                            @isset($product->description)
                                {!!  $product->description !!}
                            @endisset
                            <a href="#" class="btn btn-outline-secondary">Хочу</a>
                        </div>
                    </div>
                </div>
            @endforeach
        @endforeach
    </div>
@endsection

