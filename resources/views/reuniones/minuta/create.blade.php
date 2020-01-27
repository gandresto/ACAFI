@extends('layouts.app')

@section('title')
    Crear minuta
@endsection

@section('content')
    {{$reunion}} <br>
    {{$reunion->inicio}} <br>
    {{$reunion->fin}} <br>
    {{$reunion->lugar}} <br>
    {{$reunion->academia}} <br>
@endsection