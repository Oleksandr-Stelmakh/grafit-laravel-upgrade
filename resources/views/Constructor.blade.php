@extends('layouts.default')

@section('content')
    <div class="container">
        <div class="row justify-content-center py-4">
            <div class="col-12 col-lg-7 col-md-8 col-sm-9 mx-auto">
                <div class="card mt-3 mb-4">
                    <h2 class = "card-header text-center">Он-лайн розрахунок ціни</h2>

                    <div class="card-body">
                     {!! Form::open() !!}

                     {{-- Тип продукции --}}
                     <div class="row mb-3" id="gr_prod_type">
                      {{ Form::label('prod_type', 'Тип продукції', ['class' => 'col-6 col-form-label']) }}
                         <div class="col-6">
                           {{ Form::select('prod_type', $prod_types, config('app.id_prod_type_form'), ['class' => 'form-select', 'required']) }}
                         </div>
                     </div>

                     {{-- Формат бланка --}}
                     <div class="row mb-3" id="gr_format_form" hidden>
                         {{ Form::label('format_form', 'Формат бланку', ['class' => 'col-6  col-form-label']) }}
                         <div class="col-6">
                             {{ Form::select('format_form', $format_forms, config('app.default_id_format_form'), ['class' => 'form-select']) }}
                         </div>
                     </div>

                     {{-- Формат журнала --}}
                     <div class="row mb-3" id="gr_format_journal" hidden>
                         {{ Form::label('format_journal', 'Формат журналу', ['class' => 'col-6  col-form-label']) }}
                         <div class="col-6">
                             {{ Form::select('format_journal', $format_journals, config('app.default_id_format_journal'), ['class' => 'form-select']) }}
                         </div>
                     </div>

                     {{-- Бумага --}}
                     <div class="row mb-3" id="gr_paper_type">
                         {{ Form::label('paper_type', 'Папір', ['class' => 'col-6  col-form-label']) }}
                         <div class="col-6">
                             {{ Form::select('paper_type', $paper_types, config('app.default_id_paper_type'), ['class' => 'form-select']) }}
                         </div>
                     </div>

                     {{-- Количество листов --}}
                     <div class="row mb-3" id="gr_num_sheets" hidden>
                         {{ Form::label('num_sheets', 'Кількість листів', ['class' => 'col-6  col-form-label']) }}
                         <div class="col-6">
                             {{ Form::text('num_sheets', config('app.default_num_sheets'), ['class' => 'form-control']) }}
                         </div>
                     </div>

                     {{-- Прошить --}}
                     <div class="row mb-3" id="gr_stitch">
                         {{ Form::label('stitch', 'Прошити', ['class' => 'col-6 col-form-label']) }}
                         <div class="col-6">
                             <div class="form-check">
                                 <input class="form-check-input" type="checkbox" id="stitch" name="stitch">
                             </div>
                         </div>
                     </div>

                     {{-- Нумерация --}}
                     <div class="row mb-3" id="gr_numering">
                         {{ Form::label('numering', 'Нумерація', ['class' => 'col-6  col-form-label']) }}
                         <div class="col-6">
                             <div class="form-check">
                                 <input class="form-check-input" type="checkbox" id="numering" name="numering">
                             </div>
                         </div>
                     </div>

                     {{-- Обложка --}}
                     <div class="row mb-3" id="gr_cover_type" hidden>
                         {{ Form::label('cover_type', 'Обкладка', ['class' => 'col-6  col-form-label']) }}
                         <div class="col-6">
                             {{ Form::select('cover_type', $cover_types, config('app.default_id_cover_type'), ['class' => 'form-select']) }}
                         </div>
                     </div>

                     {{-- Количество страниц --}}
                     <div class="row mb-3" id="gr_num_pages" hidden>
                         {{ Form::label('num_pages', 'Кількість сторінок', ['class' => 'col-6  col-form-label']) }}
                         <div class="col-6">
                             {{ Form::text('num_pages', config('app.default_num_pages'), ['class' => 'form-control']) }}
                         </div>
                     </div>

                     {{-- Тираж --}}
                     <div class="row mb-3" id="gr_num">
                         {{ Form::label('num', 'Тираж', ['class' => 'col-6  col-form-label']) }}
                         <div class="col-6">
                             {{ Form::text('num', null, ['class' => 'form-control']) }}
                         </div>
                     </div>

                     {{-- Скидка и кнопка--}}
                     <div class="row mb-3 calcbtn-group" id="gr_discount">
                         {{ Form::label('discount', 'Ваша знижка', ['class' => 'col-md-4 col-3  col-form-label']) }}
                         <div class="col-md-2 col-3">
                             {{ Form::select('discount', $discounts, null, ['class' => 'form-select']) }}
                         </div>

                         <div class="col-6">
                             {{ Form::button('Розрахувати ціну', ['class' => 'btn btn-secondary w-100 btn-calcprice']) }}
                         </div>
                     </div>

                     {!! Form::close() !!}
                    </div>
                </div>
            </div>

            {{-- Результаты расчета --}}
            <div id="calc_waiting" class="mt-4 col-12 text-center text-muted" hidden>
                <small>обробка...</small>
            </div>

            <h3><div id="calc_error" class="col-12 text-center" hidden></div></h3>

            <!-- <div id="calc_container" class="col-10 offset-lg-1 table-container" hidden> -->
             <div id="calc_container" class="col-12 col-lg-10 offset-lg-1 table-container table-responsive" hidden>   
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th class = "text-center">Найменування</th>
                        <th class = "text-center">Кількість, шт</th>
                        <th class = "text-center">Ціна без знижки</th>
                        <th class = "text-center">Ціна зі знижкою</th>
                        <th class = "text-center">Сума</th>
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
