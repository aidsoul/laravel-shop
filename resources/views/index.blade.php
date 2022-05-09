@extends('layout.site')
@section('content')
    @if($new->count())
        <h2>Новинки</h2>
        <div class="row">
        @foreach($new as $itm=>$v)
                @include('catalog.part.product', ['product' => $v,'itm'=>$itm])
            @endforeach
        </div>
    @endif

    @if($hit->count())
        <h2>Лидеры продаж</h2>
        <div class="row">
            @foreach($hit as $itm=>$v)
                @include('catalog.part.product', ['product' => $v,'itm'=>$itm])
            @endforeach
        </div>
    @endif

    @if($sale->count())
        <h2>Распродажа</h2>
        <div class="row">
        @foreach($sale as $itm=>$v)
                @include('catalog.part.product', ['product' => $v,'itm'=>$itm])
            @endforeach
        </div>
    @endif
@endsection
