@extends('adminlte::page')

@section('title', 'JRsystem - Orçamentos | Visualizar')

@section('content_header')
<div class="row">
    <div class="col-12 d-flex justify-content-between top-internal-head">
        <div class="d-flex align-items-center">
            <a href="{{ route('budgets.index')}}"><i class="fa fa-chevron-circle-left" aria-hidden="true"
                    style="font-size: 30px;"></i></a>
            <h1 class="m-0 text-dark ml-2">Orçamento - {{$budget['number']}}</h1>
        </div>
        <div>
            @if(auth()->user()->type == 1)
                <a href="{{ route('budgets.historic', $budget['id'])}}" target="_blank" class="btn btn-dark mr-2 ">Histórico</a>
            @endif
            @if($budget['low_stock'] == 0)
            <button type="button" class="btn btn-warning mr-2 low-in-stock" data-id="{{$budget['id']}}">Dar baixa no
                estoque</button>
            @endif
            @if($budget['pdf_was_generated'] == 0)
                <button type="button" class="btn btn-info generate-pdf mr-2 " data-id="{{$budget['id']}}">Gerar PDF</a>
            @else
                <a href="{{ route('budgets.pdf', $budget['id'])}}" target="_blank" class="btn btn-primary mr-2 ">Visualizar PDF</a>
            @endif
            <button type="button" class="btn btn-primary" id="save-budget">Salvar alterações</a>
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
                        <form action="{{ route('budgets.edit')}}" method="POST" id="budget-form">
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
                                        name="customer_name">
                                </div>
                                <div class="input-group col-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-dark">Fone: </span>
                                    </div>
                                    <input type="text" class="form-control" value="{{$budget['customer_phone']}}"
                                        name="customer_phone">
                                </div>
                            </div>
                            <input type="hidden" name="id" value="{{$budget['id']}}">
                            <div class="form-row mb-2">
                                <div class="input-group col-8">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-dark">Fone A/C: </span>
                                    </div>
                                    <input type="text" class="form-control" value="{{$budget['second_customer_phone']}}"
                                        name="second_customer_phone">
                                </div>
                                <div class="input-group col-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-dark">CNPJ: </span>
                                    </div>
                                    <input type="text" class="form-control" value="{{$budget['customer_cnpj']}}"
                                        name="customer_cnpj">
                                </div>
                            </div>
                            <div class="form-row mb-2">
                                <div class="input-group col-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-dark">Cidade: </span>
                                    </div>
                                    <input type="text" class="form-control" value="{{$budget['customer_city']}}"
                                        name="customer_city">
                                </div>
                                <div class="input-group col-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-dark">Estado: </span>
                                    </div>
                                    <input type="text" class="form-control" value="{{$budget['customer_state']}}"
                                        name="customer_state">
                                </div>
                                <div class="input-group col-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-dark">E-mail: </span>
                                    </div>
                                    <input type="text" class="form-control" value="{{$budget['customer_email']}}"
                                        name="customer_email">
                                </div>
                            </div>
                            <div class="form-row mb-2">
                                <div class="input-group col">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-dark">End. Entrega: </span>
                                    </div>
                                    <input type="text" class="form-control" value="{{$budget['customer_address_to_shipping']}}"
                                        name="customer_address_to_shipping">
                                </div>
                            </div>
                            <div class="form-row mb-3 mt-5">
                                <h5 style="color: #0069D9;">Informações do orçamento</h5>
                            </div>
                            @if($budget['pdf_was_generated'] == 1)
                                <div class="form-row mb-2">
                                    <div class="input-group col-12">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-dark">Aos Cuidados de: </span>
                                        </div>
                                        <input type="text" class="form-control" value="{{$budget['customer_a_c']}}"
                                            name="customer_a_c">
                                    </div>
                                </div>
                                <div class="form-row mb-2">
                                    <div class="input-group col-8">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-dark">Cond. Pagamento: </span>
                                        </div>
                                        <input type="text" class="form-control" value="{{$budget['condition_payment']}}"
                                            name="condition_payment">
                                    </div>
                                    <div class="input-group col-4">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-dark">Prazo Entrega: </span>
                                        </div>
                                        <input type="text" class="form-control" value="{{$budget['time']}}"
                                            name="time">
                                    </div>
                                </div>
                                <div class="form-row mb-2">
                                    <div class="input-group col-8">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-dark">Endereço de Entrega: </span>
                                        </div>
                                        <input type="text" class="form-control" value="{{$budget['address_to_shipping']}}"
                                            name="address_to_shipping">
                                    </div>
                                    <div class="input-group col-4">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-dark">Inspeção: </span>
                                        </div>
                                        <input type="text" class="form-control" value="{{$budget['inspection']}}"
                                            name="inspection">
                                    </div>
                                </div>
                                <div class="form-row mb-2">
                                    <div class="input-group col-12">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-dark">Valor total por escrito: </span>
                                        </div>
                                        <input type="text" class="form-control" value="{{$budget['price_in_string']}}"
                                            name="price_in_string">
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
                                            <th scope="col">Qntd</th>
                                            <th scope="col">Unid</th>
                                            <th scope="col">Valor (unit.)</th>
                                            <th scope="col">Total</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>


                                    <tbody id="items-budget">
                                        @foreach($budgetItems as $k => $item)
                                        <tr id="{{$item->id}}">
                                            <td>{{$k + 1}}</td>
                                            <td>{{$item->product_name}}</td>
                                            <td>{{$item->quantity}}</td>
                                            <td>{{$item->um}}</td>
                                            <td>{{$item->price}}</td>
                                            <td>{{$item->total_price}}</td>
                                            <td><a class="ml-2 remove-item-from-budget" data-id="{{$item->id}}" role="button" style="color: #C82333;"><i class="fas fa-minus-circle"></i></a></td>
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

    $(".generate-pdf").click(function () {
        $("#price_in_string").val("{{$budget['totalWithoutCharacters']}}");
    });


    $("#save-budget").click(function () {
        $("#budget-form").submit();
    });

    $('body').on('click', '.remove-item-from-budget', function (e) {

        let itemId = $(this).attr('data-id');

        if(itemId != null) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('input[name=_token]').val()
                }
            });
            $.ajax({
                type: 'POST',
                data: {id: itemId},
                url: "/budgets/item/delete",
                success: function (data) {
                    $('#items-budget #' + itemId).remove();
                }
            });
        }

    });

</script>
@endpush
@stop
