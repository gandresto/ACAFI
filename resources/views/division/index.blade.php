@extends('layouts.app')

@section('title')
    Divisiones
@endsection

@section('content')

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <a type="button" class="btn btn-primary" href="{{route('division.create')}}">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        <span class="pl-6">Añadir división</span>                                        
                </a>
            </div>                            
        </div> 
        <hr>
        @foreach ($divisiones as $division)
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    {{$division->nombre}}
                </div>                            
            </div>                        
        @endforeach
    </div>
                    
@endsection
