@extends('admin.catalog.layout')
@section('title', old('name', $name ?? 'Новая группа'))

@section('content')

    <div class="row">
        <h2>{{old('name', $name ?? 'Новая группа')}}</h2>
        <form class="col-md-6" method="POST" action="{{$action}}">
{{--            @if(!$is_new)--}}
{{--                @method('PUT')--}}
{{--            @endif--}}

            @error('update')
            <div class="alert alert-danger mt-1" role="alert">
                {{$errors->first('update')}}
            </div>
            @enderror

            @csrf
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="active"
                       name="active" {{(old('active', $active ?? 0)) ? 'checked' : ''}}>
                <label class="form-check-label" for="active">Показывать</label>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Наименование</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Наименование"
                       value="{{ old('name', $name ?? '') }}">
                @error('name')
                <div class="alert alert-danger mt-1" role="alert">
                    {{$errors->first('name')}}
                </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="slug" class="form-label">Slug</label>
                <input type="text" class="form-control" id="slug" name="slug" placeholder="Slug"
                       value="{{old('slug', $slug ?? '')}}">
                @error('slug')
                <div class="alert alert-danger mt-1" role="alert">
                    {{$errors->first('slug')}}
                </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="sort" class="form-label">Сортировка</label>
                <input type="number" class="form-control" id="sort" name="sort" placeholder="Сортировка"
                       value="{{old('sort', $sort ?? 0)}}">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary mb-3">Сохранить</button>
            </div>
        </form>
    </div>
    {{--    {{ dd(get_defined_vars()) }}--}}
@endsection
