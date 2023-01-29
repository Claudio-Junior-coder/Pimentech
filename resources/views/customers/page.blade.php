@extends('adminlte::page')

@section('title', 'JRsystem - Clientes | Editar')

@section('content_header')
<div class="row">
    <div class="col-12 d-flex justify-content-between top-internal-head">
        <div class="d-flex align-items-center">
            <a href="{{ route('customers.index')}}"><i class="fa fa-chevron-circle-left" aria-hidden="true"
                    style="font-size: 30px;"></i></a>
            <h1 class="m-0 text-dark ml-2">Editar Cliente</h1>
        </div>
        <div>
            <button type="button" class="btn btn-danger mr-2 delete-customer" data-id="{{$data->id}}"
                data-name="{{$data->name}}">Excluir cliente</button>
            <button type="button" id="save-customer" class="btn btn-primary">Salvar alterações</button>
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
                        <form action="{{ route('customers.edit')}}" method="POST" id="customer-form">
                            @csrf
                            <div class="form-row mb-3">
                                <h5 style="color: #0069D9;">Informações básicas</h5>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-2">
                                    <label>Código</label>
                                    <input type="text" name="cod" value="{{ $data['cod'] }}"
                                    class="form-control" placeholder="Código" autocomplete="off">
                                </div>
                                <div class="col-10"></div>
                                <div class="form-group col-md-6">
                                    <label for="name">Nome</label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Nome"
                                        value="{{ $data['name'] }}" autocomplete="off">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="phone">Telefone Principal</label>
                                    <input autocomplete="off" type="text" class="form-control" name="phone" id="phone"
                                        placeholder="Telefone" value="{{ $data['phone'] }}">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="a_c">Telefone A/C</label>
                                    <input type="text" name="a_c" class="form-control" id="a_c"
                                        placeholder="A/C" value="{{ $data['a_c'] }}" autocomplete="off">
                                </div>
                            </div>
                            <input type="hidden" name="id" value="{{ $data['id'] }}">
                            <input type="hidden" name="draft" value="0">
                            <div class="form-row mb-3">
                                <div class="form-group col-md-6">
                                    <label for="address_to_shipping">Endereço</label>
                                    <input type="text" class="form-control" name="address_to_shipping" id="address_to_shipping"
                                        placeholder="Endereço" value="{{ $data['address_to_shipping'] }}" autocomplete="off">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="email">E-mail</label>
                                    <input type="text" class="form-control" name="email" id="email" placeholder="E-mail"
                                        value="{{ $data['email'] }}" autocomplete="off">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="city">Cidade</label>
                                    <input type="text" class="form-control" name="city" id="city" placeholder="Cidade"
                                        value="{{ $data['city'] }}" autocomplete="off">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="state">Estado</label>
                                    <input type="text" class="form-control" name="state" id="state" placeholder="Estado"
                                        value="{{ $data['state'] }}" autocomplete="off">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="cnpj">CNPJ</label>
                                    <input type="text" class="form-control" name="cnpj" id="cnpj" placeholder="CNPJ"
                                        value="{{ $data['cnpj'] }}" autocomplete="off">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <x-modal-to-delete-customer />
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
    $("#save-customer").click(function () {
        $("#customer-form").submit();
    });
</script>
@endpush

@stop
