@extends('layouts.app')

@section('title')
    {{$division->siglas . ' - ' . $division->nombre}}
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        {{$division->nombre}}
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-12">
        Departamentos:
    </div>
    @foreach ($division->departamentos as $departamento)
        <div class="col-md-12">
            {{$departamento->nombre}}
        </div>
    @endforeach
    
</div>
    
@endsection
