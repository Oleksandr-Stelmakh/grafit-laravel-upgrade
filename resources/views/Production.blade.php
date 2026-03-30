@extends('layouts.default')

@section('content')

    <?php $makets_items = $makets['items'] ?>
    <?php $wide_maket = $makets['wide'] ?>

    <h2 class="text-center production-caption">
        {{ $production->fullname }}
    </h2>

    <div class="container-fluid">
        <div class="row">
         {{--Параметры продукции--}}
         <div class="col-12 {{$wide_maket ? 'col-md-4' : 'col-md-5'}} {{count($makets_items)==0 ? 'offset-md-4' : ''}}">
             <div class="table-container">
                 <table class="table param-table">
                     <tbody>
                     <tr>
                         <td class="col-4"><b>Код формы:</b></td>
                         <td class="col-8">{{ $production->code_form }}</td>
                     </tr>
                     <tr>
                         <td><b>Тип продукции:</b></td>
                         <td>
                            @if($production->prodType->icon_class)
                                <i class="bi {{ $production->prodType->icon_class }}"></i>
                            @endif
                             {{ $production->prodType->name ?? ''}} 
                             {{ $production->format->name ?? '' }}
                         </td>
                     </tr>
                     <tr>
                         <td><b>Параметры:</b></td>
                         <td>{{ $production->params() }}</td>
                     </tr>
                     @if($production->num_form)
                         <tr>
                             <td><b>№ формы:</b></td>
                             <td>{{ $production->num_form }}</td>
                         </tr>
                     @endif
                     @if($production->num_standard)
                         <tr>
                             <td><b>ГОСТ:</b></td>
                             <td>{{ $production->num_standard }}</td>
                         </tr>
                     @endif
                     </tbody>
                 </table>
             </div>
         </div>

         {{--Карусель--}}
         @if(count($makets_items))
             <div class="col-12 {{$wide_maket ? 'col-md-8' : 'col-md-7'}}">

                 <!-- Превью-изображения макетов-->
                 <div class='carousel-buttons col-8 d-none d-sm-block'>
                     @foreach($makets_items as $maket)
                         <img src="{{ asset($maket) }}" alt="макет" class="slide-one" data-index="{{$loop->index}}" onclick="goToSlide({{$loop->index}})">
                     @endforeach
                 </div>

                 <!-- Блок с каруселью -->
                 <div class="col-12 col-sm-10 p-0">
                     <div id="MaketsCarousel" class="carousel slide" data-bs-interval="false" data-bs-wrap="false">
                         <!-- Слайды карусели -->
                         <div class="carousel-inner">
                             @foreach($makets_items as $maket)
                                 <!-- <div class="{{$loop->index==0 ? 'item active':'item'}}"> -->
                                     <div class="carousel-item {{$loop->first ? 'active' : ''}}">
                                     <img src="{{ asset($maket) }}" alt="Макет" class="img-maket d-block mx-auto" style="max-height: 60vh; width: auto">
                                 </div>
                             @endforeach
                         </div>

                     <!-- Кнопки управления -->
                     <div class='text-center carousel-buttons'>
                         @foreach($makets_items as $maket)
                             <button type="button"
                              class="btn btn-outline-secondary slide-one"
                              data-index="{{$loop->index}}"
                              onclick="goToSlide({{$loop->index}})">
                                  {{$loop->iteration}}
                             </button>
                         @endforeach
                     </div>
                 </div>

             </div>
             </div>
         @endif

         {{-- История --}}
         @if($docs_strs->count())
             <div class="col-12 {{$wide_maket ? 'col-md-4' : 'col-md-5'}} {{count($makets_items)==0 ? 'offset-md-4' : ''}}">

                 <div class="table-container">
                     <h3 class="text-center">История заказов продукции:</h3>
                     <table class="table production-history table-striped table-hover">
                         <thead>
                         <tr>
                             <th class='text-center' width=15%>Дата</th>
                             <th class='text-center' width=15%>№ заказа</th>
                             <th class='text-center'>Получатель</th>
                             <th class='text-center' width=20%>Кол-во</th>
                         </tr>
                         </thead>
                         <tfoot>
                         <tr>
                             <td colspan="4">{{ $docs_strs->links() }}
                         </tr>
                         </tfoot>
                         <tbody>
                         @foreach($docs_strs as $doc_str)
                             <tr class="row-clicable" data-href="/invoices/{{$doc_str->doc->id}}">
                                 <td class='text-center'>{{ $doc_str->doc->date_doc ?? ''}}</td>
                                 <td class='text-center'>{{ $doc_str->doc->num_order ?? ''}}</td>
                                 <td class="text-center">
                                     <div style='display: inline-block'>{{ $doc_str->doc->recipient->fullname ?? ''}}</div>
                                     <div>
                                         <small class="text-muted">
                                            @if($production->prodType->icon_class)
                                               <i class="bi {{ $production->prodType->icon_class }}"></i>
                                            @endif
                                             {{ $doc_str->params() }}
                                         </small>
                                     </div>
                                 </td>
                                 <td class='text-center'>{{ $doc_str->num }} шт</td>
                             </tr>
                         @endforeach
                         </tbody>
                     </table>

                 </div>

             </div>
         @endif
        </div>
    </div>

@endsection
