@extends('adminlte::page')

@section('title', 'Pimentech')

@section('content_header')
<h1 class="m-0 text-dark">Painel de controle</h1>
@stop

@php
$isUserAdmin = 0;
if(Auth::user()) {
$isUserAdmin = auth()->user()->type;
}
@endphp

@section('content')
<div class="row">
    <div class="col-lg-3 col-6">

        <div class="small-box bg-info p-4">
            <div class="inner">
                <h3>{{$products}}</h3>
                <p>Produtos</p>
            </div>
            <div class="icon">
                <i class="fa fa-cubes"></i>
            </div>
            <a href="{{route('products.index')}}" class="small-box-footer">
                Mais info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-6">

        <div class="small-box bg-success p-4">
            <div class="inner">
                <h3>{{$budgets}}</h3>
                <p>Orçamentos</p>
            </div>
            <div class="icon">
                <i class="fas fa-money-check-alt"></i>
            </div>
            <a href="{{route('budgets.index')}}" class="small-box-footer">
                Mais info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    @if(PROVIDERS_MODULE)
    <div class="col-lg-3 col-6">

        <div class="small-box bg-warning p-4">
            <div class="inner">
                <h3>{{$providers}}</h3>
                <p>Fornecedores</p>
            </div>
            <div class="icon">
                <i class="fa fa-shopping-basket"></i>
            </div>
            <a href="{{route('provider.info.index')}}" class="small-box-footer">
                Mais info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    @endif

    <div class="col-lg-3 col-6">

        <div class="small-box bg-light p-4">
            <div class="inner">
                <h3>{{$customers}}</h3>
                <p>Clientes</p>
            </div>
            <div class="icon">
                <i class="fa fa-address-card"></i>
            </div>
            <a href="{{route('customers.index')}}" class="small-box-footer">
                Mais info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    @if($isUserAdmin == 1)

    <div class="col-lg-3 col-6">

        <div class="small-box bg-danger p-4">
            <div class="inner">
                <h3>{{$users}}</h3>
                <p>Usuários</p>
            </div>
            <div class="icon">
                <i class="fas fa-fw fa-user"></i>
            </div>
            <a href="{{route('user.index')}}" class="small-box-footer">
                Mais info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    @endif

    @if($isUserAdmin == 1)

    <div class="col-lg-3 col-6">

        <div class="small-box p-4" style="background-color: #023047;
        color: white;">
            <div class="inner">
                <h3>{{$companies}}</h3>
                <p>Empresas</p>
            </div>
            <div class="icon">
                <i class="fa fa-building"></i>
            </div>
            <a href="{{route('companies.index')}}" class="small-box-footer">
                Mais info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    @endif

</div>
@stop
