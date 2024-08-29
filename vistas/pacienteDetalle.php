<?php
require 'componentes/header.php';

?>

<div class="personalDetalle__container">
    <div class="
    ">
        <!-- <h2>formulario de registro</h2> -->
        <form action="../controlador/paciente.php?op=guardarEditar" method="post" class="personalDetalle__form">
            <p class="personalDetalle__title">Registro </p>
            <p class="personalDetalle__message">Formulario de registro del nuevo paciente </p>
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


                <div class="personalDetalle__select-container">


                    Fecha de Nacimiento

                    <input class="personalDetalle__select" type="date" name="fechaNac" placeholder="" required="">
                </div>
                <div class="personalDetalle__select-container">
                    <label>


                        <span>Sexo</span>
                    </label>
                    <select id="sexo" name="sexo" class="personalDetalle__select">
                        <option value="" disabled selected>Seleccione una opción</option>
                        <option value="Femenino">Femenino</option>
                        <option value="Masculino">Masculino</option>

                    </select>
                </div>


            </div>
            <div class="personalDetalle__flex">
                <label>
                    <input class="personalDetalle__input" type="text" name="correo" placeholder="" required="">
                    <span>Correo</span>
                </label>
                <label>
                    <input class="personalDetalle__input" type="numbre" name="telefono" placeholder="" required="">
                    <span>Telefono</span>
                </label>

            </div>


            <div class="personalDetalle__botones">
                <button class="personalDetalle__cancel"><a href="pacientes.php?op=listar">Cancelar</a></button>
                <button type="submit" class="personalDetalle__submit">Guardar</button>
            </div>

        </form>

    </div>
</div>