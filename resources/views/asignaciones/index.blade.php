@extends('layouts.app')

@section('title', 'Crear Asignacion')

@section('content')
<div class="mb-3">
    <!-- Botón que abre el modal -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalCrear">
        ➕ Agregar Asignaciones
    </button>
</div>

<!-- Tabla de asignaciones -->
<table id="asignaciones" class="display" style="width:100%">
    <thead>
        <tr>
            <th>ID</th>
            <th>Profesor</th>
            <th>Asignatura</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($asignaciones as $item)
        <tr>
            <td>{{ $item->id }}</td>
            <td>{{ $item->profesor->nombre ?? 'N/D' }}</td>
            <td>{{ $item->asignatura->nombre_asignatura ?? 'N/D' }}</td>
            <td>
                <!-- Botón Editar -->
                <button class="btn btn-sm btn-primary editar-btn"
                    data-id="{{ $item->id }}"
                    data-profesor="{{ $item->profesor_id }}"
                    data-asignatura="{{ $item->id_asignatura }}"
                    data-bs-toggle="modal"
                    data-bs-target="#modalEditar">
                    <i class="bi bi-pencil-fill"></i> Editar
                </button>

                <button class="btn btn-sm btn-danger" data-id="{{ $item->id }}">
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
                    <i class="fas fa-user-plus me-2"></i>Asignar Profesor a Asignatura
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Formulario -->
            <form id="formCrearAsignatura" method="POST" action="{{ route('asignaciones.store') }}">
                @csrf

                <div class="modal-body">

                    <!-- Profesor -->
                    <div class="mb-3">
                        <label for="profesor_id" class="form-label fw-bold">👨‍🏫 Profesor</label>
                        <select name="profesor_id" id="profesor_id" class="form-select @error('profesor_id') is-invalid @enderror" required>
                            <option value="">Seleccione un profesor</option>
                            @foreach($profesores as $profesor)
                            <option value="{{ $profesor->profesor_id }}">{{ $profesor->nombre }}</option>
                            @endforeach
                        </select>
                        @error('profesor_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @else
                        <div class="invalid-feedback">Seleccione un profesor válido.</div>
                        @enderror
                    </div>

                    <!-- Asignatura -->
                    <div class="mb-3">
                        <label for="id_asignatura" class="form-label fw-bold">📘 Asignatura</label>
                        <select name="id_asignatura" id="id_asignatura" class="form-select @error('id_asignatura') is-invalid @enderror" required>
                            <option value="">Seleccione una asignatura</option>
                            @foreach($asignaturas as $asignatura)
                            <option value="{{ $asignatura->id_asignatura }}">{{ $asignatura->nombre_asignatura }}</option>
                            @endforeach
                        </select>
                        @error('id_asignatura')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @else
                        <div class="invalid-feedback">Seleccione una asignatura válida.</div>
                        @enderror
                    </div>
                </div>

                <!-- Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Guardar Asignación
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

            <!-- Encabezado -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalEditarLabel">
                    <i class="fas fa-edit me-2"></i> Editar Asignación
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <!-- Formulario de edición -->
            <form id="formEditar" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-body">
                    <!-- Campo oculto para ID (opcional si usas la URL) -->
                    <input type="hidden" name="id" id="edit_id">

                    <!-- Profesor -->
                    <div class="mb-3">
                        <label for="edit_profesor_id" class="form-label fw-bold">👨‍🏫 Profesor</label>
                        <select name="profesor_id" id="edit_profesor_id" class="form-select" required>
                            <option value="">Seleccione un profesor</option>
                            @foreach($profesores as $profesor)
                            <option value="{{ $profesor->profesor_id }}">{{ $profesor->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Asignatura -->
                    <div class="mb-3">
                        <label for="edit_id_asignatura" class="form-label fw-bold">📘 Asignatura</label>
                        <select name="id_asignatura" id="edit_id_asignatura" class="form-select" required>
                            <option value="">Seleccione una asignatura</option>
                            @foreach($asignaturas as $asignatura)
                            <option value="{{ $asignatura->id_asignatura }}">{{ $asignatura->nombre_asignatura }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Pie del modal -->
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



<script>
    $(document).ready(function() {
        $('#asignaciones').DataTable({
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
            if (confirm('¿Estás seguro de eliminar esta asignacion?')) {
                $('#formEliminar').attr('action', '/asignaciones/' + $(this).data('id')).submit();
            }
        });

        $('.editar-btn').click(function() {
            $('#edit_profesor_id').val($(this).data('profesor'));
            $('#edit_id_asignatura').val($(this).data('asignatura'));
            $('#edit_id_grado').val($(this).data('grado'));
            $('#formEditar').attr('action', '/asignaciones/' + $(this).data('id'));
        });

    });
</script>


@endsection