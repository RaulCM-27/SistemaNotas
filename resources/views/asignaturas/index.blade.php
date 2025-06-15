@extends('layouts.app')

@section('title', 'Asignaturas')

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
        ➕ Agregar Asigntura
    </button>
</div>

<table id="asignaturas" class="display" style="width:100%">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Horas Semanales</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($asignaturas as $asigna)
        <tr>
            <td>{{ $asigna->id_asignatura }}</td>
            <td>{{ $asigna->nombre_asignatura }}</td>
            <td>{{ $asigna->horas_semanales }}</td>
            <td>
                <button class="btn btn-sm btn-primary editar-btn"
                    data-id="{{ $asigna->id_asignatura }}"
                    data-nombre="{{ $asigna->nombre_asignatura }}"
                    data-horas="{{ $asigna->horas_semanales }}"
                    data-bs-toggle="modal"
                    data-bs-target="#modalEditar">

                    <i class="bi bi-pencil-fill"></i> Editar
                </button>

                <button class="btn btn-sm btn-danger" data-id="{{ $asigna->id_asignatura }}">
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
                    <i class="fas fa-user-plus me-2"></i>Nueva Asignatura
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="formCrearAsignatura" method="POST" action="{{ route('asignaturas.store') }}">
                
                <div class="modal-body">
                    @csrf
                
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>⛔ Se encontraron errores:</strong>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <!-- ID Asignatura -->
                    <div class="mb-3">
                        <label for="id_asignatura" class="form-label">
                            <i class="fas fa-id-card me-1"></i>ID Asignatura <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                            class="form-control"
                            id="id_asignatura"
                            name="id_asignatura"
                            maxlength="20"
                            required
                            placeholder="Ej: ASIG001">
                        <div class="invalid-feedback">
                            Por favor ingrese un ID válido.
                        </div>
                    </div>

                    <!-- Nombre Asignatura -->
                    <div class="mb-3">
                        <label for="nombre_asignatura" class="form-label">
                            <i class="fas fa-book-open me-1"></i>Nombre de la Asignatura <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                            class="form-control"
                            id="nombre_asignatura"
                            name="nombre_asignatura"
                            maxlength="100"
                            required
                            placeholder="Ej: Matemáticas">
                        <div class="invalid-feedback">
                            Este campo es obligatorio.
                        </div>
                    </div>

                    <!-- Horas Semanales -->
                    <div class="mb-3">
                        <label for="horas_semanales" class="form-label">
                            <i class="fas fa-clock me-1"></i>Horas Semanales <span class="text-danger">*</span>
                        </label>
                        <input type="number"
                            class="form-control"
                            id="horas_semanales"
                            name="horas_semanales"
                            min="1"
                            required
                            placeholder="Ej: 4">
                        <div class="invalid-feedback">
                            Ingrese un número válido de horas.
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Guardar Asignatura
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
                    <i class="fas fa-user-edit me-2"></i>Editar Asignatura
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="formEditar" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <!-- ID Asignatura (solo lectura) -->
                    <div class="mb-3">
                        <label for="edit_id_asignatura" class="form-label">
                            <i class="fas fa-id-card me-1"></i>ID Asignatura
                        </label>
                        <input type="text"
                            class="form-control"
                            id="edit_id_asignatura"
                            name="id_asignatura"
                            readonly>
                    </div>

                    <!-- Nombre Asignatura -->
                    <div class="mb-3">
                        <label for="edit_nombre_asignatura" class="form-label">
                            <i class="fas fa-book-open me-1"></i>Nombre de la Asignatura <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                            class="form-control"
                            id="edit_nombre_asignatura"
                            name="nombre_asignatura"
                            required>
                    </div>

                    <!-- Horas Semanales -->
                    <div class="mb-3">
                        <label for="edit_horas_semanales" class="form-label">
                            <i class="fas fa-clock me-1"></i>Horas Semanales <span class="text-danger">*</span>
                        </label>
                        <input type="number"
                            class="form-control"
                            id="edit_horas_semanales"
                            name="horas_semanales"
                            min="1"
                            required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@if ($errors->any())
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var modalCrear = new bootstrap.Modal(document.getElementById('modalCrear'));
        modalCrear.show();
    });
</script>
@endif

<script>
    $(document).ready(function() {
        $('#asignaturas').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
            },
            lengthMenu: [
                [5, 10, 20, 50],
                [5, 10, 20, 50]
            ],
            stripeClasses: ['odd', 'even'],
        });

        $('.btn-danger').click(function() {
            if (confirm('¿Estás seguro de eliminar esta asignatura?')) {
                $('#formEliminar').attr('action', '/asignaturas/' + $(this).data('id')).submit();
            }
        });

        $('.editar-btn').click(function() {
            $('#edit_id_asignatura').val($(this).data('id'));
            $('#edit_nombre_asignatura').val($(this).data('nombre'));
            $('#edit_horas_semanales').val($(this).data('horas'));
            $('#formEditar').attr('action', '/asignaturas/' + $(this).data('id'));
        });
    });
</script>

@endsection