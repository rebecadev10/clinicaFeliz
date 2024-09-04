<?php
require 'componentes/header.php';
?>

<div class="historial__contenedor">
    <div class="historial__busqueda">
        <h3 class="historial__titulo">Historial medico del paciente</h3>
        <form action="">
            <div class="personalDetalle__flex">

                <input type="text" name="cedula" class="personalDetalle__select" placeholder="Ingresa la cedula del paciente">
                <button type="submit" class="historial__btn">Buscar</button>
            </div>
        </form>
    </div>
    <div class="historial__informacion">
        <p>aqui se vera en detalle las citas medicas del paciente</p>
    </div>
</div>