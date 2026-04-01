@extends('layouts.default')

@section('content')

    <div class="container">
        <div class = "row">
            <div class = "col-lg-6 col-md-6 col-sm-5">
                <h2 class="mt-3">Моя продукція</h2>
            </div>
            <div class = "col-lg-6 col-md-6 col-sm-7">
                {!! Form::open(['route' => 'productions', 'method' => 'get']) !!}
                <div class="input-group mt-3">
                    <input type="text" class="form-control" name = "search" placeholder="Пошук: код форми, № форми або найменування" value="{{request()->input('search')}}">
                    <span class="px-2">
                        <button class="btn btn-secondary" type="submit">Знайти</button>
                    </span>
                </div>
                {!! Form::close() !!}
            </div>
        </div>

        <div class = "table-container">
            <table class = "table table-hover table-striped">
                <thead>
                <tr>
                    <th class = "text-center">Код форми</th>
                    <th class = "text-center">Найменування</th>
                    <th class = "text-center d-none d-md-table-cell">№ форми</th>
                    <th class = "text-center d-none d-md-table-cell">Параметри</th>
                </tr>
                </thead>
                <tfoot>
                    <tr>
                        <td colspan="4">{{ $productions->appends(array('search' => request()->input('search')))->links() }}
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($productions as $production)
                        <?php $params = $production->params() ?>
                        <tr class = "row-clicable" data-href="/productions/{{$production->id}}">
                            <td class = "text-center">{{$production->code_form}}</td>
                            <td>
                                <div>{{$production->fullname}}</div>
                                <!-- мобильная версия -->
                                <div class = "d-block d-md-none">
                                    <small class = "text-muted">
                                        @if($production->prodType->icon_class)
                                            <i class="bi {{ $production->prodType->icon_class }}"></i>
                                        @endif
                                        {{$production->num_form}}
                                        {!! $params !!}
                                    </small>
                                </div>
                            </td>
                            <!-- десктоп -->
                            <td class = "d-none d-md-table-cell text-center">
                                <small>
                                    {{$production->num_form}}
                                </small>
                            </td>
                            <td class = "text-center d-none d-md-table-cell">
                                <small class = "text-muted">
                                     @if($production->prodType->icon_class)
                                            <i class="bi {{ $production->prodType->icon_class }}"></i>
                                         @endif
                                    {!! $params !!}
                                </small>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

    </div>

@endsection