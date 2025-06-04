@extends('layouts.app')

@section('title', 'Estudiantes')

@section('content')

<div class="mb-3">
    <!-- Botón que abre el modal -->
    <button id="btnAgregarEstudiante" class="btn btn-primary mb-3">
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
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($estudiantes as $estu)
        <tr>
            <td>{{ $estu-estudiante_id }}</td>
            <td>{{ $estu->nombre_estudiante }}</td>
            <td>{{ $estu->edad }}</td>
            <td>{{ $estu->direccion }}</td>
            <td>{{ $estu->telefono }}</td>
            <td>
                <button class="btn btn-sm btn-primary">
                    <i class="fas fa-edit"></i> Editar
                </button>

                <button class="btn btn-sm btn-danger">
                    <i class="fas fa-trash-alt"></i> Borrar
                </button>
            </td>
        </tr>
        <!-- Agrega más filas aquí -->
         @endforeach
    </tbody>
</table>

<div class="modal fade" id="modalCrear" tabindex="-1" aria-labelledby="modalCrearLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <h5 class="modal-title">Nuevo Estudiante</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        
    </div>
</div>


<script>
    $(document).ready(function() {
        const modal = new bootstrap.Modal(document.getElementById('modalCrear'));

        $('#btnAgregarEstudiante').on('click', function() {
            modal.show();
        });

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
    });
</script>



@endsection