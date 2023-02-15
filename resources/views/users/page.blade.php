@extends('adminlte::page')

@section('title', 'Pimentech - Usuários | Editar')

@section('content_header')
<div class="row">
    <div class="col-12 d-flex justify-content-between top-internal-head">
        <div class="d-flex align-items-center">
            <a href="{{ route('user.index')}}"><i class="fa fa-chevron-circle-left" aria-hidden="true"
                    style="font-size: 30px;"></i></a>
            <h1 class="m-0 text-dark ml-2">Editar Usuário</h1>
        </div>
        <div>
            <button type="button" class="btn btn-danger mr-2 delete-user" data-id="{{$data->id}}"
                data-name="{{$data->name}}">Excluir usuário</button>
            <button type="button" id="save-user" class="btn btn-primary">Salvar alterações</button>
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
                        <form action="{{ route('user.edit')}}" method="POST" id="user-form">
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
                                <div class="form-group col-md-6">
                                    <label for="type">Função</label>
                                    <select id="type" name="type" class="form-control">
                                        @php
                                        $Collaborator = $data['type'] == 0 ? "selected" : "";
                                        $Administrator = $data['type'] == 1 ? "selected" : "";
                                        if($Collaborator == "" && $Administrator == "") {
                                        $Collaborator = "selected";
                                        }
                                        @endphp
                                        <option value="0" {{$Collaborator}}>Colaborador</option>
                                        <option value="1" {{$Administrator}}>Administrador</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="email">E-mail</label>
                                    <input type="text" class="form-control" name="email" id="email" placeholder="E-mail"
                                        value="{{ $data['email'] }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="password">Senha</label>
                                    <input type="password" class="form-control" name="password" id="password"
                                        placeholder="Senha" value="********">
                                </div>
                            </div>
                            <input type="hidden" name="id" value="{{ $data['id'] }}">
                        </form>
                    </div>
                </div>
                <x-modal-to-delete-user />
            </div>
        </div>
    </div>
</div>
@push('js')
<script>
    $("#save-user").click(function () {
        $("#user-form").submit();
    });
</script>
@endpush
@stop
