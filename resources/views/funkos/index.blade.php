@php use App\Models\Funko; @endphp
@extends('main')
@section('title', 'Funkos CRUD')
@section('content')
    <h1>Listado de Funkos</h1>
    <form action="{{ route('funkos.index') }}" class="mb-3" method="get">
        @csrf
        <div class="input-group">
            <input type="text" class="form-control" id="search" name="search" placeholder="Nombre">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">Buscar</button>
            </div>
        </div>
    </form>

    {{-- Si hay registros --}}
    @if (count($funkos) > 0)
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>

            {{-- Por cada funko --}}
            @foreach ($funkos as $funko)
                <tr>
                    <td>{{ $funko->id }}</td>
                    <td>{{ $funko->name }}</td>
                    <td>{{ $funko->description }}</td>
                    <td>{{ $funko->price }}</td>
                    <td>{{ $funko->stock }}</td>
                    <td>{{ $funko->category_name }}</td>
                    <td>
                        @if($funko->image != Funko::$IMAGE_DEFAULT)
                            <img alt="Imagen del Funko" height="50" src="{{ asset('storage/' . $funko->image) }}"
                                 width="50">
                        @else
                            <img alt="Imagen por defecto" height="50" src="{{ Funko::$IMAGE_DEFAULT }}"
                                 width="50">
                        @endif
                    </td>
                    <td>
                        <a class="btn btn-primary btn-sm"
                           href="{{ route('funkos.show', $funko->id) }}">Detalles</a>
                        <?php if(auth()->check() && auth()->user()->isAdmin()): ?>
                        <a class="btn btn-secondary btn-sm"
                           href="{{ route('funkos.edit', $funko->id) }}">Editar</a>
                        <a class="btn btn-info  btn-sm"
                           href="{{ route('funkos.editImage', $funko->id) }}">Imagen</a>
                        <form action="{{ route('funkos.destroy', $funko->id) }}" method="POST"
                              style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('¿Estás seguro de que deseas borrar este Funko?')">Borrar
                            </button>
                        </form>
                        <?php endif; ?>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

      {{--Si no hay funkos mostramos el mensaje--}}
    @else
        <p class='lead'><em>No se han encontrodo Funkos.</em></p>
    @endif

    <div class="pagination-container">
        {{ $funkos->links('pagination::bootstrap-4') }}
    </div>

    <?php if(auth()->check() && auth()->user()->isAdmin()): ?>
    <a class="btn btn-success" href={{ route('funkos.create') }}>Nuevo Funko</a>
    <?php endif; ?>

@endsection
