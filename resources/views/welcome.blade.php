@extends('adminlte::page')

@section('title', 'Listado de Cuentas')

@section('content_header')
    <div class="d-flex">
        <div>
            <h1 class="m-0 text-dark">Welcome</h1>
            <small></small>
        </div>
    </div>
@stop

@section('content')
<h1>
    {{ config('app.name') }}
</h1>
@stop

@push('js')
@endpush
