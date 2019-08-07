@extends('layouts.app')
@section('title')
    No autorizado
@endsection
@section('content')

    <div class="col-md-12 text-center">
        <div class="h1">
            {{$role}} : No tienes permiso para ver esta página 
        </div>
    </div>

@endsection
