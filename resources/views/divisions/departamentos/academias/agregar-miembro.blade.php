@extends('layouts.app')

@section('title')
    Agregar miembros para la Academia de {{$academia->nombre}}
@endsection

@section('page-scripts')
    <script src="{{ asset('js/academias/miembros/agregar/index.js') }}"></script>
@endsection

@section('content')
    <agregar-miembro-form :academia-prop="{{json_encode(new App\Http\Resources\AcademiaResource($academia))}}">
    </agregar-miembro-form>
@endsection
