@extends('catalog.layout')
@section('title', 'Товары')

@section('content')
    <div class="row">
        <h2>Товары</h2>

        <div class="table-responsive col-md-6">
            <table class="table table-striped table-sm">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Наименование</th>
                    <th scope="col">Url</th>
                    <th scope="col">Порядок</th>
                    <th scope="col">Цена</th>
                    <th scope="col">Группа</th>
                    <th scope="col">Вкл.</th>
                    <th scope="col">#</th>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{$product->id}}</td>
                        <td>{{$product->name}}</td>
                        <td>{{$product->slug}}</td>
                        <td>{{$product->sort}}</td>
                        <td>{{$product->price}}</td>
                        <td>{{$product->group}}</td>
                        <td>{{$product->active}}</td>
                        <td><a href="{{route('products.edit', $product->id)}}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                     class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
                                </svg>
                            </a>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
            <a href="{{route('products.create')}}" class="btn btn-primary mb-3">Новый товар</a>
        </div>
    </div>
@endsection

