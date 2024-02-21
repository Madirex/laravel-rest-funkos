@php use App\Models\Funko; @endphp
@extends('main')
@section('title', 'Detalles Funko')
@section('content')
    <h1>Detalles del Funko</h1>
    <dl class="row">
        <dt class="col-sm-2">ID:</dt>
        <dd class="col-sm-10">{{ $funko->id }}</dd>
        <dt class="col-sm-2">Nombre:</dt>
        <dd class="col-sm-10">{{ $funko->name }}</dd>
        <dt class="col-sm-2">Descripción:</dt>
        <dd class="col-sm-10">{{ $funko->description }}</dd>
        <dt class="col-sm-2">Precio:</dt>
        <dd class="col-sm-10">{{ $funko->price }}</dd>
        <dt class="col-sm-2">Imagen:</dt>
        <dd class="col-sm-10">
            @if($funko->image != Funko::$IMAGE_DEFAULT)
                <img alt="Imagen del Funko" class="img-fluid" src="{{ asset('storage/' . $funko->image) }}">
            @else
                <img alt="Imagen por defecto" class="img-fluid" src="{{ Funko::$IMAGE_DEFAULT }}">
            @endif
        </dd>
        <dt class="col-sm-2">Stock:</dt>
        <dd class="col-sm-10">{{ $funko->stock }}</dd>
        <dt class="col-sm-2">Categoría:</dt>
        <dd class="col-sm-10">{{ $funko->category->name }}</dd>
    </dl>


    <a class="btn btn-primary" href="{{ route('funkos.index') }}">Volver</a>

@endsection
