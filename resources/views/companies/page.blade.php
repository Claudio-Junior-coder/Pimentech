@extends('adminlte::page')

@section('title', 'Pimentech - Empresas | Editar')

@section('content_header')
<div class="row">
    <div class="col-12 d-flex justify-content-between top-internal-head">
        <div class="d-flex align-items-center">
            <a href="{{ route('companies.index')}}"><i class="fa fa-chevron-circle-left" aria-hidden="true"
                    style="font-size: 30px;"></i></a>
            <h1 class="m-0 text-dark ml-2">Editar Empresa</h1>
        </div>
        <div>
            <button type="button" class="btn btn-danger mr-2 delete-company" data-id="{{$data->id}}"
                data-name="{{$data->name}}">Excluir Empresa</button>
            <button type="button" id="save-company" class="btn btn-primary">Salvar alterações</button>
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
                        <form action="{{ route('companies.edit')}}" method="POST" id="company-form">
                            @csrf
                            <input type="hidden" name="id" value="{{ $data['id'] }}">
                            <input type="hidden" name="draft" value="0">

                            <div class="form-row mb-3 d-flex flex-column">
                                <h5 style="color: #0069D9; margin-bottom: 0px;">Informações da sua empresa</h5>
                                <p>(Essas informações serão usadas no orçamento)</p>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="name">Razão Social / Nome da empresa</label>
                                    <input type="name" class="form-control" name="name" id="name"
                                        placeholder="Nome da empresa / razão social" value="@if(isset($data['name'])) {{ $data['name'] }} @endif">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="address">Endereço</label>
                                    <input type="address" class="form-control" name="address" id="address"
                                        placeholder="Endereço completo" value="@if(isset($data['address'])) {{ $data['address'] }} @endif">
                                </div>
                            </div>
                            <input type="hidden" name="id" value="@if(isset($data['id'])) {{ $data['id'] }} @endif">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="phone">Telefone / Telefones</label>
                                    <input type="phone" class="form-control" name="phone" id="phone"
                                        placeholder="Insira um ou mais telefones que tiver separados por /" value="@if(isset($data['phone'])) {{ $data['phone'] }} @endif">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="cnpj">CNPJ</label>
                                    <input type="cnpj" class="form-control" name="cnpj" id="cnpj"
                                        placeholder="CNPJ" value="@if(isset($data['cnpj'])) {{ $data['cnpj'] }} @endif">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="insc">Inscrição Estadual</label>
                                    <input type="insc" class="form-control" name="insc" id="insc"
                                        placeholder="Inscrição Estadual" value="@if(isset($data['insc'])) {{ $data['insc'] }} @endif">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="insc_municip">Inscrição Municipal</label>
                                    <input type="insc_municip" class="form-control" name="insc_municip" id="insc_municip"
                                        placeholder="Inscrição Municipal" value="@if(isset($data['insc_municip'])) {{ $data['insc_municip'] }} @endif">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <x-modal-to-delete-company />
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
    $("#save-company").click(function () {
        $("#company-form").submit();
    });
</script>
@endpush

@stop
