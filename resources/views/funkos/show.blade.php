@php use App\Models\Funko; @endphp
@extends('main')
@section('title', 'Detalles Funko')
@section('content')
    <h1>Detalles del Funko</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title"><i class="fas fa-tag"></i> {{ $funko->name }}</h5>
            <p class="card-text"><i class="fas fa-info-circle"></i> Descripción: {{ $funko->description }}</p>
            <p class="card-text"><i class="fas fa-dollar-sign"></i> Precio: {{ $funko->price }}</p>
            <p class="card-text"><i class="fas fa-image"></i> Imagen:
                @if($funko->image != Funko::$IMAGE_DEFAULT)
                    <img alt="Imagen del Funko" class="img-fluid funko-image" src="{{ asset('storage/' . $funko->image) }}">
                @else
                    <img alt="Imagen por defecto" class="img-fluid funko-image" src="{{ Funko::$IMAGE_DEFAULT }}">
                @endif
            </p>
            <p class="card-text"><i class="fas fa-layer-group"></i> Stock: {{ $funko->stock }}</p>
            <p class="card-text"><i class="fas fa-folder-open"></i> Categoría: {{ $funko->category_name }}</p>
        </div>
    </div>

    <br/>

    <a class="btn btn-primary" href="{{ route('funkos.index') }}"><i class="fas fa-arrow-left"></i> Volver</a>

@endsection
