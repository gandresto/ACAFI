@extends('layouts.app')

@section('title')
    Departamentos
@endsection

@section('content')

<div class="row">
    <div class="col-sm-12">
        @include('flash-message')
    </div>
</div>

@can('create', App\Departamento::class)
    <div class="row">
        <div class="col-md-12 py-2">
            <a class="btn btn-primary" href="{{route('departamentos.create')}}" role="button">
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
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="col">División</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Jefe</th>
                        {{-- @can('create', App\Academia::class) --}}                        
                            <th scope="col">Acciones</th>
                        {{-- @endcan --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($departamentos as $departamento)
                        <tr>
                            <td>{{$departamento->division->siglas}}</td>
                            <td>{{$departamento->nombre}}</td>
                            <td>{{$departamento->jefe->nombreCompletoG()}}</td>
                            {{-- @can('create', App\Academia::class) --}}  
                                <td>
                                    <form action="{{ route('departamentos.destroy',$departamento->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="btn-group" role="group" aria-label="Modificar departamento">
                                            @can('update', $departamento)
                                                <a name="editardepartamento" id="editardepartamento{{$departamento->id}}" class="btn btn-primary" href="{{route('departamentos.edit', $departamento->id)}}" role="button" title="Editar">
                                                    <i class="fas fa-edit" aria-hidden="true"></i>
                                                </a>
                                            @endcan
                                            @can('delete', $departamento)
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

<div class="row">
    <div class="col-sm-12">
        {{$departamentos->links()}}
    </div>
</div>

@endsection
