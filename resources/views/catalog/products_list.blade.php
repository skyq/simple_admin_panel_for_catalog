@extends('catalog.layout')
@section('title', 'Товары')

@section('style')
    <style>
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
            margin-right: 12px;
            white-space: nowrap;
            font-size: 18px;
            line-height:24px;
        }
    </style>
@endsection

@section('navbar')
    <div class="container pt-3">
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
    <div class="row d-flex justify-center align-middle mt-4">
        @php
            $cur_group = 0;
        @endphp
        @foreach($list as $el)
            <h3 id="{{$el['group_slug']}}">{{$el['group_name']}}</h3>
            @foreach($el['products'] as $product)
            <div class="col-sm-3 ">
                <div class="card mb-3 w-100 overflow-hidden rounded">
                    <div class="d-flex justify-content-center" style="height: 320px">
                        <img src="{{env('ROOT')}}{{$product->image}}" class="h-100 mw-100" alt="...">
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

