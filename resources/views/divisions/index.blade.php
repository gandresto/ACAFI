@extends('layouts.app')

@section('title')
    Divisiones
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            @yield('flash-message')
        </div>
    </div>

    @can('create', App\Division::class)
        <div class="row">
            <div class="col-md-12 py-2">
                <a class="btn btn-primary" href="{{route('divisions.create')}}" role="button">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                    <span class="pl-6">Añadir división</span>
                </a>
            </div>
        </div>
    @endcan
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
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($divisiones as $division)
                                <tr>
                                    <td>{{$division->siglas}}</td>
                                    <td>{{$division->nombre}}</td>
                                    <td>{{$division->jefe->nombreCompleto()}}</td>
                                    <td>
                                        <form action="{{ route('divisions.destroy',$division->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <div class="btn-group" role="group" aria-label="Modificar division">
                                                <a name="editardivision" id="editardivision{{$division->id}}" class="btn btn-primary" href="{{route('divisions.edit', $division->id)}}" role="button" title="Editar">
                                                    <i class="fas fa-edit" aria-hidden="true"></i>
                                                </a>
                                                <button type="submit" onclick="return confirm('¿Estás seguro de eliminar la {{$division->id}}?')" class="btn btn-danger" href="#" role="button" title="Eliminar">
                                                    <i class="fas fa-trash" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
@endsection
