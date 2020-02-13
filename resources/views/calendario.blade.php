@extends('layouts.app')

@section('title')
    Calendario
@endsection

@section('page-scripts')
    <script src="{{asset('js/calendario/index.js')}}" defer></script>
@endsection

@section('content')
    
<div class="row">
    <div class="col-sm-12">
        @include('flash-message')
    </div>
</div>

@can('create', App\Reunion::class)
<div class="row">
    <div class="col-md-12 py-2">
        <a class="btn btn-primary" href="{{route('reuniones.create')}}" role="button">
            <i class="fa fa-calendar-plus" aria-hidden="true"></i>
            <span class="ml-2">Agendar reunión</span>
        </a>
    </div>
</div>
<hr>
@endcan

<calendario-index></calendario-index>

@endsection
