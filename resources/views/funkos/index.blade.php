@php use App\Models\Funko; @endphp
@extends('main')
@section('title', 'Funkos CRUD')
@section('content')
    <br/>
    <h1>Listado de Funkos</h1>
    <form action="{{ route('funkos.index') }}" class="mb-3" method="get">
        @csrf
        <div class="input-group">
            <input type="text" class="form-control" id="search" name="search" placeholder="Nombre">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
            </div>
        </div>
    </form>

    {{-- Si hay registros --}}
    @if (count($funkos) > 0)
        <div class="funko-container">
            {{-- Por cada funko --}}
            {{-- Por cada funko --}}
            @foreach ($funkos as $funko)
                <a href="{{ route('funkos.show', $funko->id) }}" class="funko-link">
                    <div class="funko-card">
                        <img class="funko-image" src="{{ $funko->image != Funko::$IMAGE_DEFAULT ? asset('storage/' . $funko->image) : Funko::$IMAGE_DEFAULT }}" alt="Imagen del Funko" onerror="this.onerror=null; this.src='http://localhost/images/funkos.bmp';">
                        <h2 class="funko-name">{{ $funko->name }}</h2>
                        <p class="funko-description">{{ $funko->description }}</p>
                        <p class="funko-price">{{ $funko->price }}</p>
                        <p class="funko-stock">{{ $funko->stock }}</p>
                        <p class="funko-category">{{ $funko->category_name }}</p>
                        <div class="funko-actions">
                            <a class="btn btn-primary btn-sm" href="{{ route('funkos.show', $funko->id) }}"><i class="fas fa-info-circle"></i></a>
                            @if(auth()->check() && auth()->user()->hasRole('admin'))
                                <a class="btn btn-secondary btn-sm" href="{{ route('funkos.edit', $funko->id) }}"><i class="fas fa-edit"></i></a>
                                <a class="btn btn-info btn-sm" href="{{ route('funkos.editImage', $funko->id) }}"><i class="fas fa-image"></i></a>
                                <a class="btn btn-danger btn-sm delete-btn" data-toggle="modal" data-target="#confirmDeleteModal{{ $funko->id }}"><i class="fas fa-trash-alt"></i></a>
                            @endif
                        </div>
                    </div>
                </a>

                <!-- Modal de Confirmación de eliminación -->
                <div class="modal fade" id="confirmDeleteModal{{ $funko->id }}" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Eliminación</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                ¿Estás seguro de que deseas eliminar este elemento?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>

                                <!-- Formulario para eliminar el elemento -->
                                <form action="{{ route('funkos.destroy', $funko->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Borrar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class='lead'><em>No se han encontrado Funkos.</em></p>
    @endif

    <div class="pagination-container">
        {{ $funkos->links('pagination::bootstrap-4') }}
    </div>

    @if(auth()->check() && auth()->user()->hasRole('admin'))
        <a class="btn btn-success" href={{ route('funkos.create') }}><i class="fas fa-plus"></i></a>
    @endif

@endsection
