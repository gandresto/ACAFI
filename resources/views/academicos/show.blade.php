@extends('layouts.app')

@section('title')
    {{$academico->nombre}}
@endsection

@section('content')

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    You are logged in!

@endsection
