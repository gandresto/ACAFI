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
                    <td>{{ $academia->presidenteActual->gradoNombreCompleto }}</td>
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
@can('viewMiembros', $academia)
    <div class="row">
        <div class="col-md-12 pb-2">
            <h5>
                Miembros de la Academia
            </h5>
        </div>
    </div>
    @can('create', App\Academia::class)
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
                            @foreach ($academia->miembros as $miembro)
                                <tr>
                                    <td>{{$miembro->gradoNombreCompleto}}</td>
                                    <td>{{$miembro->email}}</td>
                                    <td>{{$miembro}}</td>
                                    {{-- @can('create', App\Academia::class) --}}
                                        <td>
                                            {{-- <form action="{{ route('divisions.departamentos.academias.destroy', [$division->id, $departamento->id, $academia->id]) }}" method="POST">
                                                <div class="btn-group" role="group" aria-label="Modificar academia">
                                                    <a name="veracademia" href="{{route('divisions.departamentos.academias.show', [$division->id, $departamento->id, $academia->id])}}" role="button" class="btn btn-success">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @can('update', $academia)
                                                        <a name="editaracademia" id="editaracademia{{$academia->id}}" class="btn btn-primary" href="{{route('divisions.departamentos.academias.edit', [$division->id, $departamento->id, $academia->id])}}" role="button" title="Editar">
                                                            <i class="fas fa-edit" aria-hidden="true"></i>
                                                        </a>
                                                    @endcan
                                                    @can('delete', $academia)
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" onclick="return confirm('¿Estás seguro de eliminar la Academia de {{$academia->nombre}}?')" class="btn btn-danger" href="#" role="button" title="Eliminar">
                                                            <i class="fas fa-trash" aria-hidden="true"></i>
                                                        </button>
                                                    @endcan

                                                </div>
                                            </form> --}}
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
