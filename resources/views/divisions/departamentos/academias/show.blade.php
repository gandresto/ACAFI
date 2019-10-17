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
@endsection
