@extends('layout.admin')
@section('content')
<div class="card border-primary mb-3" style="max-width: 100%;">
  <div class="card-body text-secondary">
    @can('admin')
    <h5 class="card-title">Добро пожаловать, {{ auth()->user()->last_name }} {{ auth()->user()->first_name }} {{ auth()->user()->middle_name }}</h5>
    <div class="alert alert-info text-center" role="alert" style="max-width: 20%;">
    <b>Администратор</b>
    </div>
    @endcan
    @can('commodity-expert')
    <h5 class="card-title">Добро пожаловать, {{ auth()->user()->last_name }} {{ auth()->user()->first_name }} {{ auth()->user()->middle_name }}</h5>
    <div class="alert alert-info text-center" role="alert" style="max-width: 15%;">
    <b>Товаровед</b>
    </div>
    @endcan
    @can('operator')
    <h5 class="card-title">Добро пожаловать, {{ auth()->user()->last_name }} {{ auth()->user()->first_name }} {{ auth()->user()->middle_name }}</h5>
    <div class="alert alert-info text-center" role="alert" style="max-width: 15%;">
    <b>Оператор</b>
    </div>
    @endcan
    @can('driver')
    <h5 class="card-title">Добро пожаловать, {{ auth()->user()->last_name }} {{ auth()->user()->first_name }} {{ auth()->user()->middle_name }}</h5>
    <div class="alert alert-info text-center" role="alert" style="max-width: 15%;">
    <b>Водитель</b>
    </div>
    @endcan
    </div>
</div>
@endsection
