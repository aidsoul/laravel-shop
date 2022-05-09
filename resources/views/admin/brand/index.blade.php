@extends('layout.admin', ['title' => 'Все бренды каталога'])

@section('content')
    <h1>Все бренды каталога</h1>
    @canany(['admin','commodity-expert'])
    <a href="{{ route('admin.brand.create') }}" class="btn btn-success mb-4">
        Создать бренд
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
        @foreach($brands as $brand)
            <tr>
                <td>
                @if ($brand->image)
                        @php($url = url('storage/catalog/brand/image/' . $brand->image))                        
                @else
                        @php($url = "https://via.placeholder.com/600x300")
                @endif
                <img src="{{ $url }}" alt="" class="img-fluid">
                </td>
                <td>
                    <a href="{{ route('admin.brand.show', ['brand' => $brand->id]) }}">
                        {{ $brand->name }}
                    </a>
                </td>
                <td>{{ iconv_substr($brand->content, 0, 150) }}</td>
                @canany(['admin','operator'])
                <td>
                    <a href="{{ route('admin.brand.edit', ['brand' => $brand->id]) }}">
                        <i class="far fa-edit"></i>
                    </a>
                </td>
                <td>
                    <form action="{{ route('admin.brand.destroy', ['brand' => $brand->id]) }}"
                        method="post" onsubmit="return confirm('Удалить этот бренд?')">
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
{{ $brands->links() }}
@endsection
