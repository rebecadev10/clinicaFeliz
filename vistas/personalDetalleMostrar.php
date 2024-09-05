<?php
require 'componentes/header.php';

$codePersonal = isset($_GET['codPersonal']) ? $_GET['codPersonal'] : '';

// include '../controlador/clinica.php';
// include '../controlador/personal.php';
require_once "../Modelo/Personal.php";
$personal = new Personal();
require_once "../Modelo/Clinica.php";
$clinica = new Clinica();
$datosPersonal = $personal->mostrar($codePersonal);
var_dump($datosPersonal);

// Obtener las especialidades, cargos y departamentos
$especialidades = $clinica->listarEspecialidades();
$cargos = $clinica->listarCargos();
$departamentos = $clinica->listarDepartamentos();
// Verifica si los datos se recibieron correctamente
if (empty($especialidades)) {
    echo 'No se encontraron especialidades.';
    exit;
}
if (empty($cargos)) {
    echo 'No se encontraron cargos.';
    exit;
}
if (empty($departamentos)) {
    echo 'No se encontraron departamentos.';
    exit;
}

?>

<div class="personalDetalle__container">
    <div class="
    ">
        <!-- <h2>formulario de registro</h2> -->
        <form action="../controlador/personal.php?op=guardarEditar" method="post" class="personalDetalle__form">
            <p class="personalDetalle__title">Registro </p>
            <p class="personalDetalle__message">Formulario de registro del nuevo personal </p>
            <div class="personalDetalle__flex">
                <h6 class="personalDetalle__subtitle">
                    Datos personales
                </h6>
            </div>
            <div class="personalDetalle__flex">
                <label>
                    <input type="hidden" name="codPersonal" value="<?php echo $datosPersonal['codPersonal']; ?>">
                    <input class="personalDetalle__input" type="text" name="cedula" placeholder="" required=""
                        value="<?php echo $datosPersonal['cedula']; ?>">
                    <span>Cédula</span>
                </label>

            </div>
            <div class="personalDetalle__flex">
                <label>
                    <input class="personalDetalle__input" type="text" name="nombre1" placeholder="" required=""
                        value="<?php echo $datosPersonal['nombre1']; ?>">
                    <span>Primer Nombre</span>
                </label>
                <label>
                    <input class="personalDetalle__input" type="text" name="nombre2" placeholder="" required=""
                        value="<?php echo $datosPersonal['nombre2']; ?>">
                    <span>Segundo Nombre</span>
                </label>

            </div>
            <div class="personalDetalle__flex">
                <label>
                    <input class="personalDetalle__input" type="text" name="apellido1" placeholder="" required=""
                        value="<?php echo $datosPersonal['apellido1']; ?>">
                    <span>Primer Apellido</span>
                </label>
                <label>
                    <input class="personalDetalle__input" type="text" name="apellido2" placeholder="" required=""
                        value="<?php echo $datosPersonal['apellido2']; ?>">
                    <span>Segundo Apellido</span>
                </label>

            </div>
            <div class="personalDetalle__flex">
                <h6 class="personalDetalle__subtitle">
                    Datos laborales
                </h6>
            </div>
            <div class="personalDetalle__flex">
                <div class="personalDetalle__select-container">
                    <label>
                        <span>Especialidad</span>
                    </label>
                    <select title="Especialidades" name="codEspecialidad" id="" class="personalDetalle__select">
                        <?php
                        // Mostrar datos de especialidades desde el array
                        foreach ($especialidades as $reg) {
                            // Compara el valor actual con el valor almacenado en $datosPersonal['codEspecialidad']
                            $selected = ($reg->id == $datosPersonal['codEspecialidad']) ? 'selected' : '';
                            echo '<option value="' . htmlspecialchars($reg['id']) . '"' . $selected . '>' . htmlspecialchars($reg['nombre']) . '</option>';
                        }

                        ?>
                    </select>

                </div>
                <div class="personalDetalle__select-container">
                    <label>


                        <span>Cargo</span>
                    </label>
                    <select title="Cargos" name="codCargo" id="" class="personalDetalle__select">
                        <?php

                        foreach ($cargos as $reg) {
                            // Compara el valor actual con el valor almacenado en $datosPersonal['codEspecialidad']
                            $selected = ($reg->id == $datosPersonal['codCargos']) ? 'selected' : '';
                            echo '<option value="' . htmlspecialchars($reg['id']) . '"' . $selected . '>' . htmlspecialchars($reg['nombre']) . '</option>';
                        }


                        ?>
                    </select>
                </div>

            </div>
            <div class="personalDetalle__flex">
                <div class="personalDetalle__select-container">
                    <label>

                        <span>Departamento</span>
                    </label>
                    <select title="Departamentos" name="codDepartamento" id="" class="personalDetalle__select">
                        <?php
                        foreach ($especialidades as $reg) {
                            // Compara el valor actual con el valor almacenado en $datosPersonal['codEspecialidad']
                            $selected = ($reg->id == $datosPersonal['codDepartamento']) ? 'selected' : '';
                            echo '<option value="' . htmlspecialchars($reg['id']) . '"' . $selected . '>' . htmlspecialchars($reg['nombre']) . '</option>';
                        }



                        ?>
                    </select>
                </div>
                <div class="personalDetalle__select-container">
                    <label>
                        <span>Turno</span>
                    </label>
                    <select id="turno" name="turno" class="personalDetalle__select">
                        <option value="" disabled <?php echo empty($datosPersonal['turno']) ? 'selected' : ''; ?>>Seleccione un turno</option>
                        <option value="Mañana" <?php echo ($datosPersonal['turno'] === 'Mañana') ? 'selected' : ''; ?>>Mañana</option>
                        <option value="Tarde" <?php echo ($datosPersonal['turno'] === 'Tarde') ? 'selected' : ''; ?>>Tarde</option>

                    </select>


                </div>
            </div>
            <div class="personalDetalle__flex">

                <div class="personalDetalle__select-container">


                    fecha Ingreso

                    <input class="personalDetalle__select" type="date" name="fechaIngreso" placeholder="" required=""
                        value="<?php echo $datosPersonal['fechaIngreso']; ?>">
                </div>
            </div>

            <div class="personalDetalle__botones">
                <button class="personalDetalle__cancel"><a href="personal.php?op=listar">Cancelar</a></button>
                <button type="submit" class="personalDetalle__submit">Guardar</button>
            </div>

        </form>
    </div>
</div>