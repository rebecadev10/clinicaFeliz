<?php
require 'componentes/header.php';
require_once "../Modelo/Personal.php";
$personal = new Personal();
$asignado = isset($_GET['asignado']) ? $_GET['asignado'] : 'false';
$codPersonal = isset($_GET['codPersonal']) ? $_GET['codPersonal'] : '';

if (!empty($codPersonal)) {
    // Obtener los datos del personal desde el modelo
    $personalData = $personal->mostrar($codPersonal);

    if ($personalData) {
        $cedula = $personalData['cedula'];
        $nombre1 = $personalData['nombre1'];
        $apellido1 = $personalData['apellido1'];
    } else {
        echo "<p>No se encontró información del personal con el código proporcionado.</p>";
        exit();
    }
} else {
    echo "<p>Código de personal no proporcionado.</p>";
    exit();
}
?>
<div class="personalDetalle__container">
    <?php if ($asignado === 'true'): ?>
        <form action="../controlador/personal.php?op=actualizarEgreso" method="POST" class="personalDetalle__form">
            <p class="avisoDetalle">El personal <?= htmlspecialchars($nombre1) ?> <?= htmlspecialchars($apellido1) ?>, titular de la cédula V- <?= htmlspecialchars($cedula) ?>, tiene citas asignadas y no puede ser eliminado.</p>
            <p>Por favor, registre la fecha de egreso y cambie su disponibilidad.</p>


            <input type="hidden" name="op" value="actualizarEgreso">
            <input type="hidden" name="codPersonal" value="<?= htmlspecialchars($codPersonal) ?>">
            <div class="personalDetalle__flex">
                <div class="personalDetalle__select-container">
                    <label for="fechaEgreso">Por favor ingresa la fecha de Egreso:</label>
                    <input class="personalDetalle__select" type="date" name="fechaEgreso" id="fechaEgreso" required>
                </div>
            </div>
            <button type="submit" class="personalDetalle__submit">Actualizar</button>
        </form>

    <?php elseif ($asignado === 'false'): ?>

        <form class="personalDetalle__form" action="../controlador/personal.php?op=eliminar" method="POST">
            <div class="flex flex--center"></div>
            <p class="avisoDetalle">¿Está seguro de que desea eliminar al personal ?</p>

            <p class=""><?= htmlspecialchars($nombre1) ?> <?= htmlspecialchars($apellido1) ?>, titular de la cédula V- <?= htmlspecialchars($cedula) ?></p>
            <input type="hidden" name="codPersonal" value="<?= (int)$codPersonal ?>">
            <button type="submit" class="personalDetalle__cancel">Eliminar</button>
        </form>
    <?php else: ?>
        <p>No se puede procesar la solicitud. Por favor, verifique el código del personal.</p>
    <?php endif; ?>
</div>