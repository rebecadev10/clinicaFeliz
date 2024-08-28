<?php
require 'componentes/header.php';

$codPaciente = isset($_GET['codPaciente']) ? $_GET['codPaciente'] : '';

require_once "../Modelo/Paciente.php";
$paciente = new Paciente();
$datosPaciente = $paciente->mostrar($codPaciente);

?>

<div class="personalDetalle__container">
    <div class="
    ">
        <!-- <h2>formulario de registro</h2> -->
        <form action="../controlador/paciente.php?op=guardarEditar" method="post" class="personalDetalle__form">
            <p class="personalDetalle__title">Registro </p>
            <p class="personalDetalle__message">Formulario de registro del nuevo personal </p>
            <div class="personalDetalle__flex">
                <h6 class="personalDetalle__subtitle">
                    Datos personales
                </h6>
            </div>
            <div class="personalDetalle__flex">
                <label>
                    <input type="hidden" name="codPaciente" value="<?php echo $datosPaciente['codPaciente']; ?>">
                    <input class="personalDetalle__input" type="text" name="cedula" placeholder="" required=""
                        value="<?php echo $datosPaciente['cedula']; ?>">
                    <span>Cédula</span>
                </label>

            </div>
            <div class="personalDetalle__flex">
                <label>
                    <input class="personalDetalle__input" type="text" name="nombre1" placeholder="" required=""
                        value="<?php echo $datosPaciente['nombre1']; ?>">
                    <span>Primer Nombre</span>
                </label>
                <label>
                    <input class="personalDetalle__input" type="text" name="nombre2" placeholder="" required=""
                        value="<?php echo $datosPaciente['nombre2']; ?>">
                    <span>Segundo Nombre</span>
                </label>

            </div>
            <div class="personalDetalle__flex">
                <label>
                    <input class="personalDetalle__input" type="text" name="apellido1" placeholder="" required=""
                        value="<?php echo $datosPaciente['apellido1']; ?>">
                    <span>Primer Apellido</span>
                </label>
                <label>
                    <input class="personalDetalle__input" type="text" name="apellido2" placeholder="" required=""
                        value="<?php echo $datosPaciente['apellido2']; ?>">
                    <span>Segundo Apellido</span>
                </label>

            </div>
            <div class="personalDetalle__flex">


                <div class="personalDetalle__select-container">


                    Fecha de Nacimiento

                    <input class="personalDetalle__select" type="date" name="fechaNac" placeholder="" required=""
                        value="<?php echo $datosPaciente['fechaNac']; ?>">
                </div>
                <div class="personalDetalle__select-container">
                    <label>


                        <span>Sexo</span>
                    </label>

                    <select id="sexo" name="sexo" class="personalDetalle__select">
                        <option value="" disabled <?php echo empty($datosPaciente['sexo']) ? 'selected' : ''; ?>>Seleccione una opción</option>
                        <option value="Femenino" <?php echo ($datosPaciente['sexo'] === 'Femenino') ? 'selected' : ''; ?>>Femenino</option>
                        <option value="Masculino" <?php echo ($datosPaciente['sexo'] === 'Masculino') ? 'selected' : ''; ?>>Masculino</option>

                    </select>
                </div>


            </div>
            <div class="personalDetalle__flex">
                <label>
                    <input class="personalDetalle__input" type="text" name="correo" placeholder="" required=""
                        value="<?php echo $datosPaciente['correo']; ?>">
                    <span>Correo</span>
                </label>
                <label>
                    <input class="personalDetalle__input" type="numbre" name="telefono" placeholder="" required=""
                        value="<?php echo $datosPaciente['telefono']; ?>">
                    <span>Telefono</span>
                </label>

            </div>

            <div class="personalDetalle__botones">
                <button class="personalDetalle__cancel"><a href="personal.php?op=listar">Cancelar</a></button>
                <button type="submit" class="personalDetalle__submit">Guardar</button>
            </div>

        </form>
    </div>
</div>
<script>
    console.log(<?php $datosPaciente; ?>);
</script>