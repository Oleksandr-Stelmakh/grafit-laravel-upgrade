<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-127727650-2"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-127727650-2');
    </script>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>


    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{asset('img/favicon.png')}}" type="image/x-icon"/>
    <link rel="shortcut icon" href="{{asset('img/favicon.png')}}" type="image/x-icon">

    <!-- Styles -->
    <!-- <link href="{{ asset('css/app.css?ver=1.0') }}" rel="stylesheet"> -->
    <!-- <link href="{{ asset('css/style.css?ver=1.0') }}" rel="stylesheet"> -->

</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark"> 
    <!-- Контейнер (определяет ширину Navbar) -->
    <div class="container">
        <!-- Заголовок -->
        
        <!-- Бренд или название сайта (отображается в левой части меню) -->
        <a class="navbar-brand d-flex align-items-center" href="/">
            <img src="{{ asset('img/topnav_logo.png') }}" height="36" alt="logo">
        </a>

            <!-- Кнопка «Гамбургер» отображается только в мобильном виде (предназначена для открытия основного содержимого Navbar) -->
            <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbar-main">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- информация для мобильного экрана -->
            <p class="d-block d-lg-none navbar-text text-center w-100">доставка: ~</p>
        

        <!-- Основная часть меню (может содержать ссылки, формы и другие элементы) -->
        <div class="collapse navbar-collapse" id="navbar-main">

            <!-- Содержимое основной части -->
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="/invoices">Мои Счета</a></li>
                <li class="nav-item"><a class="nav-link" href="/productions">Моя Продукция</a></li>
                <li class="nav-item"><a class="nav-link" href="/constructor">Конструктор цен</a></li>
            </ul>

            <!-- Блок, расположенный справа -->
            <ul class="navbar-nav ms-auto">
                <!-- информация для большого экрана -->
                <li><p class="navbar-text d-none d-lg-block">доставка: ~</p></li>
                @if(Auth::check())
                <li class="nav-item"><a class="nav-link" href="/home">{{Auth::user()->name}}</a></li>
                @else
                <li class="nav-item"><a class="nav-link" href="/login">Войти</a></li>
                @endif
            </ul>
        </div>
    </div>
</nav>

<!-- Всплывающие сообщения: laracast/flash + перехват 'status'-->
<div class="container-fluid container-alert">
    <?php if (session('status')) {
        flash()->overlay(session('status'), config('app.name'));
        session()->forget('status');
    } ?>

     @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif
</div>

 <div id="app">@yield('content')</div>

<div id="footer">
    <div class="container">
        <p class="text-center">
            <b>{{config('app.name')}} {{config('firm.birth_year')}} - {{date('Y')}}</b>
            <br/>{{config('firm.email')}}
            <br/>{{config('firm.phone1')}} {{config('firm.contact1')}}
            <br/>{{config('firm.phone2')}} {{config('firm.contact2')}}
            <br/>{{config('firm.address')}}
        </p>
    </div>
</div>

<!-- Scripts -->
@vite(['resources/sass/app.scss', 'resources/js/app.js'])

<!-- <script>
   document.addEventListener('DOMContentLoaded', function () {
    if (window.$) {
        $('#flash-overlay-modal').modal();
    }
});
</script> -->

</body>
</html>
