@extends('layouts.default')

@section('content')
    <div class="container">
        <div class = "row justify-content-center">
            <div class = "col-lg-6 col-md-6 col-sm-5">
                <h2 class="mt-3">Мои счета</h2>
            </div>
            <div class = "col-lg-6 col-md-6 col-sm-7">
                <form method = "get" action = "">
                    <div class="input-group mt-3">
                        <input id = "search" type="text" class="form-control" name = "search" placeholder="Номер счета или наименование организации" value="{{request()->input('search')}}">
                        <span class="px-2">
        		           <button class="btn btn-secondary" type="submit">Найти</button>
      		            </span>
                    </div>
                </form>
            </div>
        </div>

        <div class="table-container">
            <table class = "table table-hover table-striped">
                <thead>
                <tr>
                    <th class = "text-center" width = 15%><strong>Дата</strong></th>
                    <th class = "text-center" width = 12%><strong>№ заказа</strong></th>
                    <th class = "text-center"><strong>Плательщик</strong></th>
                    <th class = "text-center" width = 20%><strong>Сумма</strong></th>
                    <th class = "text-center d-none d-md-table-cell" width = 30%><strong>Статус</strong></th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <td colspan="5">
                        <a href="{{ route('invoices.export') }}">Экспорт</a>
                        {{ $docs->appends(array('search' => request()->input('search')))->links() }}
                    </td>
                </tr>
                </tfoot>
                <tbody>
                    @foreach($docs as $doc)
                        @php $status = $doc->status(); @endphp
                        <tr class = "row-clicable" data-href="/invoices/{{$doc->id}}">
                            <td class = "text-center">{{ $doc->date_doc }}</td>
                            <td class = "text-center">{{ $doc->num_order }}</td>
                            <td>
                                <div>{{ $doc->kontr->fullname ?? "" }}</div>
                                <div class = "d-block d-md-none text-status-{{$status['id']}}"><small>{{$status['name']}}</small></div>
                            </td>
                            <td class = "text-center">{{ number_format($doc->sum(),2, ',', ' ') }}</td>
                            <td class = "text-center d-none d-md-table-cell text-status-{{$status['id']}}"><small>{{$status['name']}}</small></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection



