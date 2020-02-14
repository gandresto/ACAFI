@extends('layouts.app')

@section('title')
    Crear Reunión para la Academia de {{$academia->nombre}}
@endsection

@section('page-scripts')
    <script src="{{asset('js/reuniones/crear/index.js')}}" deffer></script>
@endsection

@section('content')
<div id="reunion-create" class="row">
    <formulario-reunion
        academia-prop="{{json_encode(new App\Http\Resources\AcademiaResource($academia, 1, 1, 1))}}"    
    ></formulario-reunion>
</div>
@endsection