@extends('layouts.app')

@section('title')
    Crear minuta
@endsection

@section('content')
    <crear-minuta
        :reunion-resource="{{json_encode(new App\Http\Resources\ReunionResource($reunion))}}"
    ></crear-minuta>    
@endsection
