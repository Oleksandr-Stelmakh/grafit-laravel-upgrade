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
    <link href="{{ asset('css/app.css?ver=1.0') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css?ver=1.0') }}" rel="stylesheet">
<!-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) -->
</head>

<body>
<!-- старый сласс navbar-inverse \ новый класс navbar-dark bg-dark -->
<nav class="navbar navbar-inverse">  
    <!-- Контейнер (определяет ширину Navbar) -->
    <div class="container">
        <!-- Заголовок -->
        <div class="navbar-header">
            <!-- Кнопка «Гамбургер» отображается только в мобильном виде (предназначена для открытия основного содержимого Navbar) -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-main">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <!-- Бренд или название сайта (отображается в левой части меню) -->
            <a class="navbar-brand" href="/">
                <img src="{{ asset('img/topnav_logo.png') }}" height="36" alt="Название бренда или сайта">
            </a>
            <!-- информация для мобильного экрана -->
            <p class="visible-xs navbar-text text-center" style="margin-left:0px; margin-right:0px">доставка: ~</p>
        </div>

        <!-- Основная часть меню (может содержать ссылки, формы и другие элементы) -->
        <div class="collapse navbar-collapse" id="navbar-main">

            <!-- Содержимое основной части -->
            <ul class="nav navbar-nav">
                <li><a href="/invoices">Мои Счета</a></li>
                <li><a href="/productions">Моя Продукция</a></li>
                <li><a href="/constructor">Конструктор цен</a></li>
            </ul>

            <!-- Блок, расположенный справа -->
            <ul class="nav navbar-nav navbar-right">
                <!-- информация для большого экрана -->
                <li><p class="navbar-text hidden-xs">доставка: ~</p></li>
                @if(Auth::check())
                    <li><a href="/home"><span class="glyphicon glyphicon-user"></span> {{Auth::user()->name}}</a></li>
                @else
                    <li><a href="/login">Войти</a></li>
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

    @include('flash::message')
</div>

@yield('content')
 <!-- <div id="app">@yield('content')</div> -->

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
<!-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) -->
<!-- <script src="{{ asset('js/app.js?ver=1.0') }}"></script> -->
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="{{ asset('js/script.js?ver=1.0') }}"></script>


<script>
   document.addEventListener('DOMContentLoaded', function () {
    if (window.$) {
        $('#flash-overlay-modal').modal();
    }
});
</script>

</body>
</html>
