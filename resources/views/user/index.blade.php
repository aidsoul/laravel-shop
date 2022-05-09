@extends('layout.site', ['title' => 'Личный кабинет'])

@section('content')

<div class="card text-center">
  <div class="card-header">
    <ul class="nav d-flex justify-content-between card-header-pills">
      <li class="nav-item">
         <a href="{{ route('user.order.index') }}" class="btn btn-primary nav-link">Ваши заказы</a>
      </li>

      <li class="nav-item right float-right">
      <form action="{{ route('user.logout') }}" method="post">
        @csrf
        <button type="submit" class="nav-link btn btn-primary">Выйти</button>
        </form>
      </li>

    </ul>
  </div>
  <div class="card-body">
    <h4 class="card-title mb-5">Добро пожаловать, {{ auth()->user()->last_name }} {{ auth()->user()->first_name }} {{ auth()->user()->middle_name }}!</h4>

    @if($rout == true)
    <a class="nav-link" href="{{ route('admin.index') }}"><h5>Панель управления</h5></a>
    @endif
    <ul class="list-group">
    @if($amount > 0)
    @isset($orderCount)
    @if($orderCount > 1)
    <li class="list-group-item d-flex justify-content-between align-items-center"> 
        Вы совершили покупки на сумму
        <span class="badge badge-success badge-pill">{{$amount}}р.</span>
    </li>
    @else 
    <li class="list-group-item d-flex justify-content-between align-items-center">
        Вы совершили покупку на сумму  
        <span class="badge badge-success badge-pill">{{$amount}}р.</span>
    </li>
    @endif
    @endisset
    @if($discount > 0)
    <li class="list-group-item d-flex justify-content-between align-items-center">Ваша cкидка на все товары
        <span class="badge badge-danger badge-pill">{{$discount}}%</span>
    </li>
    @endif
    @endif
    @if($discount == 0)
    <li class="list-group-item d-flex justify-content-between align-items-center">Вы совершили
        <span class="badge badge-danger badge-pill">{{$amount}} покупок</span>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center">Ваша скидка
        <span class="badge badge-danger badge-pill">{{$discount}}%</span>
    </li>
  
    @endif
    <br>

    <table class="table table-striped  table-dark">
  <thead>
    <tr class="table-active">
      <th scope="col">Общая сумма покупок (рубли)</th>
      <th scope="col">Процент скидки (%)</th>
    </tr>
  </thead>
  <tbody>
    <tr class="">
      <th scope="row">1000</th>
      <td>1</td>
    </tr>
    <tr class="">
      <th scope="row">2500</th>
      <td>5</td>
    </tr>
    <tr class="">
      <th scope="row">5000</th>
      <td>10</td>
    </tr>
    <tr>
      <th scope="row">10000</th>
      <td>13</td>
    </tr>
    <tr>
      <th scope="row">15000</th>
      <td>15</td>
    </tr>
    <tr>
      <th scope="row">30000</th>
      <td>20</td>
    </tr>
  </tbody>
</table>
</ul>
</div>
</div>
</div>
@endsection
