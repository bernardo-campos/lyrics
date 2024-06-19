@extends('adminlte::page')

@section('title', __('adminlte::menu.albums'))

@section('content_header')
    <div class="d-flex">
        <div>
            <h1 class="m-0 text-dark">{{ $artist->name }} - {{ $album->name }} ({{ $album->year }})</h1>
            <small></small>
        </div>
        <div class="ml-auto">
            <a href="{{ route('artists.albums.index', $artist) }}">
                <x-adminlte-button label="{{ __('Back') }}" theme="light" icon="fas fa-chevron-left mr-2"/>
            </a>
        </div>
    </div>
@stop

@section('content')
<div class="row">
<div class="col-12">
<div class="card">
<div class="card-body">
<div class="row">
    <div class="col-5 col-sm-3">
        <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
            @foreach ($album->songs as $song)
                @php
                    $slug = Str::slug($song->number.$song->name, '-');
                    $classes = $loop->first ? 'active' : '';
                    $classes .= is_null($song->lyric) ? ' text-muted' : '';
                @endphp
                <a
                    class="nav-link px-0 py-1 {{ $classes }}"
                    id="vert-tabs-{{ $song->number }}-tab"
                    data-toggle="pill"
                    href="#vert-tabs-{{ $slug }}"
                    role="tab"
                    aria-controls="vert-tabs-{{ $slug }}"
                    aria-selected="{{ $loop->first ? 'true' : 'false' }}"
                >
                    {{ str_pad($song->number, 2, '0', STR_PAD_LEFT) }}. {{ $song->name }}
                </a>
            @endforeach
        </div>
    </div>
    <div class="col-7 col-sm-9">
        <div class="tab-content" id="vert-tabs-tabContent">
            @foreach ($album->songs as $song)
                @php
                    $slug = Str::slug($song->number.$song->name, '-');
                @endphp
                <div
                    class="tab-pane text-left fade {{ $loop->first ? 'active show' : '' }}"
                    id="vert-tabs-{{ $slug }}"
                    role="tabpanel"
                    aria-labelledby="vert-tabs-{{ $slug }}-tab"
                >
                    <h4>{{ $song->name }}</h4>
                    <div style="white-space: pre-line;">{{ $song->lyric }}</div>
                </div>
            @endforeach
        </div>
    </div>

</div> <!-- .row -->
</div> <!-- .card-body -->
</div> <!-- .card -->
</div> <!-- .col-12 -->
</div> <!-- .row -->
@endsection

@push('css')
<style type="text/css">
    a.active{
        font-weight: 700;
        color: #007bff!important;
    }
</style>
@endpush