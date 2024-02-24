@php use App\Models\Category; @endphp
@extends('main')
@section('title', 'Detalles de la categoría')
@section('content')
    <h1>Detalles de la categoría</h1>
    <dl class="row">
        <dt class="col-sm-2">Nombre:</dt>
        <dd class="col-sm-10">{{ $category->name }}</dd>
        <dt class="col-sm-2">Fecha de creación:</dt>
        <dd class="col-sm-10">{{ $category->created_at }}</dd>
        <dt class="col-sm-2">Fecha de actualización:</dt>
        <dd class="col-sm-10">{{ $category->updated_at }}</dd>
    </dl>

    <a class="btn btn-primary" href="{{ route('categories.index') }}">Volver</a>

@endsection
