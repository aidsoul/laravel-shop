@extends('layout.admin', ['title' => 'Редактирование заказа'])

@section('content')
    <h1 class="mb-4">Редактирование заказа</h1>
    <form method="post" action="{{ route('admin.order.update', ['order' => $order->id]) }}">
        @csrf
        @method('PUT')
        @canany(['admin','operator'])
        <div class="form-group">
            @php($status = old('status') ?? $order->status ?? 0)
            <select name="status" class="form-control" title="Статус заказа">
            @foreach ($statuses as $key => $value)
                <option value="{{ $key }}" @if ($key == $status) selected @endif>
                    {{ $value }}
                </option>
            @endforeach
            </select>
        </div>
        @endcanany
        @can('driver')
        <div class="form-group">
            @php($status = old('status') ?? $order->status ?? 0)
            <select name="status" class="form-control" title="Статус заказа">
            @foreach ($statuses as $key => $value)
            @if($key == 0 or $key == 1)
            @continue
            @endif
                <option value="{{ $key }}" @if ($key == $status) selected @endif>
                    {{ $value }}
                </option>
            @endforeach
            </select>
        </div>
        @endcan
        @canany(['admin','operator'])
        <div class="form-group">
            <input type="text" fio class="form-control" name="first_name" placeholder="{{ __('first_name') }}"
                   required maxlength="255" value="{{ old('name') ?? $order->first_name ?? '' }}">
        </div>
        <div class="form-group">
            <input type="text" fio class="form-control" name="last_name" placeholder="{{ __('last_name') }}"
                   required maxlength="255" value="{{ old('name') ?? $order->last_name ?? '' }}">
        </div>
        <div class="form-group">
            <input type="text" fio class="form-control" name="middle_name" placeholder="{{ __('middle_name') }}"
                   required maxlength="255" value="{{ old('name') ?? $order->middle_name ?? '' }}">
        </div>
        <div class="form-group">
            <input type="email" class="form-control" name="email" placeholder="Адрес почты"
                   required maxlength="255" value="{{ old('email') ?? $order->email ?? '' }}">
        </div>
        <div class="form-group">
            <input type="text" data-tel class="form-control" name="phone" placeholder="Номер телефона"
                   required maxlength="18" value="{{ old('phone') ?? $order->phone ?? '' }}">
        </div>
        <div class="form-group">
            <input type="text" tag-remove class="form-control" name="address" placeholder="Адрес доставки"
                   required maxlength="255" value="{{ old('address') ?? $order->address ?? '' }}">
        </div>
        <div class="form-group">
            <textarea tag-remove class="form-control" name="comment" placeholder="Комментарий"
                      maxlength="500" rows="2">{{ old('comment') ?? $order->comment ?? '' }}</textarea>
        </div>
        @endcanany
        @can('driver')
        <div class="form-group">
            <input type="text" hidden fio class="form-control" name="first_name" placeholder="{{ __('first_name') }}"
                   required maxlength="255" value="{{ old('name') ?? $order->first_name ?? '' }}">
        </div>
        <div class="form-group">
            <input type="text" hidden fio class="form-control" name="last_name" placeholder="{{ __('last_name') }}"
                   required maxlength="255" value="{{ old('name') ?? $order->last_name ?? '' }}">
        </div>
        <div class="form-group">
            <input type="text" hidden fio class="form-control" name="middle_name" placeholder="{{ __('middle_name') }}"
                   required maxlength="255" value="{{ old('name') ?? $order->middle_name ?? '' }}">
        </div>
        <div class="form-group">
            <input type="email" hidden class="form-control" name="email" placeholder="Адрес почты"
                   required maxlength="255" value="{{ old('email') ?? $order->email ?? '' }}">
        </div>
        <div class="form-group">
            <input type="text" hidden data-tel class="form-control" name="phone" placeholder="Номер телефона"
                   required maxlength="18" value="{{ old('phone') ?? $order->phone ?? '' }}">
        </div>
        <div class="form-group">
            <input type="text" hidden tag-remove class="form-control" name="address" placeholder="Адрес доставки"
                   required maxlength="255" value="{{ old('address') ?? $order->address ?? '' }}">
        </div>
        <div class="form-group">
            <textarea tag-remove hidden class="form-control" name="comment" placeholder="Комментарий"
                      maxlength="500" rows="2">{{ old('comment') ?? $order->comment ?? '' }}</textarea>
        </div>
        @endcan
        <div class="form-group">
            <button type="submit" class="btn btn-success">Сохранить</button>
        </div>
    
    </form>
    <script src="{{ asset('js/validation/fio.js') }}"></script>
<script src="{{ asset('js/mask/phone.js') }}"></script>
<script src="{{ asset('js/validation/tag.js') }}"></script>
@endsection
