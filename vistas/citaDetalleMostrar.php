<?php

$codCita = isset($_GET['codCita']) ? $_GET['codCita'] : '';




require 'componentes/header.php';
require '../modelo/Paciente.php';
$paciente = new Paciente();
require '../modelo/Personal.php';
$personal = new Personal();
require '../modelo/Citas.php';
$cita = new Cita();
// Obtener las especialidades, cargos y departamentos
$pacientes = $paciente->listarPacientes();
$personal = $personal->listarPersonal();
$diagnosticos = $cita->listarDiagnosticos();
$datosCita = $cita->mostrar($codCita);

?>

<div class="personalDetalle__container">
    <div class="
    ">
        <!-- <h2>formulario de registro</h2> -->
        <form action="../controlador/citas.php?op=guardarEditar" method="post" class="personalDetalle__form">
            <p class="personalDetalle__title">Registro </p>

            <div class="personalDetalle__flex">
                <div class="personalDetalle__select-container">

                    <input type="hidden" name="codCita" value="<?php echo $datosCita['codCita']; ?>">
                    <p class="avisoDetalle">Paciente: </p>
                    <span> <?php echo $datosCita['datosPaciente']; ?></span>
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
                        <?php
                        // Mostrar datos tabla de definicion cargos
                        while ($reg = $personal->fetch_object()) {
                            $selected = ($reg->codPersonal == $datosCita['codPersonal']) ? 'selected' : '';
                            echo '<option value="' . $reg->codPersonal . '" ' . $selected . '>' . $reg->datosPersonal . '</option>';
                        }
                        ?>
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
                        <p class="avisoDetalle">Fecha de la cita :</p>
                        <span> <?php echo $datosCita['fechaCita']; ?></span>
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

                <?php
                }
                ?>
            </div>
            <div class="personalDetalle__flex">
                <div class="personalDetalle__select-container">

                    <p class="avisoDetalle">Estado Actual:<?php echo $datosCita['estado']; ?></p>
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

            <div class="personalDetalle__select-container">
                <label>


                    <span>Diagnostico</span>
                </label>
                <select title="Diagnosticos" name="codDiagnostico" id="" class="personalDetalle__select">
                    <?php
                    // Mostrar datos tabla de definicion cargos
                    while ($reg = $diagnosticos->fetch_object()) {
                        $selected = ($reg->codDiagnostico == $datosCita['codDiagnostico']) ? 'selected' : '';
                        echo '<option value="' . $reg->codDiagnostico . '" ' . $selected . '>' . $reg->desDiagnostico . '</option>';
                    }
                    ?>
                </select>
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