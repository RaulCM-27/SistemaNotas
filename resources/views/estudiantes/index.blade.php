@extends('layouts.app')

@section('title', 'Estudiantes')

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
        ➕ Agregar Estudiante
    </button>
</div>

<table id="estudiantes" class="display" style="width:100%">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Edad</th>
            <th>Direccion</th>
            <th>Telefono</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($estudiantes as $estu)
        <tr>
            <td>{{ $estu->estudiante_id }}</td>
            <td>{{ $estu->nombre_estudiante }}</td>
            <td>{{ $estu->edad }}</td>
            <td>{{ $estu->direccion }}</td>
            <td>{{ $estu->telefono }}</td>
            <td class="text-left">
                @if($estu->estado == 1)
                <span class="badge bg-success">
                    <i class="fas fa-check-circle me-1"></i>Activo
                </span>
                @else
                <span class="badge bg-danger">
                    <i class="fas fa-times-circle me-1"></i>Inactivo
                </span>
                @endif
            </td>
            <td>
                <button class="btn btn-sm btn-primary editar-btn"
                    data-id="{{ $estu->estudiante_id }}"
                    data-nombre="{{ $estu->nombre_estudiante }}"
                    data-edad="{{ $estu->edad }}"
                    data-telefono="{{ $estu->telefono }}"
                    data-direccion="{{ $estu->direccion }}"
                    data-estado="{{ $estu->estado }}"
                    data-bs-toggle="modal"
                    data-bs-target="#modalEditar">

                    <i class="bi bi-pencil-fill"></i> Editar
                </button>

                <button class="btn btn-sm btn-danger" data-id="{{ $estu->estudiante_id }}">
                    <i class="bi bi-trash-fill"></i> Borrar
                </button>
            </td>
        </tr>
        <!-- Agrega más filas aquí -->
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

            <form id="formCrearEstudiante" method="POST" action="{{ route('estudiantes.store') }}">
                <div class="modal-body">
                    @csrf

                    <div class="row">
                        <!-- ID Estudiante -->
                        <div class="col-md-6 mb-3">
                            <label for="estudiante_id" class="form-label">
                                <i class="fas fa-id-card me-1"></i>ID Estudiante <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                class="form-control"
                                id="estudiante_id"
                                name="estudiante_id"
                                maxlength="20"
                                required
                                placeholder="Ej: EST001">
                            <div class="invalid-feedback">
                                Por favor ingrese un ID válido.
                            </div>
                        </div>

                        <!-- Nombre -->
                        <div class="col-md-6 mb-3">
                            <label for="nombre_estudiante" class="form-label">
                                <i class="fas fa-user me-1"></i>Nombre Completo <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                class="form-control"
                                id="nombre_estudiante"
                                name="nombre_estudiante"
                                maxlength="100"
                                required
                                placeholder="Nombre completo del estudiante">
                            <div class="invalid-feedback">
                                Por favor ingrese el nombre del estudiante.
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Edad -->
                        <div class="col-md-6 mb-3">
                            <label for="edad" class="form-label">
                                <i class="fas fa-calendar-alt me-1"></i>Edad <span class="text-danger">*</span>
                            </label>
                            <input type="number"
                                class="form-control"
                                id="edad"
                                name="edad"
                                min="1"
                                max="100"
                                required
                                placeholder="Edad en años">
                            <div class="invalid-feedback">
                                Por favor ingrese una edad válida (1-100).
                            </div>
                        </div>

                        <!-- Teléfono -->
                        <div class="col-md-6 mb-3">
                            <label for="telefono" class="form-label">
                                <i class="fas fa-phone me-1"></i>Teléfono
                            </label>
                            <input type="tel"
                                class="form-control"
                                id="telefono"
                                name="telefono"
                                placeholder="Número de teléfono">
                            <div class="invalid-feedback">
                                Por favor ingrese un número de teléfono válido.
                            </div>
                        </div>
                    </div>

                    <!-- Dirección -->
                    <div class="mb-3">
                        <label for="direccion" class="form-label">
                            <i class="fas fa-map-marker-alt me-1"></i>Dirección
                        </label>
                        <textarea class="form-control"
                            id="direccion"
                            name="direccion"
                            rows="3"
                            maxlength="100"
                            placeholder="Dirección completa del estudiante"></textarea>
                        <div class="form-text">Campo opcional. Máximo 100 caracteres.</div>
                    </div>

                    <!-- Estado -->
                    <div class="mb-3">
                        <label for="estado" class="form-label">
                            <i class="bi-toggle-on"></i>Estado
                        </label>
                        <select class="form-select" id="estado" name="estado">
                            <option value="1" selected>Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>

                    <!-- Campos requeridos -->
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Los campos marcados con <span class="text-danger">*</span> son obligatorios.
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Guardar Estudiante
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
                    <i class="fas fa-user-edit me-2"></i>Editar Estudiante</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="formEditar" method="POST">
                <div class="modal-body">
                    @csrf
                    @method('PUT')
                    <!-- Campo oculto para el ID original -->
                    <input type="hidden" id="edit_id_original" name="id_original">

                    <div class="row">
                        <!-- ID Estudiante -->
                        <div class="col-md-6 mb-3">
                            <label for="edit_estudiante_id" class="form-label">
                                <i class="fas fa-id-card me-1"></i>ID Estudiante <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                class="form-control"
                                id="edit_estudiante_id"
                                name="estudiante_id"
                                maxlength="20"
                                required
                                placeholder="Ej: EST001">
                            <div class="invalid-feedback">
                                Por favor ingrese un ID válido.
                            </div>
                        </div>

                        <!-- Nombre -->
                        <div class="col-md-6 mb-3">
                            <label for="edit_nombre_estudiante" class="form-label">
                                <i class="fas fa-user me-1"></i>Nombre Completo <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                class="form-control"
                                id="edit_nombre_estudiante"
                                name="nombre_estudiante"
                                maxlength="100"
                                required
                                placeholder="Nombre completo del estudiante">
                            <div class="invalid-feedback">
                                Por favor ingrese el nombre del estudiante.
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Edad -->
                        <div class="col-md-6 mb-3">
                            <label for="edit_edad" class="form-label">
                                <i class="fas fa-calendar-alt me-1"></i>Edad <span class="text-danger">*</span>
                            </label>
                            <input type="number"
                                class="form-control"
                                id="edit_edad"
                                name="edad"
                                min="1"
                                max="100"
                                required
                                placeholder="Edad en años">
                            <div class="invalid-feedback">
                                Por favor ingrese una edad válida (1-100).
                            </div>
                        </div>

                        <!-- Teléfono -->
                        <div class="col-md-6 mb-3">
                            <label for="edit_telefono" class="form-label">
                                <i class="fas fa-phone me-1"></i>Teléfono
                            </label>
                            <input type="tel"
                                class="form-control"
                                id="edit_telefono"
                                name="telefono"
                                placeholder="Número de teléfono">
                            <div class="invalid-feedback">
                                Por favor ingrese un número de teléfono válido.
                            </div>
                        </div>
                    </div>

                    <!-- Dirección -->
                    <div class="mb-3">
                        <label for="edit_direccion" class="form-label">
                            <i class="fas fa-map-marker-alt me-1"></i>Dirección
                        </label>
                        <textarea class="form-control"
                            id="edit_direccion"
                            name="direccion"
                            rows="3"
                            maxlength="100"
                            placeholder="Dirección completa del estudiante"></textarea>
                        <div class="form-text">Campo opcional. Máximo 100 caracteres.</div>
                    </div>

                    <!-- Estado -->
                    <div class="mb-3">
                        <label for="edit_estado" class="form-label">
                            <i class="bi-toggle-on"></i>Estado
                        </label>
                        <select class="form-select" id="edit_estado" name="estado">
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>

                    <!-- Campos requeridos -->
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Los campos marcados con <span class="text-danger">*</span> son obligatorios.
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Actualizar Estudiante
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@if ($errors->any())
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var modalCrear = new bootstrap.Modal(document.getElementById('modalCrear'));
        modalCrear.show();
    });
</script>
@endif

<script>
    $(document).ready(function() {
        $('#estudiantes').DataTable({
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
            $('#edit_estudiante_id').val($(this).data('id'));
            $('#edit_nombre_estudiante').val($(this).data('nombre'));
            $('#edit_edad').val($(this).data('edad'));
            $('#edit_telefono').val($(this).data('telefono'));
            $('#edit_direccion').val($(this).data('direccion'));
            $('#edit_estado').val($(this).data('estado'));
            $('#formEditar').attr('action', '/estudiantes/' + $(this).data('id'));
        });

        $('.btn-danger').click(function() {
            if (confirm('¿Estás seguro de eliminar este estudiante?')) {
                $('#formEliminar').attr('action', '/estudiantes/' + $(this).data('id')).submit();
            }
        });

    });
</script>

@endsection