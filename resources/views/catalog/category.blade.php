@extends('layout.site', ['title' => $category->name])

@section('content')
    <h1>{{ $category->name }}</h1>
    <p>{{ $category->content }}</p>
    <div class="row text-center">
        @foreach ($category->children as $child)
            @include('catalog.part.category', ['category' => $child])
        @endforeach
    </div>
    <div class="bg-light p-2 mb-2">
        <!-- Фильтр для товаров категории -->
        <form method="get"
              action="{{ route('catalog.category', ['category' => $category->slug]) }}">
            @include('catalog.part.filter')
            <a href="{{ route('catalog.category', ['category' => $category->slug]) }}"
               class="btn btn-outline-primary">Сбросить</a>
        </form>
    </div>
    <div class="row">
        @foreach ($products as $itm=>$product)
            @include('catalog.part.product', ['product' => $product,'itm'=>$itm])
        @endforeach
    </div>
    {{ $products->links() }}
@endsection
