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
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Categoría</th>
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
                        <a class="btn btn-primary btn-sm" style="width:100px; margin-bottom: 10px"
                           href="{{ route('funkos.show', $funko->id) }}">Detalles</a>
                        <?php if(auth()->check() && auth()->user()->hasRole('admin')): ?>
                        <a class="btn btn-secondary btn-sm" style="width:100px; margin-bottom: 10px"
                           href="{{ route('funkos.edit', $funko->id) }}">Editar</a>
                        <br/>
                        <a class="btn btn-info  btn-sm" style="width:100px; margin-bottom: 10px"
                           href="{{ route('funkos.editImage', $funko->id) }}">Imagen</a>


                        <!-- Botón Eliminar con el modal correspondiente -->
                        <a class="btn btn-danger btn-sm delete-btn" style="width: 100px; margin-bottom: 10px" data-toggle="modal" data-target="#confirmDeleteModal{{ $funko->id }}">Eliminar</a>

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

                        <?php endif; ?>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

      {{--Si no hay Funkos mostramos el mensaje--}}
    @else
        <p class='lead'><em>No se han encontrado Funkos.</em></p>
    @endif

    <div class="pagination-container">
        {{ $funkos->links('pagination::bootstrap-4') }}
    </div>

    <?php if(auth()->check() && auth()->user()->hasRole('admin')): ?>
    <a class="btn btn-success" href={{ route('funkos.create') }}>Nuevo Funko</a>
    <?php endif; ?>

@endsection
