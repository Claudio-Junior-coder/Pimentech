@extends('adminlte::page')

@section('title', 'Pimentech - Produtos | Editar')

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
                                <h5 style="color: #0069D9;">Controle interno</h5>
                            </div>
                            <div class="form-row w-100 mb-3">
                                <div class="form-group col-md-2">
                                    <label>Código</label>
                                    <input type="text" name="cod" value="{{ $data['cod'] }}"
                                    class="form-control" placeholder="Código" autocomplete="off">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Stock minimo</label>
                                    <input type="text" name="min_stock" value="@if($data['min_stock'] != '0'){{ $data['min_stock'] }}@endif"
                                    class="form-control" placeholder="Informe o stock minimo" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-row mb-3 w-100">
                                <h5 style="color: #0069D9;">Informações básicas</h5>
                            </div>
                            <div class="form-row w-100">
                                <div class="form-group col-md-6">
                                    <label for="name">Nome/Descritivo</label>
                                    <input class="form-control" name="name" id="name" placeholder="Descritivo"
                                        value="{{ $data['name'] }}" autocomplete="off">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="brand">Marca</label>
                                    <input type="text" class="form-control" name="brand" id="brand" placeholder="Marca"
                                        value="{{ $data['brand'] }}" autocomplete="off">
                                </div>
                                <div class="form-group col">
                                    <label for="um">Un</label>
                                    <select id="um" name="um" class="form-control">
                                        @php
                                            $BR = $data['um'] == "BR" ? "selected" : "";
                                            $PC = $data['um'] == "PÇ" ? "selected" : "";
                                            $MT = $data['um'] == "MT" ? "selected" : "";
                                            $RL = $data['um'] == "RL" ? "selected" : "";
                                            $CJ = $data['um'] == "CJ" ? "selected" : "";
                                            $KG = $data['um'] == "KG" ? "selected" : "";
                                            $ML = $data['um'] == "ML" ? "selected" : "";
                                            $PAR = $data['um'] == "PAR" ? "selected" : "";
                                            $EC = $data['um'] == "EC" ? "selected" : "";
                                            $TN = $data['um'] == "TN" ? "selected" : "";
                                            $PT = $data['um'] == "PT" ? "selected" : "";
                                            $NA = "";

                                            if($BR == "" && $PC == "" && $MT == "" && $RL == "" && $CJ == "" && $KG == ""
                                            && $ML == "" && $PAR == "" && $EC == "" && $TN == "" && $PT == "") {
                                                $NA = "selected";
                                            }
                                        @endphp
                                        <option value="N/A" {{$NA}}>N/A</option>
                                        <option value="BR" {{$BR}}>BR</option>
                                        <option value="PÇ" {{$PC}}>PÇ</option>
                                        <option value="MT" {{$MT}}>MT</option>
                                        <option value="RL" {{$RL}}>RL</option>
                                        <option value="CJ" {{$CJ}}>CJ</option>
                                        <option value="KG" {{$KG}}>KG</option>
                                        <option value="M/L" {{$ML}}>M/L</option>
                                        <option value="PAR" {{$PAR}}>PAR</option>
                                        <option value="EÇ" {{$EC}}>EÇ</option>
                                        <option value="TN" {{$TN}}>TN</option>
                                        <option value="PT" {{$PT}}>PT</option>
                                    </select>
                                </div>
                                <div class="form-group col">
                                    <label for="quantity">Stock</label>
                                    <input type="text" name="quantity" class="form-control" id="quantity"
                                        placeholder="Quantidade em stock" value="{{ $data['quantity'] }}" autocomplete="off">
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
                                            placeholder="Valor (unit.)" value="{{ $data['price'] }}" autocomplete="off">
                                    </div>
                                </div>
                                @endif
                                <div class="form-group col">
                                    <label>Peso</label>
                                    <div class="input-group">
                                        <input type="text" name="weight" value="{{ $data['weight'] }}"
                                            class="form-control" placeholder="Peso (opcional)" autocomplete="off">
                                        <div class="input-group-append">
                                            <span class="input-group-text">Kg</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="id" value="{{ $data['id'] }}">
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
