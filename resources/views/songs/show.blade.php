@extends('adminlte::page')

@section('plugins.Datatables', true)

@section('title', __('Song'))

@section('content_header')
    <div class="d-flex">
        <div>
            <h1 class="m-0 text-dark">{{ $song->album->artist->name }} - {{ $song->name }}</h1>
            <small></small>
        </div>
    </div>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-body" style="white-space: pre-line;">
                {{ $song->lyric }}
            </div>

        </div>

    </div>
</div>
@stop
