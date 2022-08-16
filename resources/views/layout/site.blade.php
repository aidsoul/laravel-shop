<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Интернет-магазин "Реальность"' }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
          integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p"
          crossorigin="anonymous"/>
        <link rel="stylesheet" href="{{ asset('css/site.css') }}">
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/site.js') }}"></script>
</head>
<body>
<div class="container">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="background: #e3f2fd;">
        <!-- Бренд и кнопка «Гамбургер» -->
        <a class="navbar-brand" href="{{ route('index') }}">Реальность</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse"
                data-target="#navbar-example" aria-controls="navbar-example"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Основная часть меню (может содержать ссылки, формы и прочее) -->
        <div class="collapse navbar-collapse" id="navbar-example">
            <!-- Этот блок расположен слева -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('catalog.index') }}">Каталог</a>
                </li>
            </ul>

        <!-- Этот блок расположен посередине -->
        <form action="{{ route('catalog.search') }}" class="form-inline my-2 my-lg-0">
                        <input class="form-control mr-sm-2" type="search" name="query"
                            placeholder="Поиск по каталогу" aria-label="Search">
                        <button class="btn btn-outline-light my-2 my-sm-0"
                                type="submit">Поиск</button>
                    </form>

            <!-- Этот блок расположен справа -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item" id="top-basket">
                    <a class="nav-link @if ($positions) text-success @endif"
                       href="{{ route('basket.index') }}">
                        Корзина
                        @if ($positions) ({{ $positions }}) @endif
                    </a>
                </li>
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.login') }}">Войти</a>
                    </li>
                    @if (Route::has('user.register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.register') }}">Регистрация</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.index') }}">Личный кабинет</a>
                    </li>
                @endif
            </ul>
        </div>
    </nav>
<div class="card card-border-none">
<div class="card-body mb-1">
  <div class="row">
        <div class="col-md-3">
            <div class="d-flex flex-column">
                <div class="mb-5">  @include('layout.part.roots')</div>
                <div class= "mb-5">   @include('layout.part.brands')</div>
                <!-- <div class="">
            <img src="https://via.placeholder.com/250x500" class="rounded mx-auto d-block" alt="...">
            </div> -->
            </div>
            <br>
        </div>
        <div class="col-md-9">
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible mt-0" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Закрыть">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{ $message }}
                </div>
            @endif
            @if ($message = Session::get('warning'))
                <div class="alert alert-warning alert-dismissible mt-0" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Закрыть">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{ $message }}
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible mt-4" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Закрыть">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </div>
  </div>
  <div class="card-footer text-muted footer-new">
      <div class="d-flex justify-content-between">
    <div class="footer-item">
      <div class="d-flex flex-column bd-highlight mb-3">
          <div class="r">
            2022 © <b>Реальность</b>
          </div>
            <div class="r">
            Интернет-магазин цифровой техники.
            </div>
            <div class="r">
            Все права защищены.
            </div>
      </div>
    </div>
    <div class="footer-item ">
    <div class="footer-item-social-network">
        <div class="footer-item-social-network-vk">
        <a href="https://vk.com/">
        <svg xmlns="http://www.w3.org/2000/svg" 
        class="footer-item-social-network-vk-img"
        fill="#237dfc" viewBox="0 0 20 20">
        <path d="M17.802 12.298s1.617 1.597 2.017 2.336a.127.127 0 0 1 .018.035c.163.273.203.487.123.645-.135.261-.592.392-.747.403h-2.858c-.199 0-.613-.052-1.117-.4-.385-.269-.768-.712-1.139-1.145-.554-.643-1.033-1.201-1.518-1.201a.548.548 0 0 0-.18.03c-.367.116-.833.639-.833 2.032 0 .436-.344.684-.585.684H9.674c-.446 0-2.768-.156-4.827-2.327C2.324 10.732.058 5.4.036 5.353c-.141-.345.155-.533.475-.533h2.886c.387 0 .513.234.601.444.102.241.48 1.205 1.1 2.288 1.004 1.762 1.621 2.479 2.114 2.479a.527.527 0 0 0 .264-.07c.644-.354.524-2.654.494-3.128 0-.092-.001-1.027-.331-1.479-.236-.324-.638-.45-.881-.496.065-.094.203-.238.38-.323.441-.22 1.238-.252 2.029-.252h.439c.858.012 1.08.067 1.392.146.628.15.64.557.585 1.943-.016.396-.033.842-.033 1.367 0 .112-.005.237-.005.364-.019.711-.044 1.512.458 1.841a.41.41 0 0 0 .217.062c.174 0 .695 0 2.108-2.425.62-1.071 1.1-2.334 1.133-2.429.028-.053.112-.202.214-.262a.479.479 0 0 1 .236-.056h3.395c.37 0 .621.056.67.196.082.227-.016.92-1.566 3.016-.261.349-.49.651-.691.915-1.405 1.844-1.405 1.937.083 3.337z"/>
        </svg>
        </a>
        </div>
    </div>

</div>

      </div>

  </div>
</div>

</div>
</body>
</html>
