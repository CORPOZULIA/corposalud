@extends('layouts.dashboard_layout')

@section('titulo', 	Auth::user()->empleado->persona->nombres)

@section('contenido')


@endsection
