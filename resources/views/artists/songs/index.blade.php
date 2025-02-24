@extends('adminlte::page')
@section('plugins.Datatables', true)

@php($artist = request()->route('artist'))

@section('title', $artist->name .' - '. __('adminlte::menu.songs'))

@section('content_header')
    <div class="d-flex">
        <div>
            <h1 class="m-0 text-dark">{{ $artist->name .' - '. __('adminlte::menu.songs') }}</h1>
            <small></small>
        </div>
    </div>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-body">
                @include('artists.songs._datatable')
            </div>

        </div>

    </div>
</div>
@stop
