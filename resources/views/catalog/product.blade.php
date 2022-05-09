@extends('layout.site')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h1>{{ $product->name }}</h1>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 position-relative">

                        @php($images = $gallery->where('id','=',$product->id)->get())
                        @if(count($images) > 1)

                        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                        @foreach($images as $k=>$img)
                                @php($url = url('storage/catalog/product/gallery/image/'. $img->url))
                            @if($k == 0)
                                <div class="carousel-item active">
                            <div class="position-absolute">
                                @if($product->new)
                                    <span class="badge badge-info text-white ml-1">Новинка</span>
                                @endif
                                @if($product->hit)
                                    <span class="badge badge-danger ml-1">Лидер продаж</span>
                                @endif
                                @if($product->sale)
                                    <span class="badge badge-success ml-1">Распродажа</span>
                                @endif
                            </div>
                                <img class="img-fluid" src="{{$url}}">
                                </div>
                                @else 
                                        <div class="carousel-item">
                                        <div class="position-absolute">
                                    @if($product->new)
                                        <span class="badge badge-info text-white ml-1">Новинка</span>
                                    @endif
                                    @if($product->hit)
                                        <span class="badge badge-danger ml-1">Лидер продаж</span>
                                    @endif
                                    @if($product->sale)
                                        <span class="badge badge-success ml-1">Распродажа</span>
                                    @endif
                                </div>
                                        <img class="img-fluid" src="{{$url}}">
                                        </div>
                                @endif
                            @endforeach     
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                        </div>
                        @elseif(count($images) == 0)
                        @if ($product->image)
                            @php($url = url('storage/catalog/product/image/' . $product->image))
                        @else
                        @php($url = 'https://via.placeholder.com/600x300')
                        @endif
                        <div class="position-absolute">
                            @if($product->new)
                                <span class="badge badge-info text-white ml-1">Новинка</span>
                            @endif
                            @if($product->hit)
                                <span class="badge badge-danger ml-1">Лидер продаж</span>
                            @endif
                            @if($product->sale)
                                <span class="badge badge-success ml-1">Распродажа</span>
                            @endif
                        </div>
                        <img src="{{ $url }}" alt="" class="img-fluid">
                        
                        @endif
                    </div>
                    <div class="col-md-6">
                        @if($discount == 0)
                        <p class="h6">Цена: <b> {{ number_format($product->price, 2, '.', '') }}</b>р.</p>
                        @else
                        @isset($userAmount)
                        @if($userAmount->getDiscount() > 0)
                        <p><s class="h6">{{ number_format($product->price, 2, '.', '') }}</s>р.<sup class="text-danger h6">-{{$discount}}%</sup></p>
                        <p>Ваша цена: <span class="text-danger h5">{{number_format($userAmount->endPrice($product->price),2, '.', '')}}р.</span></p>
                        @endIf
                        @endisset
                        @endif

                        <!-- Форма для добавления товара в корзину -->
                        <form action="{{ route('basket.add', ['id' => $product->id]) }}"
                            method="post" class="form-inline add-to-basket">
                            @csrf
                            <label for="input-quantity">Количество</label>
                            <input type="text" name="quantity" id="input-quantity" value="1"
                                class="form-control mx-2 w-25">
                            <button type="submit" class="btn btn-success">
                                Добавить в корзину
                            </button>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <p class="mt-4 mb-0">{!!$product->content!!}</p>
                    </div>
                </div>
                
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="d-flex justify-content-between container-fluid">
                        <div class="p-2 ">
                        @isset($product->category)
                        Категория:
                        <a href="{{ route('catalog.category', ['category' => $product->category->slug]) }}">
                            {{ $product->category->name }}
                        </a>
                        @endisset
                        </div>
                        <div class="p-2 ">
                    <a href="{{ route('catalog.product.comment', ['product' => $product->slug]) }}">Комментарии ({{$comment->where('product_id','=',$product->id)->where('status','=',1)->count()}})</a>
                        </div>
                        <div class="p-2 ">
                        @isset($product->brand)
                        Бренд:
                        <a href="{{ route('catalog.brand', ['brand' => $product->brand->slug]) }}">
                            {{ $product->brand->name }}
                        </a>
                        @endisset
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

