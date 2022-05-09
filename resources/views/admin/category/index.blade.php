@extends('layout.admin', ['title' => 'Все категории каталога'])

@section('content')
    <h1>Все категории</h1>
    @canany(['admin','commodity-expert'])
    <a href="{{ route('admin.category.create') }}" class="btn btn-success mb-4">
        Создать категорию
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
        @include('admin.category.part.tree', ['level' => -1, 'parent' => 0])
    </table>
    {{$items->links()}}
@endsection
