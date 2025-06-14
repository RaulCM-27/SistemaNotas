@extends('layouts.app')

@section('title', 'Crear Horario')

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
        ➕ Agregar Horario
    </button>
</div>

<div class="mb-4">
    <label for="filtroGrado" class="form-label fw-bold">🎓 Filtrar por grado</label>
    <select id="filtroGrado" class="form-select w-auto">
        <option value="todos">Mostrar todos</option>
        @foreach($grados as $grado)
        <option value="grado-{{ $grado->id_grado }}">{{ $grado->nivel_grado }} {{ $grado->letra_grado }}</option>
        @endforeach
    </select>
</div>

@foreach($grados as $grado)
@php
$horariosGrado = $horarios->where('id_grado', $grado->id_grado);

$rangosHoras = $horariosGrado->map(function($h) {
return $h->hora_inicio . ' - ' . $h->hora_fin;
})->unique()->sort();

$dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'];
@endphp

<div class="tabla-grado grado-{{ $grado->id_grado }}">
    <h4 class="fw-bold">Horario semanal - {{ $grado->nivel_grado }} {{ $grado->letra_grado }}</h4>

    <div class="table-responsive">
        <table class="table table-bordered text-center">
            <thead class="table-light">
                <tr>
                    <th>Hora</th>
                    @foreach($dias as $dia)
                    <th>{{ $dia }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($rangosHoras as $rango)
                <tr>
                    <td>{{ $rango }}</td>
                    @foreach($dias as $dia)
                    @php
                    $horarioDia = $horariosGrado->first(function($h) use ($rango, $dia) {
                    return $h->dia === $dia && ($h->hora_inicio . ' - ' . $h->hora_fin) === $rango;
                    });
                    @endphp
                    <td>
                        @if($horarioDia)
                        <div class="fw-bold">{{ $horarioDia->asignacion->asignatura->nombre_asignatura }}</div>
                        <div class="text-muted small">{{ $horarioDia->asignacion->profesor->nombre }}</div>
                        @else
                        <span class="text-secondary">—</span>
                        @endif
                    </td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endforeach


<!-- Modal Crear -->
<div class="modal fade" id="modalCrear" tabindex="-1" aria-labelledby="modalCrearLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Header del modal -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalCrearHorarioLabel">
                    🕒 Crear Horario
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <!-- Formulario -->
            <form id="formCrearHorario" method="POST" action="{{ route('horarios.store') }}">
                @csrf
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


                    <!-- Grado -->
                    <div class="mb-3">
                        <label for="id_grado" class="form-label fw-bold">🎓 Grado</label>
                        <select name="id_grado" id="id_grado" class="form-select" required>
                            <option value="">Seleccione un grado</option>
                            @foreach($grados as $grado)
                            <option value="{{ $grado->id_grado }}">{{ $grado->nivel_grado }} {{ $grado->letra_grado }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Día -->
                    <div class="mb-3">
                        <label for="dia" class="form-label fw-bold">📅 Día</label>
                        <select name="dia" id="dia" class="form-select" required>
                            <option value="">Seleccione un día</option>
                            <option value="Lunes">Lunes</option>
                            <option value="Martes">Martes</option>
                            <option value="Miércoles">Miércoles</option>
                            <option value="Jueves">Jueves</option>
                            <option value="Viernes">Viernes</option>
                        </select>
                    </div>

                    <!-- Asignación -->
                    <div class="mb-3">
                        <label for="id_asignacion" class="form-label fw-bold">👨‍🏫 Profesor - 📘 Asignatura</label>
                        <select name="id_asignacion" id="id_asignacion" class="form-select" required>
                            <option value="">Seleccione una asignación</option>
                            @foreach($asignaciones as $asignacion)
                            <option value="{{ $asignacion->id }}">
                                {{ $asignacion->profesor->nombre }} - {{ $asignacion->asignatura->nombre_asignatura }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Duración -->
                    <div class="mb-3">
                        <label for="duracion" class="form-label fw-bold">⌛ Duración de la clase</label>
                        <select id="duracion" class="form-select" required>
                            <option value="">Seleccione duración</option>
                            <option value="45">1 hora (45 minutos)</option>
                            <option value="90">2 horas (90 minutos)</option>
                        </select>
                    </div>

                    <!-- Horarios -->
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="hora_inicio" class="form-label fw-bold">⏰ Hora Inicio</label>
                            <select name="hora_inicio" id="hora_inicio" class="form-select" required>
                                <option value="">Seleccione hora de inicio</option>
                                <option value="07:00">07:00</option>
                                <option value="07:45">07:45</option>
                                <option value="08:30">08:30</option>
                                <option value="09:30">09:30</option>
                                <option value="10:15">10:15</option>
                                <option value="11:00">11:00</option>
                            </select>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="hora_fin" class="form-label fw-bold">⏳ Hora Fin</label>
                            <input type="time" name="hora_fin" id="hora_fin" class="form-control" readonly required>
                        </div>
                    </div>

                </div>

                <!-- Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Horario</button>
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
        $('#horarios').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
            },
            lengthMenu: [
                [5, 10, 20, 50],
                [5, 10, 20, 50]
            ],
            stripeClasses: ['odd', 'even'],
        });

        
        document.getElementById('hora_inicio').addEventListener('change', updateHoraFin);
        document.getElementById('duracion').addEventListener('change', updateHoraFin);

        function updateHoraFin() {
            const inicio = document.getElementById('hora_inicio').value;
            const duracion = parseInt(document.getElementById('duracion').value);

            if (!inicio || !duracion) return;

            const [h, m] = inicio.split(':').map(Number);
            const totalMinInicio = h * 60 + m;
            const totalMinFin = totalMinInicio + duracion;

            const limiteFin = 11 * 60 + 45; // 11:45 en minutos

            if (totalMinFin > limiteFin) {
                alert("⛔ La duración excede el horario permitido (máximo hasta 11:45 AM).");
                document.getElementById('hora_fin').value = '';
                return;
            }

            const horaFin = new Date(0, 0, 0, 0, totalMinFin);

            const horas = String(horaFin.getHours()).padStart(2, '0');
            const minutos = String(horaFin.getMinutes()).padStart(2, '0');

            document.getElementById('hora_fin').value = `${horas}:${minutos}`;
        }

        $('#filtroGrado').on('change', function() {
            const valorSeleccionado = $(this).val();

            if (valorSeleccionado === 'todos') {
                $('.tabla-grado').show();
            } else {
                $('.tabla-grado').hide();
                $('.' + valorSeleccionado).show();
            }
        });



    });
</script>

@endsection