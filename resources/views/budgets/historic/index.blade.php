@extends('adminlte::page')

@section('title', 'JRsystem - Orçamentos | Histórico')

@section('content_header')
<div class="row">
    <div class="col-12 d-flex justify-content-between top-internal-head">
        <div class="d-flex align-items-center">
            <a href="{{ route('budgets.view', $id)}}"><i class="fa fa-chevron-circle-left" aria-hidden="true"
                    style="font-size: 30px;"></i></a>
            <h1 class="m-0 text-dark ml-2">Histórico de edições</h1>
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

                            <table id="users-tb"
                                class="celled table table-striped table-hover dt-responsive display nowrap"
                                cellspacing="0" style="width:100%">

                                {{-- Table head --}}
                                <thead style="
                                    background-color: #23272B;
                                    color: white;
                                    ">
                                    <tr>
                                        <th>#</th>
                                        <th>Ação</th>
                                        <th>Info anterior</th>
                                        <th>Info atual</th>
                                        <th>Editado por</th>
                                        <th>Data</th>
                                    </tr>
                                </thead>


                                <tbody>
                                    @foreach($budgets as $k => $budget)
                                    <tr>
                                        <td>{{$k += 1}}</td>
                                        <td>{{$budget->action}}</td>
                                        <td>{{$budget->before_info}}</td>
                                        <td>{{$budget->current_info}}</td>
                                        <td>{{$budget->made_by}}</td>
                                        <td>{{ date('d/m/Y - H:i', strtotime($budget->created_at));}}</td>
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
                                $('#users-tb').DataTable({
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
                            #users-tb tr td,
                            #users-tb tr th {
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
<x-modal-to-delete-user />

@stop
