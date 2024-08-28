<?php
require 'componentes/header.php';
include '../controlador/clinica.php';
// Obtener las especialidades, cargos y departamentos
$especialidades = $clinica->listarEspecialidades();
$cargos = $clinica->listarCargos();
$departamentos = $clinica->listarDepartamentos();
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
                        // Mostrar datos tabla de definicion especialidad
                        while ($reg = $especialidades->fetch_object()) {
                            echo '<option value="' . $reg->codEspecialidad . '">' . $reg->desEspecialidad . '</option>';
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
                        // Mostrar datos tabla de definicion cargos
                        while ($reg = $cargos->fetch_object()) {
                            echo '<option value="' . $reg->codCargos . '">' . $reg->desCargos . '</option>';
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
                        // Mostrar datos tabla de definicion departamento
                        while ($reg = $departamentos->fetch_object()) {
                            echo '<option value="' . $reg->codDepartamento . '">' . $reg->desDepartamento . '</option>';
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


                    fecha Ingreso

                    <input class="personalDetalle__select" type="date" name="fechaIngreso" placeholder="" required="">
                </div>
            </div>

            <div class="personalDetalle__botones">
                <button class="personalDetalle__cancel"><a href="personal.php?op=listar">Cancelar</a></button>
                <button type="submit" class="personalDetalle__submit">Guardar</button>
            </div>

        </form>
    </div>
</div>