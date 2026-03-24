@extends('layouts.default')

@section('content')
    <div class="container">

        <!-- <div class = "row">
            
            <h2 class = "text-center">On-line расчет цены</h2><br/>
        </div> -->

        <div class="row justify-content-center py-4">
            <div class="col-lg-7 offset-lg-1 col-md-8 offset-md-2 col-sm-9 offset-sm-1">
                <div class="card mt-3 mb-4">
                    <h2 class = "card-header text-center">On-line расчет цены</h2><br/>

                    <div class="card-body">
                     {!! Form::open() !!}

                     {{-- Тип продукции --}}
                     <div class="row mb-3" id="gr_prod_type">
                      {{ Form::label('prod_type', 'Тип продукции', ['class' => 'col-6 col-form-label']) }}
                         <div class="col-6">
                           {{ Form::select('prod_type', $prod_types, config('app.id_prod_type_form'), ['class' => 'form-select', 'required']) }}
                         </div>
                     </div>

                     {{-- Формат бланка --}}
                     <div class="row mb-3" id="gr_format_form" hidden>
                         {{ Form::label('format_form', 'Формат бланка', ['class' => 'col-6 control-label']) }}
                         <div class="col-6">
                             {{ Form::select('format_form', $format_forms, config('app.default_id_format_form'), ['class' => 'form-select']) }}
                         </div>
                     </div>

                     {{-- Формат журнала --}}
                     <div class="row mb-3" id="gr_format_journal" hidden>
                         {{ Form::label('format_journal', 'Формат журнала', ['class' => 'col-6 control-label']) }}
                         <div class="col-6">
                             {{ Form::select('format_journal', $format_journals, config('app.default_id_format_journal'), ['class' => 'form-select']) }}
                         </div>
                     </div>

                     {{-- Бумага --}}
                     <div class="row mb-3" id="gr_paper_type">
                         {{ Form::label('paper_type', 'Бумага', ['class' => 'col-6 control-label']) }}
                         <div class="col-6">
                             {{ Form::select('paper_type', $paper_types, config('app.default_id_paper_type'), ['class' => 'form-select']) }}
                         </div>
                     </div>

                     {{-- Количество листов --}}
                     <div class="row mb-3" id="gr_num_sheets" hidden>
                         {{ Form::label('num_sheets', 'Количество листов', ['class' => 'col-6 control-label']) }}
                         <div class="col-6">
                             {{ Form::text('num_sheets', config('app.default_num_sheets'), ['class' => 'form-control']) }}
                         </div>
                     </div>

                     {{-- Прошить --}}
                     <div class="row mb-3" id="gr_stitch">
                         {{ Form::label('stitch', 'Прошить', ['class' => 'col-6 col-form-label']) }}
                         <div class="col-6">
                             <div class="form-check">
                                 <input class="form-check-input" type="checkbox" id="stitch" name="stitch">
                             </div>
                         </div>
                     </div>

                     {{-- Нумерация --}}
                     <div class="row mb-3" id="gr_numering">
                         {{ Form::label('numering', 'Нумерация', ['class' => 'col-6 control-label']) }}
                         <div class="col-6">
                             <div class="form-check">
                                 <input class="form-check-input" type="checkbox" id="numering" name="numering">
                             </div>
                         </div>
                     </div>

                     {{-- Обложка --}}
                     <div class="row mb-3" id="gr_cover_type" hidden>
                         {{ Form::label('cover_type', 'Обложка', ['class' => 'col-6 control-label']) }}
                         <div class="col-6">
                             {{ Form::select('cover_type', $cover_types, config('app.default_id_cover_type'), ['class' => 'form-select']) }}
                         </div>
                     </div>

                     {{-- Количество страниц --}}
                     <div class="row mb-3" id="gr_num_pages" hidden>
                         {{ Form::label('num_pages', 'Количество страниц', ['class' => 'col-6 control-label']) }}
                         <div class="col-6">
                             {{ Form::text('num_pages', config('app.default_num_pages'), ['class' => 'form-control']) }}
                         </div>
                     </div>

                     {{-- Тираж --}}
                     <div class="row mb-3" id="gr_num">
                         {{ Form::label('num', 'Тираж', ['class' => 'col-6 control-label']) }}
                         <div class="col-6">
                             {{ Form::text('num', null, ['class' => 'form-control']) }}
                         </div>
                     </div>

                     {{-- Скидка и кнопка--}}
                     <div class="row mb-3 calcbtn-group" id="gr_discount">
                         {{ Form::label('discount', 'Ваша скидка', ['class' => 'col-md-4 col-3 control-label']) }}
                         <div class="col-md-2 col-3">
                             {{ Form::select('discount', $discounts, null, ['class' => 'form-select']) }}
                         </div>

                         <div class="col-6">
                             {{ Form::button('Рассчитать цену', ['class' => 'btn btn-primary w-100 btn-calcprice']) }}
                         </div>
                     </div>

                     {!! Form::close() !!}
                    </div>
                </div>
            </div>

            {{-- Результаты расчета --}}
            <div id="calc_waiting" class="mt-4 col-12 text-center text-muted" hidden="hidden">
                <small>обработка...</small>
            </div>

            <h3><div id="calc_error" class="col-12 text-center" hidden="hidden"></div></h3>

            <div id="calc_container" class="col-10 offset-lg-1 table-container" hidden>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th class = "text-center" width=40%>Наименование</th>
                        <th class = "text-center" width=15%>Кол-во, шт</th>
                        <th class = "text-center" width=15%>Цена без скидки</th>
                        <th class = "text-center" width=15%>Цена со скидкой</th>
                        <th class = "text-center" width=15%>Сумма</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <td colspan="4"></td>
                        <td></td>
                    </tr>
                    </tfoot>
                    <tbody>
                    <tr>
                        <td id="calc_name"></td>
                        <td id="calc_num" class="text-center"></td>
                        <td id="calc_full_price" class="text-center"></td>
                        <td id="calc_price" class="text-center"></td>
                        <td id="calc_sum" class="text-center"></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
