<div class="col-md-4 mb-4" div-product>
    <div class="card list-item">
        <div class="card-header">
            <h3 class="mb-0">{{ $product->name }}</h3>
        </div>
        <div class="card-body p-0 position-relative" >
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
            @if ($product->image)
                @php($url = url('storage/catalog/product/thumb/' . $product->image))
                <img src="{{ $url }}" class="img-fluid" alt="">
            @else
                <img src="https://via.placeholder.com/300x150" class="img-fluid" alt="">
            @endif
            @if ($product->short_content)
                <div show-content  class="card-body show-hide">
                    <h6 class="mb-0" > {!!$product->short_content!!}</h6>
                </div>
            @else 
            <div show-content class="card-body show-hide">
                    <h6 class="mb-0" >Короткое описание к данному товару отсутствует!</h6><br>
                    <h6 class="mb-0" >Нажмите <a href="{{ route('catalog.product', ['product' => $product->slug]) }}"
            >"Смотреть"</a>, чтобы получить возможность просмотра полного описания</h6>
                </div>
            @endif  
        </div>
        <div class="card-footer">
            <!-- Форма для добавления товара в корзину -->
            <form action="{{ route('basket.add', ['id' => $product->id]) }}"
                method="post" class="d-inline add-to-basket">
                @csrf
                <button type="submit" class="btn btn-success">В корзину</button>
            </form>
            <a href="{{ route('catalog.product', ['product' => $product->slug]) }}"
            class="btn btn-dark float-right">Смотреть</a>
        </div>
    </div>
</div>
