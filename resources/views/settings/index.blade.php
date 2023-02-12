@extends('adminlte::page')

@section('title', 'Pimentech - Definições | Sistema')

@section('content_header')
<div class="row">
    <div class="col-12 d-flex justify-content-between top-internal-head">
        <div class="d-flex align-items-center">
            <h1 class="m-0 text-dark ml-2">Configurações do sistema</h1>
        </div>
        <div>
            <button type="button" class="btn btn-primary" id="save-settings">Salvar alterações</button>
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
                        <form action="{{ route('settings.edit')}}" method="POST" id="settings-form">
                            @csrf
                            <div class="form-row mb-3 d-flex flex-column">
                                <h5 style="color: #0069D9; margin-bottom: 0px;">Informações essênciais</h5>
                                <p>(Essas informações serão usadas para o bom funcionamento do sistema)</p>
                            </div>
                            <div class="form-row">
                                <input type="hidden" name="id" value="1">
                                <div class="form-group col-md-5">
                                    <label for="company_email">E-mail que receberá notificações do sistema</label>
                                    <input type="text" class="form-control" name="company_email" id="company_email"
                                        placeholder="E-mail principal" value="@if(isset($data['company_email'])) {{ $data['company_email'] }} @endif">
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="company_name">Nome da empresa que o sistema poderá usar em alguns lugares</label>
                                    <input type="text" class="form-control" name="company_name" id="company_name"
                                        placeholder="Nome da empresa que o sistema talvez use em alguns lugares" value="@if(isset($data['company_name'])) {{ $data['company_name'] }} @endif">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="budget_number">Nº orçamento inicial</label>
                                    <input type="text" class="form-control" name="budget_number" id="budget_number"
                                        placeholder="Nº orçamento inicial" value="@if(isset($data['budget_number'])) {{ $data['budget_number'] }} @endif">
                                </div>
                            </div>
                            <div class="form-row mb-3 d-flex flex-column mt-3">
                                <h5 style="color: #0069D9; margin-bottom: 0px;">Relatórios</h5>
                            </div>
                        </form>
                        <form action="{{route('settings.report')}}" method="post">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Selecione o relatório a ser gerado</label>
                                    <select class="form-control" name="report">
                                        <option value="stock_cost">Custo do stock</option>
                                    </select>
                                </div>
                                <div class="form-group col-6 mt-4">
                                    <button type="submit" class="btn btn-success">Gerar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('js')
<script>
    $("#save-settings").click(function () {
        $("#settings-form").submit();
    });
</script>
@endpush
@stop
