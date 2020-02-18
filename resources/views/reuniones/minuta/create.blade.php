@extends('layouts.app')

@section('title')
    Crear minuta
@endsection

@section('page-scripts')
<script src="{{asset('js/reuniones/minuta/crear/index.js')}}" defer></script>
@endsection

@section('content')
    <crear-minuta-form
        :reunion-resource="{{json_encode(new App\Http\Resources\ReunionResource($reunion))}}"
    ></crear-minuta-form>    
@endsection
