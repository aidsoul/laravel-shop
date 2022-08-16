@extends('layout.site', ['title' => 'Страница не найдена'])

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mt-4 mb-4">
                <div class="card-header">
                    <h1>Запрошенная страница не найдена</h1>
                </div>
                <div class="card-body">
                    <img src="{{ asset('img/404.png') }}" alt="" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
@endsection
