@extends('adminlte::page')

@section('title', 'JRsystem - Orçamentos | Visualizar')

@section('content_header')
<div class="row">
    <div class="col-12 d-flex justify-content-between top-internal-head">
        <div class="d-flex align-items-center">
            <a href="{{ route('budgets.index')}}"><i class="fa fa-chevron-circle-left" aria-hidden="true"
                    style="font-size: 30px;"></i></a>
            <h1 class="m-0 text-dark ml-2">Visualizar Orçamento</h1>
        </div>
        <div>
            @if($budget['low_stock'] == 0)
            <button type="button" class="btn btn-warning mr-2 low-in-stock" data-id="{{$budget['id']}}">Dar baixa no
                estoque</button>
            @endif
            @if($budget['pdf_was_generated'] == 0)
                <button type="button" class="btn btn-primary generate-pdf" data-id="{{$budget['id']}}">Gerar PDF</a>
            @else
                <a href="{{ route('budgets.pdf', $budget['id'])}}" target="_blank" class="btn btn-primary">Visualizar PDF</a>
            @endif
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
                        <form action="" method="POST" id="budget-form">
                            @csrf
                            <div class="form-row mb-3">
                                <h5 style="color: #0069D9;">Informações do cliente</h5>
                            </div>
                            <div class="form-row mb-2">
                                <div class="input-group col-8">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-dark">Cliente: </span>
                                    </div>
                                    <input type="text" class="form-control" value="{{$budget['customer_name']}}"
                                        disabled>
                                </div>
                                <div class="input-group col-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-dark">Fone: </span>
                                    </div>
                                    <input type="text" class="form-control" value="{{$budget['customer_phone']}}"
                                        disabled>
                                </div>
                            </div>
                            <div class="form-row mb-2">
                                <div class="input-group col-8">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-dark">A/C: </span>
                                    </div>
                                    <input type="text" class="form-control" value="{{$budget['customer_a_c']}}"
                                        disabled>
                                </div>
                                <div class="input-group col-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-dark">CNPJ: </span>
                                    </div>
                                    <input type="text" class="form-control" value="{{$budget['customer_cnpj']}}"
                                        disabled>
                                </div>
                            </div>
                            <div class="form-row mb-2">
                                <div class="input-group col-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-dark">Cidade: </span>
                                    </div>
                                    <input type="text" class="form-control" value="{{$budget['customer_city']}}"
                                        disabled>
                                </div>
                                <div class="input-group col-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-dark">Estado: </span>
                                    </div>
                                    <input type="text" class="form-control" value="{{$budget['customer_state']}}"
                                        disabled>
                                </div>
                                <div class="input-group col-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-dark">E-mail: </span>
                                    </div>
                                    <input type="text" class="form-control" value="{{$budget['customer_email']}}"
                                        disabled>
                                </div>
                            </div>
                            <div class="form-row mb-2">
                                <div class="input-group col">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-dark">End. Entrega: </span>
                                    </div>
                                    <input type="text" class="form-control" value="{{$budget['customer_address_to_shipping']}}"
                                        disabled>
                                </div>
                            </div>
                            <div class="form-row mb-3 mt-5">
                                <h5 style="color: #0069D9;">Informações do orçamento</h5>
                            </div>
                            @if($budget['pdf_was_generated'] == 1)
                                <div class="form-row mb-2">
                                    <div class="input-group col-8">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-dark">Cond. Pagamento: </span>
                                        </div>
                                        <input type="text" class="form-control" value="{{$budget['condition_payment']}}"
                                            disabled>
                                    </div>
                                    <div class="input-group col-4">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-dark">Prazo Entrega: </span>
                                        </div>
                                        <input type="text" class="form-control" value="{{$budget['time']}}"
                                            disabled>
                                    </div>
                                </div>
                                <div class="form-row mb-2">
                                    <div class="input-group col-8">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-dark">Endereço de Entrega: </span>
                                        </div>
                                        <input type="text" class="form-control" value="{{$budget['address_to_shipping']}}"
                                            disabled>
                                    </div>
                                    <div class="input-group col-4">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-dark">Inspeção: </span>
                                        </div>
                                        <input type="text" class="form-control" value="{{$budget['inspection']}}"
                                            disabled>
                                    </div>
                                </div>
                                <div class="form-row mb-2">
                                    <div class="input-group col-12">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-dark">Valor total por escrito: </span>
                                        </div>
                                        <input type="text" class="form-control" value="{{$budget['price_in_string']}}"
                                            disabled>
                                    </div>
                                </div>
                            @endif
                            <div class="form-row mb-3">
                                <div class="input-group col">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-success">Total do pedido: </span>
                                    </div>
                                    <input type="text" class="form-control" value="{{$budget['total']}}" disabled>
                                </div>
                            </div>
                            <div class="form-row">
                                <table class="table cart-table" style="width:100%">


                                    <thead class="table-head">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Descritivo</th>
                                            <th scope="col">Valor (unit.)</th>
                                            <th scope="col">Qntd</th>
                                            <th scope="col">Total</th>
                                        </tr>
                                    </thead>


                                    <tbody id="items-cart">
                                        @foreach($budgetItems as $k => $item)
                                        <tr>
                                            <td>{{$k + 1}}</td>
                                            <td>{{$item->product_name}}</td>
                                            <td>{{$item->price}}</td>
                                            <td>{{$item->quantity}}</td>
                                            <td>{{$item->total_price}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>


                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<x-modal-to-low-stock />
<x-modal-to-generate-pdf />
@push('js')
<script>
    $("#budget-user").click(function () {
        $("#budget-form").submit();
    });
</script>
@endpush
@stop
