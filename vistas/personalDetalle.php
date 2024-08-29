<?php
require 'componentes/header.php';
// En la vista `personalDetalle.php`

require '../modelo/Clinica.php';

// Crear una instancia de la clase Clinica
$clinica = new Clinica();

// Obtener los datos directamente del modelo
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
    <form action="../controlador/personal.php?op=guardarEditar" method="post" class="personalDetalle__form">
        <p class="personalDetalle__title">Registro </p>
        <p class="personalDetalle__message">Formulario de registro del nuevo personal </p>
        <div class="personalDetalle__flex">
            <h6 class="personalDetalle__subtitle">Datos personales</h6>
        </div>
        <div class="personalDetalle__flex">
            <label>
                <input type="hidden" name="codPersonal">
                <input class="personalDetalle__input" type="text" name="cedula" placeholder="" required="">
                <span>Cédula</span>
            </label>
        </div>
        <div class="personalDetalle__flex">
            <label>
                <input class="personalDetalle__input" type="text" name="nombre1" placeholder="" required="">
                <span>Primer Nombre</span>
            </label>
            <label>
                <input class="personalDetalle__input" type="text" name="nombre2" placeholder="" required="">
                <span>Segundo Nombre</span>
            </label>
        </div>
        <div class="personalDetalle__flex">
            <label>
                <input class="personalDetalle__input" type="text" name="apellido1" placeholder="" required="">
                <span>Primer Apellido</span>
            </label>
            <label>
                <input class="personalDetalle__input" type="text" name="apellido2" placeholder="" required="">
                <span>Segundo Apellido</span>
            </label>
        </div>
        <div class="personalDetalle__flex">
            <h6 class="personalDetalle__subtitle">Datos laborales</h6>
        </div>
        <div class="personalDetalle__flex">
            <div class="personalDetalle__select-container">
                <label>
                    <span>Especialidad</span>
                </label>
                <select title="Especialidades" name="codEspecialidad" class="personalDetalle__select">
                    <?php
                    // Mostrar datos de especialidades desde el array
                    foreach ($especialidades as $reg) {
                        echo '<option value="' . htmlspecialchars($reg['id']) . '">' . htmlspecialchars($reg['nombre']) . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="personalDetalle__select-container">
                <label>
                    <span>Cargo</span>
                </label>
                <select title="Cargos" name="codCargo" class="personalDetalle__select">
                    <?php
                    // Mostrar datos de cargos desde el array
                    foreach ($cargos as $reg) {
                        echo '<option value="' . htmlspecialchars($reg['id']) . '">' . htmlspecialchars($reg['nombre']) . '</option>';
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
                <select title="Departamentos" name="codDepartamento" class="personalDetalle__select">
                    <?php
                    // Mostrar datos de departamentos desde el array
                    foreach ($departamentos as $reg) {
                        echo '<option value="' . htmlspecialchars($reg['id']) . '">' . htmlspecialchars($reg['nombre']) . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="personalDetalle__select-container">
                <label>
                    <span>Turno</span>
                </label>
                <select id="turno" name="turno" class="personalDetalle__select">
                    <option value="" disabled selected>Seleccione un turno</option>
                    <option value="Mañana">Mañana</option>
                    <option value="Tarde">Tarde</option>
                </select>
            </div>
        </div>
        <div class="personalDetalle__flex">
            <div class="personalDetalle__select-container">
                <label>
                    <span>Fecha Ingreso</span>
                </label>
                <input class="personalDetalle__select" type="date" name="fechaIngreso" placeholder="" required="">
            </div>
        </div>
        <div class="personalDetalle__botones">
            <button class="personalDetalle__cancel"><a href="personal.php?op=listar">Cancelar</a></button>
            <button type="submit" class="personalDetalle__submit">Guardar</button>
        </div>
    </form>
</div>