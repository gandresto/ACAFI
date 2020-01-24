@extends('layouts.app')
@section('title')
    Calendario
@endsection

@section('content')

    @include('flash-message')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xs-12">
                <v-calendar style="height: 600px" locale="{{config('app.locale')}}"></v-calendar>
            </div>
        </div>
    </div>

@endsection
