@extends('layout.admin', ['title' => 'Товары категории'])

@section('content')
    <h1>{{ $category->name }}</h1>
    <div class="d-flex flex-row flex-wrap mb-2">
    @foreach ($category->children as $child)
    <div class="p-1 categoryitm">  
        <a href="{{ route('admin.product.category', ['category' => $child->id]) }}" class="btn btn-outline-info">
                {{ $child->name }}
            </a>
        </div>
    @endforeach
    </div>
    <a href="{{ route('admin.product.create') }}" class="btn btn-success mb-4">
        Создать товар
    </a>
    @if (count($products))
        <table class="table table-bordered">
            <tr>
                <th width="30%">Наименование</th>
                <th width="65%">Описание</th>
                @canany(['admin','operator'])
                <th><i class="fas fa-edit"></i></th>
                <th><i class="fas fa-trash-alt"></i></th>
                @endcanany
            </tr>
            @foreach ($products as $product)
            <tr>
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
                          method="post">
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
    @else
        <p>Нет товаров в этой категории</p>
    @endif
@endsection
