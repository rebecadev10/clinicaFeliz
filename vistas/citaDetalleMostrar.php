<?php





require 'componentes/header.php';
require '../modelo/Paciente.php';
require '../modelo/Personal.php';
require '../modelo/Citas.php';

// Instancias de los modelos
$paciente = new Paciente();
$personal = new Personal();
$cita = new Cita();
// oobtenemos el codigo de la cita que se va a modificar
$codCita = isset($_GET['codCita']) ? $_GET['codCita'] : '';

// Obtener las especialidades, cargos y departamentos
$pacientes = $paciente->listarPacientes();

$diagnosticos = $cita->listarDiagnosticos();

$datosCita = $cita->mostrar($codCita);
var_dump($datosCita);
// 
$turnoSeleccionado = $datosCita['turno'];

$especialidadSeleccionada = $datosCita['especialidad'];
$personalTurno = $personal->listarPersonalTurno($turnoSeleccionado, $especialidadSeleccionada);
// Obtener las horas disponibles según el turno seleccionado
$horas = [];
if ($turnoSeleccionado) {
    $horas = $turnoSeleccionado === 'Mañana' ?
        ["07:00:00", "08:00:00", "09:00:00", "10:00:00", "11:00:00"] :
        ["13:00:00", "14:00:00", "15:00:00", "16:00:00", "17:00:00"];
}
// hora pautada para la cita 
$horaCita = $datosCita['horaCita'];
$horaPautada = date('h:i a', strtotime($horaCita));
?>


<div class="personalDetalle__container">
    <div class="
    ">
        <!-- <h2>formulario de registro</h2> -->
        <form action="../controlador/citas.php?op=guardarEditar" method="post" class="personalDetalle__form">
            <p class="personalDetalle__title">Datos de la cita </p>
            <p class="avisoDetalle">Departamento:</p>
            <span> <?php echo $datosCita['descDepartamento']; ?></span>
            </p>
            <div class="personalDetalle__flex">
                <div class="personalDetalle__select-container">

                    <input type="hidden" name="codCita" value="<?php echo $datosCita['codCita']; ?>">
                    <p class="avisoDetalle">Paciente: </p>
                    <span> <?php echo $datosCita['datosPaciente']; ?></span>
                    <input type="hidden" name="codPaciente" value="<?php echo $datosCita['idPaciente']; ?>">

                </div>
                <div class="personalDetalle__select-container">
                    <p class="avisoDetalle">Medico Asignado:</p>
                    <span> <?php echo $datosCita['datosPersonal']; ?></span>
                </div>

            </div>
            <div class="personalDetalle__flex">
                <div class="personalDetalle__select-container">
                    <label>


                        <span>Reasignar Medico:</span>
                    </label>

                    <select title="personal" name="codPersonal" id="" class="personalDetalle__select">
                        <?php foreach ($personalTurno as $reg) : ?>
                            <option value="<?= $reg['codPersonal'] ?>"><?= $reg['datosPersonal'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="personalDetalle__flex">
                <?php
                $fechaCita = $datosCita['fechaCita'];

                // Fecha actual
                $fechaActual = date('Y-m-d');

                if ($fechaCita < $fechaActual) {
                ?>
                    <div class="personalDetalle__select-container">
                        <p class="avisoDetalle">Cita pautada para:</p>
                        <span> <?php echo $datosCita['fechaCita']; ?></span>
                        <input type="hidden" name="fechaCita" value="<?php echo $datosCita['fechaCita']; ?>">
                    </div>
                    <div class="personalDetalle__select-container">

                        <p class="avisoDetalle">Hora pautada:</p>
                        <span> <?php echo $horaPautada ?></span>
                        <input type="hidden" name="horaCita" value="<?php echo $datosCita['horaCita']; ?>">

                    </div>
                <?php
                } else {

                    // la fecha puedad ser cambiada
                ?>
                    <!-- comprobamos si la fecha registrada ya ha  pasado  -->


                    <div class="personalDetalle__select-container">


                        Cambiar Fecha para la Cita

                        <input class="personalDetalle__select" type="date" name="fechaCita" placeholder="" required=""
                            value="<?php echo $datosCita['fechaCita']; ?>">

                    </div>
                    <div class="personalDetalle__select-container">
                        <label>Cambiar Hora para la Cita</label>
                        <select name="horaCita" class="personalDetalle__select" required>
                            <option value="" disabled selected>Seleccione una hora</option>
                            <?php foreach ($horas as $hora) : ?>
                                <option value="<?= $hora ?>"><?= date('h:i a', strtotime($hora)) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                <?php
                }
                ?>

            </div>
            <div class="personalDetalle__select-container">
                <label>


                    <span>Diagnostico</span>
                </label>
                <select title="Diagnosticos" name="codDiagnostico" id="" class="personalDetalle__select">
                    <?php
                    // Mostrar datos de especialidades desde el array
                    foreach ($diagnosticos as $reg) {
                        // Compara el valor actual con el valor almacenado en $datosPersonal['codEspecialidad']
                        $selected = ($reg->id == $datosCita['codDiagnostico']) ? 'selected' : '';
                        echo '<option value="' . htmlspecialchars($reg['id']) . '"' . $selected . '>' . htmlspecialchars($reg['descripcion']) . '</option>';
                    }

                    ?>
                </select>

            </div>
            <div class="personalDetalle__flex">
                <div class="personalDetalle__select-container">
                    <div class="flex flex--center ">
                        <p class="avisoDetalle">Estado Actual:</p>
                        <p class="avisoAlert"><?php echo $datosCita['estado']; ?></p>
                    </div>
                    <label>
                        <span>Actualizar Estado:</span>
                    </label>
                    <select id="estado" name="estado" class="personalDetalle__select">
                        <option value="" disabled <?php echo empty($datosCita['estado']) ? 'selected' : ''; ?>>Seleccione un estado</option>
                        <option value="Asignado" <?php echo ($datosCita['estado'] === 'Asignado') ? 'selected' : ''; ?>>Asignado</option>
                        <option value="Asistio" <?php echo ($datosCita['estado'] === 'Asistio') ? 'selected' : ''; ?>>Asistio</option>
                        <option value="No Asistio" <?php echo ($datosCita['estado'] === 'No Asistio') ? 'selected' : ''; ?>>No Asistio</option>

                    </select>


                </div>
            </div>




            <div class="personalDetalle__flex">
                <label>

                    <input class="personalDetalle__input" type="text" name="observaciones" placeholder=""
                        value="<?php echo $datosCita['observaciones']; ?>">
                    <span>Observaciones:</span>
                </label>

            </div>


            <div class="personalDetalle__botones">
                <button class="personalDetalle__cancel"><a href="citas.php?op=listar">Cancelar</a></button>
                <button type="submit" class="personalDetalle__submit">Guardar</button>
            </div>
    </div>
    </form>

</div>
</div>