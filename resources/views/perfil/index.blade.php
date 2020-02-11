@extends('layouts.app')

@section('title')
    Mi perfil
@endsection

@section('content')

<div class="row">
    <div class="col-sm-12 col-md-5">
        <h5>Información de usuario</h5>
        <p class="pl-2">
            {{$user->gradoNombreCompleto}} <br>
            {{$user->email}} <br>
        </p>
    </div>
</div>

@if ($user->academiasQuePreside->isNotEmpty())
    <hr>
    <div class="row">
        <div class="col-sm-12">
            <h5>Academias como presidente</h5>
        </div>
        <div class="col-sm-12">
            <div class="table-responsive-sm">
                <table class="table table-striped">
                    <thead class="thead-default">
                        <tr>
                            <th>Academia</th>
                            <th>Presidente desde</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($user->academiasQuePreside as $academia)
                                <tr>
                                    <td scope="row">Academia de {{$academia->nombre}}</td>
                                    <td>{{ formato_fecha_esp($academia->pivot->fecha_ingreso) }}</td>
                                    <td>
                                        <a name="ver-acad-{{$academia->id}}" 
                                            id="ver-acad-{{$academia->id}}" 
                                            class="btn btn-success" 
                                            href="{{url("divisions/{$academia->division->id}/departamentos/{$academia->departamento->id}/academias/{$academia->id}")}}" 
                                            role="button" 
                                            title="Ver detalles de academia"
                                        >
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                </table>
            </div>
        </div>
    </div>
@endif
   
@if ($user->academiasComoMiembroActivo->isNotEmpty())
    <hr>
    <div class="row">
        <div class="col-sm-12">
            <h5>Academias como miembro</h5>
        </div>
        <div class="col-sm-12">
            <div class="table-responsive-sm">
                <table class="table table-striped">
                    <thead class="thead-default">
                        <tr>
                            <th>Academia</th>
                            <th>Miembro desde</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($user->academiasComoMiembroActivo as $academia)
                                <tr>
                                    <td scope="row">Academia de {{$academia->nombre}}</td>
                                    <td>{{ formato_fecha_esp($academia->pivot->fecha_ingreso) }}</td>
                                    <td>
                                        <a name="ver-acad-{{$academia->id}}" 
                                            id="ver-acad-{{$academia->id}}" 
                                            class="btn btn-success" 
                                            href="{{url("divisions/{$academia->division->id}/departamentos/{$academia->departamento->id}/academias/{$academia->id}")}}" 
                                            role="button" 
                                            title="Ver detalles de academia"
                                        >
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                </table>
            </div>
        </div>
    </div>
@endif
@endsection