@extends('layouts.app')

@section('content')

<div class="container py-5">

    {{-- Заголовок --}}
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h2>👋 Вітаємо!</h2>
            <p class="text-muted">Раді бачити вас у системі керування поліграфією</p>
        </div>
    </div>

    {{-- Быстрые действия --}}
    <div class="row g-4">

        {{-- Моя продукція --}}
        <div class="col-md-4">
            <div class="card h-100 shadow-sm text-center">
                <div class="card-body">
                    <h5 class="card-title">📦 Моя продукція</h5>
                    <p class="card-text text-muted">
                        Переглянути список ваших форм та замовлень
                    </p>
                    <a href="{{ route('productions') }}" class="btn btn-primary w-100">
                        Перейти
                    </a>
                </div>
            </div>
        </div>

        {{-- Розрахунок --}}
        <div class="col-md-4">
            <div class="card h-100 shadow-sm text-center">
                <div class="card-body">
                    <h5 class="card-title">🧮 Розрахунок ціни</h5>
                    <p class="card-text text-muted">
                        Онлайн-калькулятор вартості продукції
                    </p>
                    <a href="{{ route('prices') }}" class="btn btn-secondary w-100">
                        Розрахувати
                    </a>
                </div>
            </div>
        </div>

        {{-- Повідомлення --}}
        <div class="col-md-4">
            <div class="card h-100 shadow-sm text-center">
                <div class="card-body">
                    <h5 class="card-title">✉️ Написати нам</h5>
                    <p class="card-text text-muted">
                        Залиште повідомлення або запит
                    </p>
                    <a href="{{ route('promo') }}" class="btn btn-outline-primary w-100">
                        Відкрити форму
                    </a>
                </div>
            </div>
        </div>

    </div>

    {{-- Нижний блок --}}
    <div class="row mt-5">
        <div class="col-12 text-center text-muted">
            <small>
                💡 Використовуйте меню або швидкі дії для навігації по системі
            </small>
        </div>
    </div>

</div>

<!-- <div class="container">
    <div class="row">
        <div class="col-12 col-md-6 mx-auto">
            <div class="card">
                <div class="card-header">{{ __('Приладова панель') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('Ви увійшли в систему!') }}
                </div>
            </div>
        </div>
    </div>
</div> -->
@endsection
