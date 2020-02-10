@extends('layouts.app')

@section('title')
    Academia de {{$academia->nombre}}
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12 col-md-8">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td scope="row">Nombre de la academia</td>
                    <td>{{$academia->nombre}}</td>
                </tr>
                <tr>
                    <td scope="row">Presidente de academia</td>
                    <td>{{ $academia->presidente->gradoNombreCompleto }}</td>
                </tr>
                <tr>
                    <td scope="row">Correo</td>
                    <td>
                        <a href="mailto:{{ $academia->presidente->email }}">
                            {{ $academia->presidente->email }}
                        </a>
                    </td>
                </tr>
                <tr>
                    <td scope="row">Departamento de origen</td>
                    <td>
                        <a href="{{route('divisions.departamentos.show', [$division->id, $departamento->id])}}">{{$departamento->nombre}}</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<hr>
@can('verMiembros', $academia)
    <div class="row">
        <div class="col-md-12 pb-2">
            <h5>
                Miembros de la Academia
            </h5>
        </div>
    </div>
    @can('agregarMiembro', $academia)
        <div class="row">
            <div class="col-md-12 py-2">
                <a class="btn btn-primary" href="#" role="button">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                    <span class="ml-2">Añadir miembro</span>
                </a>
            </div>
        </div>
    @endcan
    <div class="row">
        <div class="col-md-12">
            @include('flash-message')
        </div>
    </div>
    @if ($academia->miembros->isEmpty())
        <div class="row">
            <div class="col-sm-12">
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>Esta academia no tiene miembros registrados</strong>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Miembro</th>
                                <th scope="col">Correo</th>
                                <th scope="col">Miembro desde</th>
                                {{-- @can('create', App\Academia::class) --}}
                                    <th scope="col">Acciones</th>
                                {{-- @endcan --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($academia->miembrosActuales as $miembro)
                                <tr>
                                    <td>{{$miembro->gradoNombreCompleto}}</td>
                                    <td>{{$miembro->email}}</td>
                                    <td>{{$miembro->pivot->fecha_ingreso}}</td>
                                    {{-- @can('create', App\Academia::class) --}}
                                        <td>
                                            <form action="{{ route('divisions.departamentos.academias.darDeBajaMiembro', [$division->id, $departamento->id, $academia->id, $miembro->id]) }}" method="POST">
                                                <div class="btn-group" role="group" aria-label="Acciones miembro">
                                                    {{-- <a name="vermiembro" href="{{route('divisions.departamentos.academias.showMiembro', [$division->id, $departamento->id, $academia->id])}}" role="button" class="btn btn-success">
                                                        <i class="fas fa-eye"></i>
                                                    </a> --}}
                                                    @can('darDeBajaCualquierMiembro', $academia)
                                                        @csrf
                                                        {{-- @method('DELETE') --}}
                                                        <button type="submit" onclick="return confirm('¿Estás seguro que quieres dar de baja al miembro {{$miembro->nombreCompleto}}? Esta acción no eliminará su cuenta de usuario.')" class="btn btn-danger" href="#" role="button" title="Dar de baja">
                                                            <i class="fas fa-user-times" aria-hidden="true"></i>
                                                        </button>
                                                    @endcan
                                                </div>
                                            </form>
                                        </td>
                                    {{-- @endcan --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
@endcan
@endsection
