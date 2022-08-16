@extends('layout.site', ['title' => 'Заказ размещен'])

@section('content')
    <h1>Заказ размещен</h1>

    <p>Ваш заказ успешно размещен. Наш менеджер скоро свяжется с Вами для уточнения деталей.</p>

    <h2>Ваш заказ</h2>
    <table class="table table-bordered">
        <tr>
            <th>№</th>
            <th>Наименование</th>
            <th>Цена</th>
            <th>Кол-во</th>
            <th>Стоимость</th>
        </tr>
        @foreach($order->items as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>
                <a href="{{ route('catalog.product', ['product' => $item->product->slug]) }}">
                    {{$item->product->name}}
                    </a>
                </td>
            <td>{{number_format($item->price, 2, '.', '') }}р.</td>
            <td>{{$item->quantity }}</td>
            <td>{{number_format($item->cost, 2, '.', '') }}р.</td>
        </tr>
        @endforeach
        <tr>
            <th colspan="4" class="text-right">Итого</th>
            <th>{{ number_format($order->amount, 2, '.', '') }}р.</th>
        </tr>
    </table>

    <h2>Ваши данные</h2>
    <p>Имя: {{ $order->first_name }}</p>
    <p>Фамилия: {{$order->last_name }}</p>
    <p>Отчество: {{ $order->middle_name }}</p>
    <p>Адрес почты: <a href="mailto:{{ $order->email }}">{{ $order->email }}</a></p>
    <p>Номер телефона: {{ $order->phone }}</p>
    <p>Адрес доставки: {{ $order->address }}</p>
    @isset ($order->comment)
        <p>Комментарий: {{ $order->comment }}</p>
    @endisset
@endsection
