@extends('adminlte::page')

@section('plugins.Datatables', true)

@section('title', __('adminlte::menu.songs'))

@section('content_header')
    <div class="d-flex">
        <div>
            <h1 class="m-0 text-dark">{{ __('adminlte::menu.songs') }}</h1>
            <small></small>
        </div>
    </div>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-body">
                @include('songs._datatable')
            </div>

        </div>

    </div>
</div>
@stop
