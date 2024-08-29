<?php
require 'componentes/header.php';
require '../modelo/Paciente.php';
require '../modelo/Personal.php';
require '../modelo/Citas.php';

// Instancias de los modelos
$paciente = new Paciente();
$personal = new Personal();
$cita = new Cita();

// Obtener el turno y especialidad seleccionados
$turnoSeleccionado = isset($_GET['turno']) ? $_GET['turno'] : '';
$especialidadSeleccionada = isset($_GET['especialidad']) ? $_GET['especialidad'] : '';

// Obtener las listas de pacientes, personal y diagnósticos desde los archivos JSON
$pacientes = $paciente->listarPacientes();
$personalTurno = $personal->listarPersonalTurno($turnoSeleccionado, $especialidadSeleccionada);
$diagnosticos = $cita->listarDiagnosticos();

// Obtener las horas disponibles según el turno seleccionado
$horas = [];
if ($turnoSeleccionado) {
    $horas = $turnoSeleccionado === 'Mañana' ?
        ["07:00:00", "08:00:00", "09:00:00", "10:00:00", "11:00:00"] :
        ["13:00:00", "14:00:00", "15:00:00", "16:00:00", "17:00:00"];
}
?>

<div class="personalDetalle__container">
    <div>
        <!-- Formulario de registro de cita -->
        <form action="../controlador/citas.php?op=guardarEditar" method="post" class="personalDetalle__form">
            <p class="personalDetalle__title">Registro Cita</p>
            <p class="personalDetalle__message">Formulario de registro para nueva cita</p>
            <div class="personalDetalle__flex">
                <div class="personalDetalle__select-container">
                    <label>
                        <span>Paciente</span>
                    </label>
                    <input type="hidden" name="codCita">
                    <select title="pacientes" name="codPaciente" class="personalDetalle__select">
                        <?php foreach ($pacientes as $reg) : ?>
                            <option value="<?= $reg['codPaciente'] ?>"><?= $reg['datosPaciente'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="personalDetalle__select-container">
                    <label>
                        <span>Medico</span>
                    </label>
                    <select title="personal" name="codPersonal" class="personalDetalle__select">
                        <?php foreach ($personalTurno as $reg) : ?>
                            <option value="<?= $reg['codPersonal'] ?>"><?= $reg['datosPersonal'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="personalDetalle__flex">
                <div class="personalDetalle__select-container">
                    <label>Fecha para la Cita</label>
                    <input class="personalDetalle__select" type="date" name="fechaCita" placeholder="" required>
                    <!-- Estado oculto -->
                    <input class="personalDetalle__select" type="hidden" name="estado" value="Asignado">
                </div>
                <div class="personalDetalle__select-container">
                    <label>Hora para la Cita</label>
                    <select name="horaCita" class="personalDetalle__select" required>
                        <option value="" disabled selected>Seleccione una hora</option>
                        <?php foreach ($horas as $hora) : ?>
                            <option value="<?= $hora ?>"><?= date('h:i a', strtotime($hora)) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="personalDetalle__flex">
                <div class="personalDetalle__select-container">
                    <label>
                        <span>Diagnostico</span>
                    </label>
                    <select title="Diagnosticos" name="codDiagnostico" class="personalDetalle__select">

                        <?php
                        // Mostrar datos de especialidades desde el array
                        foreach ($diagnosticos as $reg) {
                            echo '<option value="' . htmlspecialchars($reg['id']) . '">' . htmlspecialchars($reg['descripcion']) . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="personalDetalle__flex">
                <label>
                    <input class="personalDetalle__input" type="text" name="observaciones" placeholder="">
                    <span>Observaciones:</span>
                </label>
            </div>

            <div class="personalDetalle__botones">
                <button class="personalDetalle__cancel"><a href="pacientes.php?op=listar">Cancelar</a></button>
                <button type="submit" class="personalDetalle__submit">Guardar</button>
            </div>
        </form>
    </div>
</div>