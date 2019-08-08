@extends('layouts.app')

@section('title')
    Divisiones
@endsection

@section('content')

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-12 py-2">
            <a class="btn btn-primary" href="{{route('division.create')}}" role="button">
                <i class="fa fa-plus" aria-hidden="true"></i>
                <span class="pl-6">Añadir división</span>
            </a>
        </div>
    </div>
    <hr>
    <div class="row">
        @foreach ($divisiones as $division)
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    {{$division->nombre}}
                </div>
            </div>
        @endforeach

    </div>
@endsection
