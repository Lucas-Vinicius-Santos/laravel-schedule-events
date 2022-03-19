@extends('layouts.main');

@section('title', 'Produtos');

@section('contet')
    @if ($busca != '')
        Busca realizada: {{ $busca }}
    @endif
@endsection
