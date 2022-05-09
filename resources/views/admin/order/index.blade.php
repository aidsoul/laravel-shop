@extends('layout.admin', ['title' => 'Все заказы'])

@section('content')
    <h1>Все заказы</h1>
    <table class="table table-bordered">
        <tr>
            <th>№</th>
            <th width="18%">Дата и время</th>
            <th width="5%">Статус</th>
            <th width="18%">Покупатель</th>
            <th width="18%">Адрес почты</th>
            <th width="18%">Номер телефона</th>
            <th width="18%">Пользователь</th>
            <th><i class="fas fa-eye"></i></th>
            <th><i class="fas fa-edit"></i></th>

        </tr>
        @foreach($orders as $order)
        @canany(['admin','operator'])
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                <td>
                    @if ($order->status == 0)
                        <span class="text-danger">{{ $statuses[$order->status] }}</span>
                    @elseif (in_array($order->status, [1,2,3]))
                        <span class="text-success">{{ $statuses[$order->status] }}</span>
                    @else
                        {{ $statuses[$order->status] }}
                    @endif
                </td>
                <td>{{ $order->last_name }} {{ $order->first_name }} {{ $order->middle_name }}</td>
                <td><a href="mailto:{{ $order->email }}">{{ $order->email }}</a></td>
                <td>{{ $order->phone }}</td>
                <td>
                    @isset($order->user)
                    <a href="{{ route('admin.user.edit', ['user' => $order->user->id]) }}">
                    {{ $order->user->last_name }} {{ $order->user->first_name }} {{ $order->user->middle_name }}
                    </a>
                    @endisset
                </td>
                <td>
                    <a href="{{ route('admin.order.show', ['order' => $order->id]) }}">
                        <i class="far fa-eye"></i>
                    </a>
                </td>
                <td>
                    <a href="{{ route('admin.order.edit', ['order' => $order->id]) }}">
                        <i class="far fa-edit"></i>
                    </a>
                </td>
            </tr>
            @endcanany 
        @can('driver')
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                <td>
                    @if ($order->status == 0)
                        <span class="text-danger">{{ $statuses[$order->status] }}</span>
                    @elseif (in_array($order->status, [1,2,3]))
                        <span class="text-success">{{ $statuses[$order->status] }}</span>
                    @else
                        {{ $statuses[$order->status] }}
                    @endif
                </td>
                <td>{{ $order->last_name }} {{ $order->first_name }} {{ $order->middle_name }}</td>
                <td><a href="mailto:{{ $order->email }}">{{ $order->email }}</a></td>
                <td>{{ $order->phone }}</td>
                <td>
                    @isset($order->user)
                    <a href="{{ route('admin.user.edit', ['user' => $order->user->id]) }}">
                    {{ $order->user->last_name }} {{ $order->user->first_name }} {{ $order->user->middle_name }}
                    </a>
                    @endisset
                </td>
                <td>
                    <a href="{{ route('admin.order.show', ['order' => $order->id]) }}">
                        <i class="far fa-eye"></i>
                    </a>
                </td>
                <td>
                    <a href="{{ route('admin.order.edit', ['order' => $order->id]) }}">
                        <i class="far fa-edit"></i>
                    </a>
                </td>
            </tr>
    @endcan
        @endforeach
    </table>
    {{ $orders->links() }}
@endsection
