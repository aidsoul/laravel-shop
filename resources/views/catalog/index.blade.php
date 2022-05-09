@extends('layout.site', ['title' => 'Каталог товаров'])

@section('content')
    <h1 class="mb-4">Разделы каталога</h1>
    <div class="row text-center">
        @foreach ($roots as $root)
            @include('catalog.part.category', ['category' => $root])
        @endforeach
    </div>
    <h2 class="mb-4">Популярные бренды</h2>
    <div class="row text-center">
        @foreach ($brands as $brand)
            @include('catalog.part.brand', ['brand' => $brand])
        @endforeach
    </div>
@endsection



