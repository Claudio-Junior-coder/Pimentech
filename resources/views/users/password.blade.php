@extends('adminlte::page')

@section('title', 'Pimentech - Usuários | Alterar Senha')

@section('content_header')
<div class="row">
    <div class="col-12 d-flex justify-content-between top-internal-head">
        <div class="d-flex align-items-center">
            <h1 class="m-0 text-dark ml-2">Alterar Senha</h1>
        </div>
        <div>
            <button type="button" class="btn btn-primary" id="save-password">Salvar alterações</button>
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
                        <form action="{{ route('user.edit.password')}}" method="POST" id="password-form">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="password">Nova Senha</label>
                                    <input type="password" class="form-control" name="password" id="password"
                                        placeholder="Senha" value="********">
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
    $("#save-password").click(function () {
        $("#password-form").submit();
    });
</script>
@endpush
@stop
