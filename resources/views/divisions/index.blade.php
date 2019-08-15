@extends('layouts.app')

@section('title')
    Divisiones
@endsection

@section('content')

<div class="row">
    <div class="col-sm-12">
        @include('flash-message')
    </div>
</div>

@can('create', App\Division::class)
    <div class="row">
        <div class="col-md-12 py-2">
            <a class="btn btn-primary" href="{{route('divisions.create')}}" role="button">
                <i class="fa fa-plus" aria-hidden="true"></i>
                <span class="ml-2">Añadir división</span>
            </a>
        </div>
    </div>
@endcan

{{-- Barra de búsqueda próximamente aquí --}}

<hr>

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="col">Siglas</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Jefe</th>
                        @can('create', App\Division::class)
                            <th scope="col">Acciones</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach ($divisiones as $division)
                        <tr>
                            <th scope="row">{{$division->siglas}}</th>
                            <td>{{$division->nombre}}</td>
                            <td>{{$division->jefe->grado_nombre_completo}}</td>
                            @can('create', App\Division::class)
                                <td>
                                    <form action="{{ route('divisions.destroy', $division->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="btn-group" role="group" aria-label="Modificar division">
                                            <a name="editardivision" id="editardivision{{$division->id}}" class="btn btn-primary" href="{{route('divisions.edit', $division->id)}}" role="button" title="Editar">
                                                <i class="fas fa-edit" aria-hidden="true"></i>
                                            </a>
                                            <button type="submit" onclick="return confirm('¿Estás seguro de eliminar \'{{$division->nombre}}?\'')" class="btn btn-danger" href="#" role="button" title="Eliminar">
                                                <i class="fas fa-trash" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </form>
                                </td>
                            @endcan
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        {{$divisiones->links()}}
    </div>
</div>

@endsection
