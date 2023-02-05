@extends('adminlte::page')

@section('title', 'JRsystem - Definições | Sistema')

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
                                <h5 style="color: #0069D9; margin-bottom: 0px;">Informações da sua empresa</h5>
                                <p>(Essas informações serão usadas no orçamento)</p>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="company_name">Razão Social / Nome da empresa</label>
                                    <input type="company_name" class="form-control" name="company_name" id="company_name"
                                        placeholder="Nome da empresa / razão social" value="@if(isset($data['company_name'])) {{ $data['company_name'] }} @endif">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="company_address">Endereço</label>
                                    <input type="company_address" class="form-control" name="company_address" id="company_address"
                                        placeholder="Endereço completo" value="@if(isset($data['company_address'])) {{ $data['company_address'] }} @endif">
                                </div>
                            </div>
                            <input type="hidden" name="id" value="@if(isset($data['id'])) {{ $data['id'] }} @endif">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="company_phone">Telefone / Telefones</label>
                                    <input type="company_phone" class="form-control" name="company_phone" id="company_phone"
                                        placeholder="Insira um ou mais telefones que tiver separados por /" value="@if(isset($data['company_phone'])) {{ $data['company_phone'] }} @endif">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="company_cnpj">CNPJ</label>
                                    <input type="company_cnpj" class="form-control" name="company_cnpj" id="company_cnpj"
                                        placeholder="CNPJ" value="@if(isset($data['company_cnpj'])) {{ $data['company_cnpj'] }} @endif">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="company_insc">Inscrição Estadual</label>
                                    <input type="company_insc" class="form-control" name="company_insc" id="company_insc"
                                        placeholder="Inscrição Estadual" value="@if(isset($data['company_insc'])) {{ $data['company_insc'] }} @endif">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="company_insc_municip">Inscrição Municipal</label>
                                    <input type="company_insc_municip" class="form-control" name="company_insc_municip" id="company_insc_municip"
                                        placeholder="Inscrição Municipal" value="@if(isset($data['company_insc_municip'])) {{ $data['company_insc_municip'] }} @endif">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="company_email">E-mail</label>
                                    <input type="company_email" class="form-control" name="company_email" id="company_email"
                                        placeholder="E-mail principal" value="@if(isset($data['company_email'])) {{ $data['company_email'] }} @endif">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="budget_number">Nº orçamento inicial</label>
                                    <input type="budget_number" class="form-control" name="budget_number" id="budget_number"
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
