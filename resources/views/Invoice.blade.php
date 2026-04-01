@extends('layouts.default')

@section('content')
    <div class="container">
        <div class = "table-container">
            @php 
              $status = $doc->status(); 
            @endphp
            <h3 class= "text-center">Рахунок № {{$doc->num_doc}} от {{ $doc->date_doc }}
                <p><small>{{$status['name']}}</small></p>
            </h3>

            <table class = "caption-table">
                <tr>
                    <td class="col-3"><b>Постачальник:</b></td>
                    <td>{{ config('firm.name')}}</td>
                </tr>
                <tr>
                    <td><b>Платник:</b></td>
                    <td>{{ $doc->kontr->fullname ?? ""}}</td>
                </tr>
                <tr>
                    <td><b>Одержувач:</b></td>
                    <td>{{$doc->id_kontr==$doc->id_recipient ? "він же" : $doc->recipient->fullname ?? ""}}</td>
                </tr>
            </table>

            <table class = "table table-hover">
                <thead>
                <tr>
                    <th class = "text-center" style="width: 5%;">№ п/п</th>
                    <th class = "text-center col-1">Код форми</th>
                    <th class = "text-center">Продукція</th>
                    <th class = "text-center d-none d-md-table-cell" style="width: 15%;">Параметри</th>
                    <th class = "text-center" style="width: 15%;">Кількість</th>
                    <th class = "text-center d-none d-sm-table-cell col-1">Ціна</th>
                    <th class = "text-center" style="width: 19%;">Сума</th>
                </tr>
                </thead>
                <tbody>
                @foreach($doc_strs as $doc_str)
                    <?php $params = $doc_str->params()?>
                    <tr class = "row-clicable" data-href="/productions/{{$doc_str->id_tmc}}">
                        <td class = "text-center">{{$loop->iteration}}</td>
                        <td class = "text-center">{{$doc_str->tmc->code_form ?? ''}}</td>
                        <td class = "text-center">
                            <div>{{$doc_str->tmc->fullname ?? ''}}</div>
                            <div class = "d-md-none">
                                <small class = "text-muted">
                                    @if($doc_str->tmc->prodType->icon_class)
                                        <i class="bi {{ $doc_str->tmc->prodType->icon_class }}"></i>
                                    @endif
                                    {{ $doc_str->params() }}
                                </small>
                            </div>
                        </td>
                        <td class = "text-start d-none d-md-table-cell">
                            <small class = "text-muted">
                                @if($doc_str->tmc->prodType->icon_class)
                                    <i class="bi {{ $doc_str->tmc->prodType->icon_class }}"></i>
                                @endif
                                {{ $doc_str->params() }}                                
                            </small>
                        </td>
                        <td class = "text-center">
                            <div>{{$doc_str->num}} шт</div>
                            <div class = "text-muted d-md-none"><small>x {{number_format($doc_str->price, 3, ',', ' ')}}</small></div>
                        </td>
                        <td class = "text-center d-none d-md-table-cell">{{number_format($doc_str->price, 3, ',', ' ')}}</td>
                        <td class = "text-center">{{number_format($doc_str->sum, 2, ',', ' ')}}</td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <td></td>
                    <td></td>
                    <td class = "d-none d-md-table-cell"></td>
                    <td class = "d-none d-md-table-cell"></td>
                    <td class="text-end fw-bold" colspan="2">ВСЬОГО:</td>
                    <td class="text-center fw-bold">{{number_format($doc->sum(), 2, ',', ' ')}} грн</td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>

@endsection
