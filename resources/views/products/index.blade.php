@extends('adminlte::page')

@section('title', 'Pimentech - Produtos')

@section('content_header')
<h1 class="m-0 text-dark"></h1>
<div class="row">
    <div class="col-12 d-flex justify-content-between top-internal-head">
        <div class="d-flex align-items-center">
            <h1 class="m-0 text-dark ml-2">Produtos</h1>
        </div>
        <div>
            <a class="btn btn-primary" href="{{route('products.create')}}" role="button"><i class="fa fa-plus-circle"
                    aria-hidden="true"></i> Criar Novo</a>
        </div>
    </div>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">

                            <table id="products-tb"
                                class="celled table table-striped table-hover dt-responsive display nowrap"
                                cellspacing="0" style="width:100%">

                                {{-- Table head --}}
                                <thead class="table-head">
                                    <tr>
                                        <th>Cód</th>
                                        <th>Descritivo</th>
                                        <th>Marca</th>
                                        <th>Unid</th>
                                        <th>Stock</th>
                                        <th>Valor Custo (unit.)</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>


                                <tbody>
                                    @foreach($data as $product)
                                    @php
                                        $stockVar = "";
                                        if($product->min_stock != 0) {
                                            $stockVar = $product->quantity <= $product->min_stock ? 'color: #C82333;' : "";
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{$product->cod}}</td>
                                        <td>{{mb_strimwidth($product->name, 0, 50, "...")}}</td>
                                        <td>{{$product->brand}}</td>
                                        <td>{{$product->um}}</td>
                                        <td style="{{$stockVar}}" data-min="{{$product->min_stock}}" class="min-stock">{{$product->quantity}}</td>
                                        <td>{{$product->price}}</td>
                                        <td>
                                            <a class="btn btn-success rounded-circle add-to-cart" role="button"
                                            data-qnt="{{$product->quantity}}"  data-un="{{$product->um}}" data-weight="{{$product->weight}}"
                                                data-name="{{$product->name}}" data-id="{{$product->id}}"><i
                                                    class="fas fa-cart-plus btn-success " aria-hidden="true"></i></a>
                                            <a class="ml-2 btn btn-info rounded-circle"
                                                href="{{route('products.update', [$product->id])}}" role="button"><i
                                                    class="fas fa-pen-square"></i></a>
                                            <a class="ml-2 btn btn-danger rounded-circle delete-product"
                                                data-id="{{$product->id}}" data-name="{{$product->name}}"
                                                role="button"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>


                            </table>

                        </div>

                        {{-- Add plugin initialization and configuration code --}}

                        @push('js')
                        <script type="text/javascript" charset="utf8"
                            src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>
                        <script type="text/javascript" charset="utf8"
                            src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
                        <script type="text/javascript" charset="utf8"
                            src="//cdn.datatables.net/plug-ins/1.10.10/sorting/datetime-moment.js"></script>
                        <script type="text/javascript" charset="utf8"
                            src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>


                        <script>

                            $(document).ready(function () {

                                $.fn.dataTable.moment('DD/MM/YYYY HH:mm:ss');    //Formatação com Hora
                                $.fn.dataTable.moment('DD/MM/YYYY');
                                $('#products-tb').DataTable({
                                    language: {
                                        url: '{{ asset("json/dataTableTranslate.json") }}'
                                    },
                                    responsive: true,
                                    "order": [[1, "asc"]],
                                    "pageLength": 25,
                                });

                                setTimeout(function () {
                                    $('input[type="search"]').attr("placeholder", "Digite aqui para pesquisar...");
                                }, 1500)

                                $(".min-stock").click(function () {

                                    let currentStock = $(this).text();
                                    let minStock = $(this).data('min');
                                    $(this).text(minStock);
                                    $(this).data('min', currentStock);

                                });

                            })

                        </script>
                        @endpush

                        @push('css')
                        <style type="text/css">
                            #products-tb tr td,
                            #products-tb tr th {
                                vertical-align: middle;
                            }
                        </style>
                        @endpush


                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<x-modal-to-delete-product />
<x-modal-to-add-to-cart />

@stop
