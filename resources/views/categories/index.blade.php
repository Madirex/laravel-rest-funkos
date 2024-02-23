@php use App\Models\Category; @endphp
@extends('main')
@section('title', 'Categorías CRUD')
@section('content')
    <br/>
    <h1>Listado de categorías</h1>
    <form action="{{ route('categories.index') }}" class="mb-3" method="get">
        @csrf
        <div class="input-group">
            <input type="text" class="form-control" id="search" name="search" placeholder="Nombre">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">Buscar</button>
            </div>
        </div>
    </form>

    {{-- Si hay registros --}}
    @if (count($categories) > 0)
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Fecha de creación</th>
                <th>Fecha de actualización</th>
            </tr>
            </thead>
            <tbody>

            {{-- Por cada category --}}
            @foreach ($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->created_at }}</td>
                    <td>{{ $category->updated_at }}</td>
                    <td>
                        <a class="btn btn-primary btn-sm" style="width:100px; margin-bottom: 10px"
                           href="{{ route('categories.show', $category->id) }}">Detalles</a>
                            <?php if (auth()->check() && auth()->user()->hasRole('admin')): ?>
                        <br/>
                        <a class="btn btn-secondary btn-sm" style="width:100px; margin-bottom: 10px"
                           href="{{ route('categories.edit', $category->id) }}">Editar</a>
                        <br/>
                        <!-- Botón Eliminar con el modal correspondiente -->
                        <a class="btn btn-danger btn-sm delete-btn" style="width: 100px; margin-bottom: 10px"
                           data-toggle="modal" data-target="#confirmDeleteModal{{ $category->id }}">Eliminar</a>

                        <!-- Modal de Confirmación de eliminación -->
                        <div class="modal fade" id="confirmDeleteModal{{ $category->id }}" tabindex="-1" role="dialog"
                             aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
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
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar
                                        </button>

                                        <!-- Formulario para eliminar el elemento -->
                                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST"
                                              style="display: inline;">
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

        {{--Si no hay categorías mostramos el mensaje--}}
    @else
        <p class='lead'><em>No se han encontrado categorías.</em></p>
    @endif

    <div class="pagination-container">
        {{ $categories->links('pagination::bootstrap-4') }}
    </div>

    <?php if (auth()->check() && auth()->user()->hasRole('admin')): ?>
    <a class="btn btn-success" href={{ route('categories.create') }}>Nueva categoría</a>
    <?php endif; ?>

@endsection
