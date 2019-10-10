@extends('layouts.app')

@section('title')
    {{$division->siglas . ' - ' . $division->nombre}}
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12 col-md-8">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td scope="row">Siglas</td>
                    <td>{{$division->siglas}}</td>
                </tr>
                <tr>
                    <td scope="row">Nombre</td>
                    <td>{{$division->nombre}}</td>
                </tr>
                <tr>
                    <td scope="row">Sitio web</td>
                    <td>
                        <a href="{{$division->url}}" target="_blank">
                            <div class="float-left">
                                <span>
                                    {{$division->url}}
                                </span>
                            </div>
                            <div class="float-right">
                                <i class="fas fa-external-link-alt" ></i>
                            </div>
                            <div class="clearfix"></div>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td scope="row">Jefe de División</td>
                    <td>{{$division->jefe_actual->grado_nombre_completo}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-12 pb-2">
        <h5>
            Departamentos
            {{-- <a href="{{route('divisions.departamentos.index', $division->id)}}">Departamentos:</a> --}}
        </h5>
    </div>
</div>
@can('create', App\Departamento::class)
    <div class="row">
        <div class="col-md-12 py-2">
            <a class="btn btn-primary" href="{{route('divisions.departamentos.create', $division->id)}}" role="button">
                <i class="fa fa-plus" aria-hidden="true"></i>
                <span class="ml-2">Añadir departamento</span>
            </a>
        </div>
    </div>
@endcan

{{-- Barra de búsqueda próximamente aquí --}}

<hr>
<div class="row">
    <div class="col-md-12">
        @include('flash-message')
    </div>
</div>

@if ($division->departamentos->isEmpty())
    <div class="row">
        <div class="col-sm-12">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <strong>Esta división no tiene departamentos registrados</strong>
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
                            <th scope="col">Departamento</th>
                            <th scope="col">Jefe</th>
                            {{-- @can('create', App\Academia::class) --}}
                                <th scope="col">Acciones</th>
                            {{-- @endcan --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($division->departamentos as $departamento)
                            <tr>
                                <td>{{$departamento->nombre}}</td>
                                <td>{{$departamento->jefeActual->grado_nombre_completo}}</td>
                                {{-- @can('create', App\Academia::class) --}}
                                    <td>
                                        <form action="{{ route('divisions.departamentos.destroy', [$division->id, $departamento->id]) }}" method="POST">
                                            <div class="btn-group" role="group" aria-label="Modificar departamento">
                                                <a name="verdepartamento" href="{{route('divisions.departamentos.show', [$division->id, $departamento->id])}}" role="button" class="btn btn-success">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @can('update', $departamento)
                                                    <a name="editardepartamento" id="editardepartamento{{$departamento->id}}" class="btn btn-primary" href="{{route('divisions.departamentos.edit', [$division->id, $departamento->id])}}" role="button" title="Editar">
                                                        <i class="fas fa-edit" aria-hidden="true"></i>
                                                    </a>
                                                @endcan
                                                @can('delete', $departamento)
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('¿Estás seguro de eliminar el Departemento de \'{{$departamento->nombre}}?\'')" class="btn btn-danger" href="#" role="button" title="Eliminar">
                                                        <i class="fas fa-trash" aria-hidden="true"></i>
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
@endsection
