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
                    <td><a href="{{$division->url}}">{{$division->url}}</a></td>
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
        <strong>
            Departamentos:
        </strong>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="col">Nombre</th>
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
                            <td>{{'placeholder-jefe'/*$departamento->jefe->grado_nombre_completo*/}}</td>
                            {{-- @can('create', App\Academia::class) --}}
                                <td>
                                    <form action="{{ route('departamentos.destroy',$departamento->id) }}" method="POST">
                                        <div class="btn-group" role="group" aria-label="Modificar departamento">
                                            <a name="verdepartamento" href="{{route('departamentos.show',$departamento->id)}}" role="button" class="btn btn-success">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @can('update', $departamento)
                                                <a name="editardepartamento" id="editardepartamento{{$departamento->id}}" class="btn btn-primary" href="{{route('departamentos.edit', $departamento->id)}}" role="button" title="Editar">
                                                    <i class="fas fa-edit" aria-hidden="true"></i>
                                                </a>
                                            @endcan
                                            @can('delete', $departamento)
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('¿Estás seguro de eliminar \'{{$departamento->nombre}}?\'')" class="btn btn-danger" href="#" role="button" title="Eliminar">
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

@endsection
