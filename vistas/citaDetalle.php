<?php
require 'componentes/header.php';
require '../modelo/Paciente.php';
$paciente = new Paciente();
require '../modelo/Personal.php';
$personal = new Personal();
require '../modelo/Citas.php';
$cita = new Cita();

$turnoSeleccionado = isset($_GET['turno']) ? $_GET['turno'] : '';
$especialidadSeleccionada = isset($_GET['especialidad']) ? $_GET['especialidad'] : '';

// Obtener las especialidades, cargos y departamentos
$pacientes = $paciente->listarPacientes();
$personalTurno = $personal->listarPersonalTurno($turnoSeleccionado, $especialidadSeleccionada);
var_dump($personalTurno);
$diagnosticos = $cita->listarDiagnosticos();


$horas = [];
if ($turnoSeleccionado) {
    $horas = $turnoSeleccionado === 'Mañana' ?
        ["07:00:00", "08:00:00", "09:00:00", "10:00:00", "11:00:00"] :
        ["13:00:00", "14:00:00", "15:00:00", "16:00:00", "17:00:00"];
}
?>

<div class="personalDetalle__container">
    <div class="
    ">
        <!-- <h2>formulario de registro</h2> -->
        <form action="../controlador/citas.php?op=guardarEditar" method="post" class="personalDetalle__form">
            <p class="personalDetalle__title">Registro Cita </p>
            <p class="personalDetalle__message">Formulario de registro para nueva cita </p>
            <div class="personalDetalle__flex">
                <div class="personalDetalle__select-container">
                    <label>
                        <span>Paciente</span>
                    </label>
                    <input type="hidden" name="codCita">
                    <select title="pacientes" name="codPaciente" id="" class="personalDetalle__select">

                        <?php
                        // Mostrar datos tabla de definicion especialidad
                        while ($reg = $pacientes->fetch_object()) {
                            echo '<option value="' . $reg->codPaciente . '">' . $reg->datosPaciente . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="personalDetalle__select-container">
                    <label>


                        <span>Medico</span>
                    </label>
                    <select title="personal" name="codPersonal" id="" class="personalDetalle__select">
                        <?php
                        // Mostrar datos tabla de definicion cargos
                        while ($reg = $personalTurno->fetch_object()) {
                            echo '<option value="' . $reg->codPersonal . '">' . $reg->datosPersonal . '</option>';
                        }
                        ?>
                    </select>
                </div>

            </div>

            <div class="personalDetalle__flex">
                <div class="personalDetalle__select-container">


                    Fecha para la Cita

                    <input class="personalDetalle__select" type="date" name="fechaCita" placeholder="" required="">
                    <!-- ocultamos el estado inicial de la cita  -->
                    <input class="personalDetalle__select" type="hidden" name="estado" value="Asignado">
                </div>
                <div class="personalDetalle__select-container">


                    Hora para la Cita
                    <select name="horaCita" class="personalDetalle__select" required>
                        <option value="" disabled selected>Seleccione una hora</option>
                        <?php foreach ($horas as $hora) : ?>
                            <option value="<?= $hora ?>"><?= date('h:i a', strtotime($hora)) ?></option>
                        <?php endforeach; ?>
                    </select>

                </div>


                <input class="personalDetalle__select" type="hidden" name="estado">


            </div>
            <div class="personalDetalle__flex">
                <div class="personalDetalle__select-container">
                    <label>


                        <span>Diagnostico</span>
                    </label>
                    <select title="Diagnosticos" name="codDiagnostico" id="" class="personalDetalle__select">
                        <?php
                        // Mostrar datos tabla de definicion cargos
                        while ($reg = $diagnosticos->fetch_object()) {
                            echo '<option value="' . $reg->codDiagnostico . '">' . $reg->desDiagnostico . '</option>';
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
    </div>
    </form>

</div>
</div>