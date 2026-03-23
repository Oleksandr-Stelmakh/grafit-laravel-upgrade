@extends('layouts.default')

@section('content')
    <div id = "info-jumbotron" class="py-5 mb-4 bg-light" 
         style = "background: url({{ config('app.promo_background') }}) right no-repeat; background-size: cover">
        <div class = "container text-center" >
            <br/><br/>
            <h1>{!!  config('app.name') !!} <br/></h1>
            <br/>
            <br/>
            <br/>
            <p>{!!  config('app.promo_text') !!} </p>
            @if(!Auth::check())
                 <p class="">
                    <i>{!! config('app.demo_text') !!}</i>
                </p>
            @endif
            <br/><br/><br/><br/>
        </div>
    </div>

    <div class="container-fluid">
        <div class = "row">
            <div class="col-lg-4 offset-lg-4 col-md-4 offset-md-4 col-sm-6 offset-sm-3 col-10 offset-1">
                <h3>Напишите нам</h3>
                {!! Form::open(['route' => 'promo.sendMessage', 'class' => '']) !!}
                    {{ Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'Ваше имя', 'required']) }}
                    {{ Form::email('email', '', ['class' => 'form-control', 'placeholder' => 'E-mail', 'required']) }}
                    {{ Form::text('message', '', ['class' => 'form-control', 'placeholder' => 'Текст сообщения', 'required']) }}
                    {{ Form::submit('Отправить', ['class' => 'form-control btn btn-primary w-100']) }}
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <div class="py-5" style = "background: url({{config('app.info_background')}}) #e6e6e6 right top no-repeat">
        <div class = "container">
            <p class = "text-center">{!!  Config('app.info_text') !!}</p>
        </div>
    </div>
@endsection
