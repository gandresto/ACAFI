@extends('layouts.app')

@section('title')
    Académicos
@endsection

@section('content')
<div class="row">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

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
        <div class="table-responsive-lg">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Grado</th>
                        <th>Nombre</th>
                        <th>Apellido Paterno</th>
                        <th>Apellido Materno</th>
                        <th>Correo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($academicos as $academico)
                        <tr>
                            <td>{{$academico->id}}</td>
                            <td>{{$academico->grado->id}}</td>
                            <td>{{$academico->nombre}}</td>
                            <td>{{$academico->apellido_pat}}</td>
                            <td>{{$academico->apellido_mat}}</td>
                            <td>{{$academico->user ? $academico->user->email : 'N/A'}}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Modificar Academico">
                                        <a name="editarAcademico" id="editarAcademico{{$academico->id}}" class="btn btn-primary" href="#" role="button">Editar</a>
                                        <a name="eliminarAcademico" id="eliminarAcademico{{$academico->id}}" class="btn btn-danger" href="#" role="button">Eliminar</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
