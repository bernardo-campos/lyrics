@extends('adminlte::page')

@section('title', __('adminlte::menu.albums'))

@section('content_header')
    <div class="d-flex">
        <div>
            <h1 class="m-0 text-dark">{{ __('adminlte::menu.albums') }}</h1>
            <small></small>
        </div>
    </div>
@stop

@section('content')
<div class="row">
<div class="col-12">
<div class="card">
<div class="card-body">
<div class="row">

    @forelse ($artist->albums->sortByDesc('year') as $album)
        <div class="col-xl-4 col-md-6 col-12">
            <div class="info-box">
                @if ($album->image?->url)
                    <span class="info-box-icon">
                        <img src="{{ url($album->image?->url) }}">
                    </span>
                @else
                    <span class="info-box-icon bg-secondary"><i class="fas fa-image"></i></span>
                @endif
                <div class="info-box-content">
                    <span class="info-box-text" title="{{ $album->name }}">{{ $album->name }}</span>
                    <span class="info-box-number d-flex justify-content-between">
                        <span>{{ $album->year }}</span>
                        <span class="text-secondary">{{ $album->songs_count }} <i class="fas fa-music"></i></span>
                    </span>
                </div>
            </div>
        </div>
    @empty
        {{ __('Nothing to show') }}
    @endforelse

</div> <!-- .row -->
</div> <!-- .card-body -->
</div> <!-- .card -->
</div> <!-- .col-12 -->
</div> <!-- .row -->
@endsection
