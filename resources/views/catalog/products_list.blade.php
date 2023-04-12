@extends('catalog.layout')
@section('title', 'Товары')

@section('content')
    <div class="row d-flex justify-center align-middle mt-4">
        @foreach($products as $product)
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
    </div>

    @if(1==0)
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
{{--        <div class="card-group">--}}
            @foreach($products as $product)
                <div class="col">
                    <div class="card mr-3" style="width: 18rem;">
                        <div class="d-flex justify-content-center" style="height: 200px">
                            <img src="{{$product->image}}" class="h-100 mw-100" alt="...">
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
{{--        </div>--}}
    </div>
    @endif
@endsection

