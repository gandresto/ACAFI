@extends('layouts.app')
@section('title')
    Calendario
@endsection

@section('content')

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    Sesión iniciada

@endsection
