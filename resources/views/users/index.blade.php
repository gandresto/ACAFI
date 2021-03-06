@extends('layouts.app')

@section('title')
    Usuarios
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        @include('flash-message')
    </div>
</div>
@can('create', App\User::class)
    <div class="row">
        <div class="col-md-12">
            <a class="btn btn-primary" href="{{route('users.create')}}" role="button">
                <i class="fa fa-user-plus" aria-hidden="true"></i>
                <span class="">Registrar usuario</span>
            </a>
        </div>
    </div>
@endcan
<hr>

{{--
-- Barra de búsqueda aún no lista para implementación --
--}}
<div class="row">
    <div class="col-sm-12">
        {{$users->links()}}
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Grado</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellido Paterno</th>
                        <th scope="col">Apellido Materno</th>
                        <th scope="col">Correo</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <th scope="row">{{$user->id}}</td>
                            <td>{{$user->grado}}</td>
                            <td>{{$user->nombre}}</td>
                            <td>{{$user->apellido_paterno}}</td>
                            <td>{{$user->apellido_materno}}</td>
                            <td>{{$user->email}}</td>
                            <td>
                                <form action="{{ route('users.destroy',$user->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="btn-group" role="group" aria-label="Modificar Usuario">
                                        <a name="veruser" href="{{route('users.show',$user->id)}}" role="button" class="btn btn-success">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a name="editarUsuario" id="editarUsuario{{$user->id}}" class="btn btn-primary" href="{{route('users.edit', $user->id)}}" role="button" title="Editar">
                                            <i class="fas fa-edit" aria-hidden="true"></i>
                                        </a>
                                        <button type="submit" onclick="return confirm('¿Estás seguro de eliminar al usuario con nombre \'{{$user->nombre_completo}}?\'')" class="btn btn-danger" href="#" role="button" title="Eliminar">
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

<div class="row">
    <div class="col-sm-12">
        {{$users->links()}}
    </div>
</div>



@endsection
