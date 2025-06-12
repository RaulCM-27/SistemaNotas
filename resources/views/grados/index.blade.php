@extends('layouts.app')

@section('title', 'Grados')

@section('content')

<div class="mb-3">
    <!-- Botón que abre el modal -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalCrear">
        ➕ Agregar Grados
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
                    data-nombre="{{ $gra->nivel_grado }}"
                    data-edad="{{ $gra->letra_grado }}"
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
                    @csrf

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="id_grado" class="form-label">
                                <i class="fas fa-id-badge me-1"></i>ID del Grado <span class="text-danger">*</span>
                            </label>
                            <input type="number" name="id_gr  ado" id="id_grado" class="form-control" required placeholder="Ej: 601">
                        </div>

                        <div class="mb-3">
                            <label for="nivel_grado" class="form-label">
                                <i class="fas fa-sort-numeric-up-alt me-1"></i>Nivel del Grado <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nivel_grado" id="nivel_grado" class="form-control" maxlength="3" required placeholder="Ej: 6, 10, 11">
                        </div>

                        <div class="mb-3">
                            <label for="letra_grado" class="form-label">
                                <i class="fas fa-font me-1"></i>Letra del Grado <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="letra_grado" id="letra_grado" class="form-control" maxlength="1" required placeholder="Ej: A, B, C">
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



    });
</script>
@endsection