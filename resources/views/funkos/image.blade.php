@php use App\Models\Funko; @endphp
@extends('main')
@section('title', 'Editar imagen de Funko')

@section('content')
    <h1>Editar imagen de Funko</h1>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <br/>
    @endif

    <dl class="row">
        <dt class="col-sm-2">ID:</dt>
        <dd class="col-sm-10">{{$funko->id}}</dd>
        <dt class="col-sm-2">Nombre:</dt>
        <dd class="col-sm-10">{{$funko->name}}</dd>
        <dt class="col-sm-2">Imagen:</dt>
        <dd class="col-sm-10">
            @if($funko->image != Funko::$IMAGE_DEFAULT)
                <img alt="Imagen del Funko" class="img-fluid" src="{{ asset('storage/' . $funko->image) }}">
            @else
                <img alt="Imagen por defecto" class="img-fluid" src="{{ Funko::$IMAGE_DEFAULT }}">
            @endif
        </dd>
    </dl>

    <form action="{{ route("funkos.updateImage", $funko->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="form-group">
            <label for="image">Imagen:</label>
            <input accept="image/*" class="form-control-file" id="image" name="image" required type="file">
            <small class="text-danger"></small>
        </div>

        <button class="btn btn-primary" type="submit">Actualizar</button>
        <a class="btn btn-secondary mx-2" href="{{ route('funkos.index') }}">Volver</a>
    </form>

@endsection
