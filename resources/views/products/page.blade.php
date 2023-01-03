@extends('adminlte::page')

@section('title', 'JRsystem - Produtos | Editar')

@section('content_header')
<div class="row">
    <div class="col-12 d-flex justify-content-between top-internal-head">
        <div class="d-flex align-items-center">
            <a href="{{ route('products.index')}}"><i class="fa fa-chevron-circle-left" aria-hidden="true"
                    style="font-size: 30px;"></i></a>
            <h1 class="m-0 text-dark ml-2">Editar Produto</h1>
        </div>
        <div>
            <button type="button" class="btn btn-danger mr-2 delete-product" data-id="{{$data->id}}"
                data-name="{{$data->name}}">Excluir produto</button>
            <button type="button" id="save-product" class="btn btn-primary">Salvar alterações</button>
        </div>
    </div>
</div>
@stop


@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <div class="row mb-5">
                    <div class="col-12">
                        <form action="{{ route('products.edit')}}" method="POST" id="product-form">
                            @csrf
                            <div class="form-row mb-3 w-100">
                                <h5 style="color: #0069D9;">Informações básicas</h5>
                            </div>
                            <div class="form-row w-100">
                                <div class="form-group col-md-6">
                                    <label for="name">Nome/Descritivo</label>
                                    <input class="form-control" name="name" id="name" placeholder="Descritivo"
                                        value="{{ $data['name'] }}">
                                </div>
                                <div class="form-group col">
                                    <label for="quantity">Quantidade</label>
                                    <input type="text" name="quantity" class="form-control" id="quantity"
                                        placeholder="Quantidade" value="{{ $data['quantity'] }}">
                                </div>
                                @if(!PROVIDERS_MODULE)
                                <div class="form-group col-md-4">
                                    <label>Preço</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">R$</span>
                                        </div>
                                        <input type="tel" name="price"
                                            onkeypress="$(this).mask('#.##0,00', {reverse: true});" class="form-control"
                                            placeholder="Valor (unit.)" value="{{ $data['price'] }}">
                                    </div>
                                </div>
                                @endif
                                <div class="form-group col">
                                    <label>Peso</label>
                                    <div class="input-group">
                                        <input type="tel" name="weight" value="{{ $data['weight'] }}"
                                            class="form-control" onkeypress="$(this).mask('#0.000', {reverse: true});" placeholder="Peso (opcional)">
                                        <div class="input-group-append">
                                            <span class="input-group-text">Kg</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <input type="hidden" name="id" value="{{ $data['id'] }}">
                            <input type="hidden" name="draft" value="0">
                        </form>
                    </div>
                </div>

                @if(PROVIDERS_MODULE)
                <div class="row">
                    <div class="col-12">
                        <div class="form-row mb-3">
                            <div class="col-12 mb-3">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h5 class="mt-3 mr-4" style="color: #0069D9;">
                                            SBR - Fornecedores / Orçamentos
                                        </h5>
                                    </div>
                                    <button type="button" class="btn btn-warning add-sbr-fields rounded-circle"
                                        data-productId="{{ $data['id'] }}"><i class="fa fa-plus-circle"
                                            aria-hidden="true"></i></button>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3 sbr-form">
                                    @foreach($data->sbr as $sb)
                                    @push('js')
                                    <script>
                                        setTimeout(function () {
                                            addNewSbr({!! json_encode($sb)!!});
                                                        }, 1000)
                                    </script>
                                    @endpush
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @push('js')
                <script>

                    $("#save-product").click(function () {
                        $("#product-form").submit();
                    });
                </script>
                @endpush
                <x-modal-to-delete-product />
            </div>
        </div>
    </div>
</div>

@stop
