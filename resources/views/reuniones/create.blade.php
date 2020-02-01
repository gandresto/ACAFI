@extends('layouts.app')

@section('title')
    Crear Reunión
@endsection

@section('page-scripts')
    <script src="{{ asset('js/warn-exit.js') }}" defer></script>
@endsection

@section('content')
    <crear-reunion></crear-reunion>
@endsection
