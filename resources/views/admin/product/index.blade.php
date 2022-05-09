@extends('layout.admin', ['title' => 'Все товары каталога'])

@section('content')
    <h1>Все товары</h1>
    <div class="d-flex flex-row flex-wrap mb-2">
    @foreach ($roots as $root)
    <div class="p-1 categoryitm">  
        <a href="{{ route('admin.product.category', ['category' => $root->id]) }}" class="btn btn-outline-info">
                {{ $root->name }}
            </a>
        </div>
    @endforeach
    </div>
   
    @canany(['admin','commodity-expert'])
    <a href="{{ route('admin.product.create') }}" class="btn btn-success mb-4">
        Создать товар
    </a>
    @endcanany
    <table class="table table-bordered">
        <tr>
            <th width="25%">Изображение</th>
            <th width="25%">Наименование</th>
            <th width="50%">Описание</th>
            @canany(['admin','operator'])
            <th><i class="fas fa-edit"></i></th>
            <th><i class="fas fa-trash-alt"></i></th>
            @endcanany
        </tr>
        @foreach ($products as $product)
        <tr>
            <td>
            @if ($product->image)
                        @php($url = url('storage/catalog/product/image/' . $product->image))                        
                @else
                        @php($url = "https://via.placeholder.com/600x300")
                @endif
                <img src="{{ $url }}" alt="" class="img-fluid">
            </td>
            <td>
                <a href="{{ route('admin.product.show', ['product' => $product->id]) }}">
                    {{ $product->name }}
                </a>
            </td>
            <td>{{ iconv_substr($product->content, 0, 150) }}</td>
            @canany(['admin','operator'])
            <td>
                <a href="{{ route('admin.product.edit', ['product' => $product->id]) }}">
                    <i class="far fa-edit"></i>
                </a>
            </td>
            <td>
                <form action="{{ route('admin.product.destroy', ['product' => $product->id]) }}"
                      method="post" onsubmit="return confirm('Удалить этот товар?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="m-0 p-0 border-0 bg-transparent">
                        <i class="far fa-trash-alt text-danger"></i>
                    </button>
                </form>
            </td>
            @endcanany
        </tr>
        @endforeach
    </table>
    {{ $products->links() }}
@endsection
