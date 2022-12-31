@extends('adminlte::page')

@section('title', 'JRsystem - Fornecedores | Editar')

@section('content_header')
<div class="row">
    <div class="col-12 d-flex justify-content-between top-internal-head">
        <div class="d-flex align-items-center">
            <a href="{{ route('provider.info.index')}}"><i class="fa fa-chevron-circle-left" aria-hidden="true"
                    style="font-size: 30px;"></i></a>
            <h1 class="m-0 text-dark ml-2">Editar Fornecedor</h1>
        </div>
        <div>
            <button type="button" class="btn btn-danger mr-2 delete-provider-info" data-id="{{$data->id}}"
                data-name="{{$data->name}}">Excluir fornecedor</button>
            <button type="button" id="save-provider" class="btn btn-primary">Salvar alterações</button>
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
                        <form action="{{ route('provider.info.edit')}}" method="POST" id="provider-form">
                            @csrf
                            <div class="form-row mb-3">
                                <h5 style="color: #0069D9;">Informações básicas</h5>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="name">Nome</label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Nome"
                                        value="{{ $data['name'] }}">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="telephone">Telefone Principal</label>
                                    <input type="text" class="form-control" name="telephone" id="telephone"
                                        placeholder="Telefone Principal" value="{{ $data['telephone'] }}">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="telephone_two">Telefone Secundário</label>
                                    <input type="text" name="telephone_two" class="form-control" id="telephone_two"
                                        placeholder="Telefone Secundário" value="{{ $data['telephone_two'] }}">
                                </div>
                            </div>
                            <input type="hidden" name="id" value="{{ $data['id'] }}">
                            <input type="hidden" name="draft" value="0">
                            <div class="form-row mb-3">
                                <div class="form-group col-md-6">
                                    <label for="address">Rua</label>
                                    <input type="text" class="form-control" name="address" id="address"
                                        placeholder="Endereço" value="{{ $data['address'] }}">
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="add_number">Nº</label>
                                    <input type="text" class="form-control" name="add_number" id="add_number"
                                        placeholder="Nº" value="{{ $data['add_number'] }}">
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="zone">Bairro</label>
                                    <input type="text" class="form-control" name="zone" id="zone" placeholder="Bairro"
                                        value="{{ $data['zone'] }}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="city">Cidade</label>
                                    <input type="text" class="form-control" name="city" id="city" placeholder="Cidade"
                                        value="{{ $data['city'] }}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="state">Estado</label>
                                    <input type="text" class="form-control" name="state" id="state" placeholder="Estado"
                                        value="{{ $data['state'] }}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="cep">CEP</label>
                                    <input type="text" class="form-control" name="cep" id="cep" placeholder="CEP"
                                        value="{{ $data['cep'] }}">
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="description">Observações</label>
                                    <input type="text" name="description" class="form-control" id="description"
                                        placeholder="Observações" value="{{ $data['description'] }}">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <x-modal-to-delete-provider-info />
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
    $("#save-provider").click(function () {
        $("#provider-form").submit();
    });
</script>
@endpush

@stop
