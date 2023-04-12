@extends('catalog.layout')
@section('title', 'Товары')

@section('content')
    <div class="row">

            @foreach($products as $product)
                <dev>
                    <h3>{{$product->name}} {{$product->price}} руб.</h3>
                    @isset($product->description)
                    <div>
                        {!!  $product->description !!}
                    </div>
                    @endisset
                </dev>
            @endforeach


    </div>
@endsection

