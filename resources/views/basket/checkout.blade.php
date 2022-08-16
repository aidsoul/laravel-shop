@extends('layout.site', ['title' => 'Оформить заказ'])

@section('content')
    <h1 class="mb-4">Оформить заказ</h1>
    <form method="post" action="{{ route('basket.saveorder') }}" id="checkout">
        @csrf
        <div class="form-group">
    <input type="text" fio class="form-control" name="first_name" placeholder={{ __('first_name') }}
           required maxlength="255" value="{{ old('first_name') ?? $profile->first_name ?? '' }}">
</div>
<div class="form-group">
    <input type="text" fio class="form-control" name="last_name" placeholder={{ __('last_name') }}
           required maxlength="255" value="{{ old('last_name') ?? $profile->last_name ?? '' }}">
</div>
<div class="form-group">
    <input type="text" fio class="form-control" name="middle_name" placeholder={{ __('middle_name') }}
           required maxlength="255" value="{{ old('middle_name') ?? $profile->middle_name ?? '' }}">
</div>
<div class="form-group">
    <input type="email" tag-remove class="form-control" name="email" placeholder="Ваш email"
           required maxlength="255" value="{{ old('email') ?? $profile->email ?? '' }}">
</div>
<div class="form-group">
    <input type="text" data-tel class="form-control" name="phone" placeholder="Номер телефона"
           required maxlength="18" value="">
</div>
<div class="form-group">
    <input type="text" class="form-control" tag-remove name="address" placeholder="Адрес доставки"
           required maxlength="255" value="{{ old('address') ?? $profile->address ?? '' }}">
</div>
        <div class="form-group">
        <textarea class="form-control" tag-remove name="comment" placeholder={{ __('comment') }}
                    maxlength="500" rows="2">{{ old('comment') ?? $profile->comment ?? '' }}</textarea>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-success">Оформить</button>
        </div>
    </form>
<script src="{{ asset('js/validation/fio.js') }}"></script>
<script src="{{ asset('js/mask/phone.js') }}"></script>
<script src="{{ asset('js/validation/tag.js') }}"></script>
@endsection
