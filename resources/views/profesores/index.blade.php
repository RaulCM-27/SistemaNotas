@extends('layouts.app')

@section('title', 'Profesores')

@section('content')

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        ✅ {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        ⛔ {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
@endif

<div class="mb-3">
    <!-- Botón que abre el modal -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalCrear">
        ➕ Agregar Profesor
    </button>
</div>

<table id="profesores" class="display" style="width:100%">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Teléfono</th>
            <th>Correo</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($profesores as $profesor)
        <tr>
            <td>{{ $profesor->profesor_id }}</td>
            <td>{{ $profesor->nombre }}</td>
            <td>{{ $profesor->telefono }}</td>
            <td>{{ $profesor->correo }}</td>
            <td>
                <button class="btn btn-sm btn-primary editar-btn"
                    data-id="{{ $profesor->profesor_id }}"
                    data-nombre="{{ $profesor->nombre }}"
                    data-telefono="{{ $profesor->telefono }}"
                    data-correo="{{ $profesor->correo }}"
                    data-bs-toggle="modal"
                    data-bs-target="#modalEditar">

                    <i class="bi bi-pencil-fill"></i> Editar
                </button>

                <button class="btn btn-sm btn-danger" data-id="{{ $profesor->profesor_id }}">
                    <i class="bi bi-trash-fill"></i> Borrar
                </button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Modal Crear -->
<div class="modal fade" id="modalCrear" tabindex="-1" aria-labelledby="modalCrearLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalCrearLabel">
                    <i class="fas fa-user-plus me-2"></i>Nuevo Estudiante
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Formulario -->
            <form id="formCrearProfesor" method="POST" action="{{ route('profesores.store') }}">
                @csrf
                <div class="modal-body">
                    <!-- Fila 1: ID y Nombre -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="profesor_id" class="form-label">
                                <i class="fas fa-id-card me-1"></i>ID Profesor <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="profesor_id" name="profesor_id" required placeholder="Ej: P001">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="nombre" class="form-label">
                                <i class="fas fa-user me-1"></i>Nombre Completo <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="nombre" name="nombre" maxlength="100" required placeholder="Nombre completo del profesor">
                        </div>
                    </div>

                    <!-- Fila 2: Teléfono y Correo -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="telefono" class="form-label">
                                <i class="fas fa-phone me-1"></i>Teléfono <span class="text-danger">*</span>
                            </label>
                            <input type="tel" class="form-control" id="telefono" name="telefono" required placeholder="Número de teléfono">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="correo" class="form-label">
                                <i class="fas fa-envelope me-1"></i>Correo Electrónico <span class="text-danger">*</span>
                            </label>
                            <input type="email" class="form-control" id="correo" name="correo" maxlength="100" required placeholder="correo@ejemplo.com">
                        </div>
                    </div>

                    <!-- Mensaje de campos requeridos -->
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Los campos marcados con <span class="text-danger">*</span> son obligatorios.
                    </div>
                </div>

                <!-- Footer del Modal -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Guardar Profesor
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- Formulario oculto para eliminar -->
<form id="formEliminar" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<!-- Modal Editar -->
<div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalEditarLabel">
                    <i class="fas fa-user-edit me-2"></i>Editar Profesor
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="formEditar" method="POST">
                <div class="modal-body">
                    @csrf
                    @method('PUT')
                    <!-- Campo oculto para el ID original -->
                    <input type="hidden" id="edit_id_original" name="id_original">

                    <!-- Fila 1: ID y Nombre -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_profesor_id" class="form-label">
                                <i class="fas fa-id-card me-1"></i>ID Profesor <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                class="form-control"
                                id="edit_profesor_id"
                                name="profesor_id"
                                required
                                placeholder="Ej: P001">
                            <div class="invalid-feedback">
                                Por favor ingrese un ID valido.
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="edit_nombre" class="form-label">
                                <i class="fas fa-user me-1"></i>Nombre Completo <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                class="form-control"
                                id="edit_nombre"
                                name="nombre"
                                maxlength="100"
                                required
                                placeholder="Nombre completo del profesor">
                            <div class="invalid-feedback">
                                Por favor ingrese el nombre del profesor.
                            </div>
                        </div>
                    </div>

                    <!-- Fila 2: Teléfono y Correo -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_telefono" class="form-label">
                                <i class="fas fa-phone me-1"></i>Teléfono <span class="text-danger">*</span>
                            </label>
                            <input type="tel"
                                class="form-control"
                                id="edit_telefono"
                                name="telefono"
                                required
                                placeholder="Número de teléfono">
                            <div class="invalid-feedback">
                                Por favor ingrese el numero de celular valido.
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="edit_correo" class="form-label">
                                <i class="fas fa-envelope me-1"></i>Correo Electrónico <span class="text-danger">*</span>
                            </label>
                            <input type="email"
                                class="form-control"
                                id="edit_correo"
                                name="correo"
                                maxlength="100"
                                required
                                placeholder="correo@ejemplo.com">
                            <div class="invalid-feedback">
                                Por favor ingrese un correo valido.
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Actualizar Profesor
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#profesores').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
            },
            lengthMenu: [
                [5, 10, 20, 50],
                [5, 10, 20, 50]
            ],
            stripeClasses: ['odd', 'even'],
        });

        $('.editar-btn').click(function() {
            $('#edit_profesor_id').val($(this).data('id'));
            $('#edit_nombre').val($(this).data('nombre'));
            $('#edit_telefono').val($(this).data('telefono'));
            $('#edit_correo').val($(this).data('correo'));
            $('#formEditar').attr('action', '/profesores/' + $(this).data('id'));
        });

        $('.btn-danger').click(function() {
            if (confirm('¿Estás seguro de eliminar este profesor?')) {
                $('#formEliminar').attr('action', '/profesores/' + $(this).data('id')).submit();
            }
        });
    });
</script>


@endsection