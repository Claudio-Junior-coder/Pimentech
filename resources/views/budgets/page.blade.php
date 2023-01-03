@extends('adminlte::page')

@section('title', 'JRsystem - Orçamentos | Visualizar')

@section('content_header')
<div class="row">
    <div class="col-12 d-flex justify-content-between top-internal-head">
        <div class="d-flex align-items-center">
            <a href="{{ route('budgets.index')}}"><i class="fa fa-chevron-circle-left" aria-hidden="true"
                    style="font-size: 30px;"></i></a>
            <h1 class="m-0 text-dark ml-2">Visualizar Orçamento - {{$budget['number']}}</h1>
        </div>
        <div>
            @if($budget['low_stock'] == 0)
            <button type="button" class="btn btn-warning mr-2 low-in-stock" data-id="{{$budget['id']}}">Dar baixa no
                estoque</button>
            @endif
            <a href="{{ route('budgets.pdf', $budget['id'])}}" target="_blank" class="btn btn-primary">Gerar PDF</a>
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
                            <div class="form-row mb-5">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-dark">Cliente: </span>
                                    </div>
                                    <input type="text" class="form-control" value="{{$budget['customer_name']}}"
                                        disabled>
                                </div>
                            </div>
                            <div class="form-row mb-3">
                                <h5 style="color: #0069D9;">Informações do orçamento</h5>
                            </div>
                            <div class="mb-3 d-flex justify-content-between">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-success">Total do pedido: </span>
                                    </div>
                                    <input type="text" class="form-control" value="{{$budget['total']}}" disabled>
                                </div>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-info">Peso Total: </span>
                                    </div>
                                    <input type="text" class="form-control" value="{{$budget['total_weight']}}" disabled>
                                </div>
                            </div>
                            <div class="form-row">
                                <table class="table cart-table" style="width:100%">


                                    <thead class="table-head">
                                        <tr>
                                            <th scope="col">Itens</th>
                                            <th scope="col">Descritivo</th>
                                            <th scope="col">Peso (unit.)</th>
                                            <th scope="col">Valor (unit.)</th>
                                            <th scope="col">Qntd</th>
                                            <th scope="col">Total</th>
                                        </tr>
                                    </thead>


                                    <tbody id="items-cart">
                                        @foreach($budgetItems as $k => $item)
                                        <tr>
                                            <td>{{$k+1}}</td>
                                            <td>{{$item->product_name}}</td>
                                            <td>{{$item->weight}} Kg</td>
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
@push('js')
<script>
    $("#budget-user").click(function () {
        $("#budget-form").submit();
    });
</script>
@endpush
@stop
