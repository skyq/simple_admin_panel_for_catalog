@extends('admin.catalog.layout')
@section('title', $name??'Новый товар')

@section('content')
    <div class="row">
        <h2>{{old('name', $name ?? 'Новый товар')}}</h2>
        <form class="col-md-6" method="POST" action="{{$action}}" enctype="multipart/form-data">
            {{--            @if(!$is_new)--}}
            {{--                @method('PUT')--}}
            {{--            @endif--}}

            @error('update')
            <div class="alert alert-danger mt-1" role="alert">
                {{$errors->first('update')}}
            </div>
            @enderror

            @csrf
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="active"
                                   name="active" {{(old('active', $active ?? 0)) ? 'checked' : ''}}>
                            <label class="form-check-label" for="active">Показывать</label>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Наименование:</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Наименование"
                                   value="{{ old('name', $name ?? '') }}">
                            @error('name')
                            <div class="alert alert-danger mt-1" role="alert">
                                {{$errors->first('name')}}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="slug" class="form-label">Имя для URL:</label>
                            <input type="text" class="form-control" id="slug" name="slug" placeholder="Slug"
                                   value="{{old('slug', $slug ?? '')}}">
                            @error('slug')
                            <div class="alert alert-danger mt-1" role="alert">
                                {{$errors->first('slug')}}
                            </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Группа:</label>
                            <select name="group" class="form-select" aria-label="Группы">
                                @foreach($groups as $el)
                                    <option
                                        value="{{$el->id}}" {{old('group', $group ?? 0) == (int)$el->id ? 'selected' : ''}}>{{$el->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Цена:</label>
                            <input type="number" step="any" class="form-control" id="slug" name="price"
                                   placeholder="Цена"
                                   value="{{old('price', $price ?? '')}}">
                            @error('price')
                            <div class="alert alert-danger mt-1" role="alert">
                                {{$errors->first('price')}}
                            </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="sort" class="form-label">Сортировка:</label>
                            <input type="number" class="form-control" id="sort" name="sort" placeholder="Сортировка"
                                   value="{{old('sort', $sort ?? 0)}}">
                        </div>


                        <div class="mb-3">
                            <label for="description" class="form-label">Описание:</label>
                            <textarea type="text" class="form-control" id="description" name="description"
                                      placeholder="Описание">{{old('description', $description ?? '')}}</textarea>
                            @error('description')
                            <div class="alert alert-danger mt-1" role="alert">
                                {{$errors->first('description')}}
                            </div>
                            @enderror
                        </div>

                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary mb-3">Сохранить</button>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        @if($is_new)
                            <img src="{{ $root ?? '' }}{{ old('image', '/images/noimage.jpg') }}" width="640px">
                        @else
                            <img src="{{ $root ?? '' }}{{ is_null(old('image', $image)) ? 'noimage.jpg':$image }}" width="640px">
                        @endif
                        <input type="file" name="image" class="form-control mt-3">
                    </div>
                </div>
            </div>

        </form>
    </div>
    {{--    {{ dd(get_defined_vars()) }}--}}
@endsection
