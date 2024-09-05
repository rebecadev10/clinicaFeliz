<?php
require 'componentes/header.php';
require_once "../Modelo/Paciente.php";
$paciente = new Paciente();
$asignado = isset($_GET['asignado']) ? $_GET['asignado'] : 'false';
$codPaciente = isset($_GET['codPaciente']) ? $_GET['codPaciente'] : '';

if (!empty($codPaciente)) {
    // Obtener los datos del personal desde el modelo
    $pacienteData = $paciente->mostrar($codPaciente);

    if ($pacienteData) {
        $cedula = $pacienteData['cedula'];
        $nombre1 = $pacienteData['nombre1'];
        $apellido1 = $pacienteData['apellido1'];
    } else {
        echo "<p>No se encontró información del paciente con el código proporcionado.</p>";
        exit();
    }
} else {
    echo "<p>Código de paciente no proporcionado.</p>";
    exit();
}
?>
<div class="personalDetalle__container">
    <?php if ($asignado === 'true'): ?>
        <p class="avisoDetalle">El paciente <?= htmlspecialchars($nombre1) ?> <?= htmlspecialchars($apellido1) ?>, titular de la cédula V- <?= htmlspecialchars($cedula) ?>, tiene citas asignadas y no puede ser eliminado.</p>
        <div class="mensajeContainer__btn">
            <button class="mensaje__btn"><a href="pacientes.php?op=listar" class="">Volver</a></button>
        </div>
    <?php elseif ($asignado === 'false'): ?>

        <form class="personalDetalle__form" action="../controlador/paciente.php?op=eliminar" method="POST">
            <div class="flex flex--center"></div>
            <p class="avisoDetalle">¿Está seguro de que desea eliminar al paciente ?</p>
            <p class=""><?= htmlspecialchars($nombre1) ?> <?= htmlspecialchars($apellido1) ?>, titular de la cédula V- <?= htmlspecialchars($cedula) ?></p>
            <input type="hidden" name="codPersonal" value="<?= htmlspecialchars($codPaciente) ?>">
            <button type="submit" class="personalDetalle__cancel">Eliminar</button>
        </form>
    <?php else: ?>
        <p>No se puede procesar la solicitud. Por favor, verifique el código del paciente.</p>
    <?php endif; ?>
</div>