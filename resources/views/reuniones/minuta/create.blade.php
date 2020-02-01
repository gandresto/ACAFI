@extends('layouts.app')

@section('page-scripts')
    <script src="{{ asset('js/warn-exit.js') }}" defer></script>
@endsection

@section('title')
    Crear minuta
@endsection

@section('content')
    <crear-minuta
        :reunion-resource="{{json_encode(new App\Http\Resources\ReunionResource($reunion))}}"
    ></crear-minuta>    
@endsection
