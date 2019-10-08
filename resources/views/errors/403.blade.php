@extends('errors::minimal')

@section('title', 'Prohibido')
@section('code', '403')
@section('message', 'No tienes autorización para ver esta página.' ?: 'Prohibido'))
