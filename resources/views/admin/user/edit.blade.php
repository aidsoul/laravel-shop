@extends('layout.admin', ['title' => 'Редактирование пользователя'])

@section('content')
    <h1 class="mb-4">Редактирование пользователя</h1>
    <form method="post" action="{{ route('admin.user.update', ['user' => $user->id]) }}">
        @csrf
        @method('PUT')
        <div class="form-group">
        @php($admin = old('admin') ?? $user->admin ?? 0)
            <select name="admin" class="form-control" title="Роль">
            @foreach ($role as $key => $value)
                <option value="{{ $value }}" @if ($value == $admin) selected  @endif>
                    {{ $key }}
                </option>
            @endforeach
            </select>
        </div>
        <div class="form-group">
            <input type="text" fio class="form-control" name="first_name" placeholder="{{ __('first_name')}}"
                   required maxlength="255" value="{{ old('first_name') ?? $user->first_name ?? '' }}">
        </div>
        <div class="form-group">
            <input type="text" fio class="form-control" name="last_name" placeholder="{{ __('last_name')}}"
                   required maxlength="255" value="{{ old('last_name') ?? $user->last_name ?? '' }}">
        </div>
        <div class="form-group">
            <input type="text" fio class="form-control" name="middle_name" placeholder="{{ __('middle_name')}}"
                   required maxlength="255" value="{{ old('middle_name') ?? $user->middle_name ?? '' }}">
        </div>
        <div class="form-group">
            <input type="email" tag-remove class="form-control" name="email" placeholder="Адрес почты"
                   required maxlength="255" value="{{ old('email') ?? $user->email ?? '' }}">
        </div>
        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" name="change_password"
                   id="change_password">
            <label class="form-check-label" for="change_password">
                Изменить пароль пользователя
            </label>
        </div>
        <div class="form-group">
            <input type="text" tag-remove class="form-control" name="password" maxlength="255"
                   placeholder="Новый пароль" value="">
        </div>
        <div class="form-group">
            <input type="text" tag-remove class="form-control" name="password_confirmation" maxlength="255"
                   placeholder="Пароль еще раз" value="">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-success">Сохранить</button>
        </div>
    </form>
<script src="{{ asset('js/validation/fio.js') }}"></script>
<script src="{{ asset('js/validation/tag.js') }}"></script>
@endsection
