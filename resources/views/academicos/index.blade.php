@extends('layouts.app')

@section('title')
    Académicos
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 py-2">
        @include('flash-message')
    </div>

    <div class="col-md-12 py-2">
        <a class="btn btn-primary" href="{{route('academicos.registrar')}}" role="button">
            <i class="fa fa-user-plus" aria-hidden="true"></i>
            <span class="">Registrar académico</span>
        </a>
    </div>


    <div class="col-md-6 py-2">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Buscar" aria-describedby="basic-addon2">
            <span class="input-group-btn">
                <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
            </span>
        </div>
    </div>

    <div class="col-md-4 py-2">
        <select name="sel-columna" id="inputsel-columna" class="form-control">
            <option value="">Buscar por</option>
            @foreach (Schema::getColumnListing('academicos') as $columna)
                <option value="{{$columna}}">{{$columna}}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-12 py-2">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">Grado</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellido Paterno</th>
                        <th scope="col">Apellido Materno</th>
                        <th scope="col">Correo</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($academicos as $academico)
                        <tr>
                            <th scope="row">{{$academico->id}}</td>
                            <td>{{$academico->grado->id}}</td>
                            <td>{{$academico->nombre}}</td>
                            <td>{{$academico->apellido_pat}}</td>
                            <td>{{$academico->apellido_mat}}</td>
                            <td>{{$academico->user ? $academico->user->email : 'N/A'}}</td>
                            <td>
                                <form action="{{ route('academicos.destroy',$academico->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="btn-group" role="group" aria-label="Modificar Academico">
                                        <a name="editarAcademico" id="editarAcademico{{$academico->id}}" class="btn btn-primary" href="{{route('academicos.edit', $academico->id)}}" role="button">
                                            <i class="fas fa-edit" aria-hidden="true"></i>
                                            Editar
                                        </a>
                                        <button type="submit" onclick="return confirm('¿Estás seguro de eliminar al académico {{$academico->id}}? Esta acción también eliminará su cuenta de usuario.')" class="btn btn-danger" href="#" role="button">
                                            <i class="fas fa-trash" aria-hidden="true"></i>
                                            Eliminar
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
