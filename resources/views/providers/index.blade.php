@extends('adminlte::page')

@section('title', 'Pimentech - Fornecedores')

@section('content_header')
<div class="row">
    <div class="col-12 d-flex justify-content-between top-internal-head">
        <div class="d-flex align-items-center">
            <h1 class="m-0 text-dark ml-2">Fornecedores</h1>
        </div>
        <div>
            <a class="btn btn-primary" href="{{route('provider.info.create')}}" role="button"><i
                    class="fa fa-plus-circle" aria-hidden="true"></i> Criar Novo</a>
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

                            <table id="providers-tb"
                                class="celled table table-striped table-hover dt-responsive display nowrap"
                                cellspacing="0" style="width:100%">

                                {{-- Table head --}}
                                <thead style="
                                    background-color: #FFC107;
                                    ">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nome</th>
                                        <th>Endereço</th>
                                        <th>Telefone</th>
                                        <th>Telefone 2</th>
                                        <th>Descrição</th>
                                        <th>Editar</th>
                                        <th>Excluir</th>
                                    </tr>
                                </thead>


                                <tbody>
                                    @foreach($data as $providerInfo)
                                    <tr>
                                        <td>{{$providerInfo->id}}</td>
                                        <td>{{$providerInfo->name}}</td>
                                        <td>{{$providerInfo->address}}</td>
                                        <td>{{$providerInfo->telephone}}</td>
                                        <td>{{$providerInfo->telephone_two}}</td>
                                        <td>{{mb_strimwidth($providerInfo->description, 0, 50, "...")}}</td>
                                        <td><a class="btn btn-info rounded-circle"
                                                href="{{route('provider.info.update', [$providerInfo->id])}}"
                                                role="button"><i class="fas fa-pen-square"></i></a></td>
                                        <td><a class="btn btn-danger rounded-circle delete-provider-info"
                                                data-id="{{$providerInfo->id}}" data-name="{{$providerInfo->name}}"
                                                role="button"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
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
                                $('#providers-tb').DataTable({
                                    language: {
                                        url: '{{ asset("json/dataTableTranslate.json") }}'
                                    },
                                    responsive: true,
                                    "order": [[0, "desc"]],
                                    "pageLength": 25,
                                });

                                setTimeout(function () {
                                    $('input[type="search"]').attr("placeholder", "Digite aqui para pesquisar...");
                                }, 1500)

                            })

                        </script>
                        @endpush

                        @push('css')
                        <style type="text/css">
                            #providers-tb tr td,
                            #providers-tb tr th {
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
<x-modal-to-delete-provider-info />

@stop
