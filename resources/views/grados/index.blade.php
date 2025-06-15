@extends('layouts.app')

@section('title', 'Grados')

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
        ➕ Agregar Grado
    </button>
</div>

<table id="grados" class="display" style="width:100%">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nivel</th>
            <th>Letra</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($grados as $gra)
        <tr>
            <td>{{ $gra->id_grado }}</td>
            <td>{{ $gra->nivel_grado }}</td>
            <td>{{ $gra->letra_grado }}</td>
            <td>
                <button class="btn btn-sm btn-primary editar-btn"
                    data-id="{{ $gra->id_grado }}"
                    data-nivel="{{ $gra->nivel_grado }}"
                    data-letra="{{ $gra->letra_grado }}"
                    data-bs-toggle="modal"
                    data-bs-target="#modalEditar">

                    <i class="bi bi-pencil-fill"></i> Editar
                </button>

                <button class="btn btn-sm btn-danger" data-id="{{ $gra->id_grado }}">
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
                    <i class="fas fa-user-plus me-2"></i>Nuevo Grado
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="formCrearGrado" method="POST" action="{{ route('grados.store') }}">
                <div class="modal-body">
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

                    @csrf
                    <!-- ID Grado -->
                    <div class="mb-3">
                        <label for="id_grado" class="form-label">
                            <i class="fas fa-hashtag me-1"></i>ID Grado <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                            class="form-control"
                            id="id_grado"
                            name="id_grado"
                            maxlength="20"
                            required
                            placeholder="Ej: 101">
                        <div class="invalid-feedback">
                            Por favor ingrese un ID válido.
                        </div>
                    </div>

                    <!-- Nivel Grado -->
                    <div class="mb-3">
                        <label for="nivel_grado" class="form-label">
                            <i class="fas fa-layer-group me-1"></i>Nivel de Grado <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                            class="form-control"
                            id="nivel_grado"
                            name="nivel_grado"
                            maxlength="3"
                            required
                            placeholder="Ej: 6, 7, 8 ...">
                        <div class="invalid-feedback">
                            Este campo es obligatorio.
                        </div>
                    </div>

                    <!-- Letra Grado -->
                    <div class="mb-3">
                        <label for="letra_grado" class="form-label">
                            <i class="fas fa-font me-1"></i>Letra de Grado <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                            class="form-control"
                            id="letra_grado"
                            name="letra_grado"
                            maxlength="1"
                            required
                            placeholder="Ej: A, B, C ...">
                        <div class="invalid-feedback">
                            Este campo es obligatorio.
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Guardar Grado
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- Modal Editar -->
<div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalEditarLabel">
                    <i class="fas fa-user-edit me-2"></i>Editar Grado
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="formEditar" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <!-- ID Grado (solo lectura) -->
                    <div class="mb-3">
                        <label for="edit_id_grado" class="form-label">
                            <i class="fas fa-hashtag me-1"></i>ID Grado
                        </label>
                        <input type="text"
                               class="form-control"
                               id="edit_id_grado"
                               name="id_grado"
                               readonly>
                    </div>

                    <!-- Nivel Grado -->
                    <div class="mb-3">
                        <label for="edit_nivel_grado" class="form-label">
                            <i class="fas fa-layer-group me-1"></i>Nivel de Grado <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               class="form-control"
                               id="edit_nivel_grado"
                               name="nivel_grado"
                               maxlength="3"
                               required
                               placeholder="Ej: 6, 7, 8 ...">
                    </div>

                    <!-- Letra Grado -->
                    <div class="mb-3">
                        <label for="edit_letra_grado" class="form-label">
                            <i class="fas fa-font me-1"></i>Letra de Grado <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               class="form-control"
                               id="edit_letra_grado"
                               name="letra_grado"
                               maxlength="1"
                               required
                               placeholder="Ej: A, B, C ...">
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

<!-- Formulario oculto para eliminar -->
<form id="formEliminar" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

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
        $('#grados').DataTable({
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
            if (confirm('¿Estás seguro de eliminar este grado?')) {
                $('#formEliminar').attr('action', '/grados/' + $(this).data('id')).submit();
            }
        });

        $('.editar-btn').click(function() {
            $('#edit_id_grado').val($(this).data('id'));
            $('#edit_nivel_grado').val($(this).data('nivel'));
            $('#edit_letra_grado').val($(this).data('letra'));
            $('#formEditar').attr('action', '/grados/' + $(this).data('id'));
        });
    });
</script>

@endsection