@extends('layouts.app')

@section('title')
    {{$division->siglas . ' - ' . $division->nombre}}
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        Nombre: {{$division->nombre}}
    </div>
    <div class="col-md-12">
        Jefe: {{$division->jefe->nombreCompletoG()}}
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-12">
        Departamentos:
    </div>

    
</div>

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
                        @foreach ($division->departamentos as $departamento)
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
    
@endsection
