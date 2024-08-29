<?php
require 'componentes/header.php';
// Manejar el envío del turno
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $turnoSeleccionado = $_POST['turno'];
    $especialidadSeleccionada = $_POST['codEspecialidad'];

    // Redirigir a la página de detalles con los parámetros de turno y especialidad
    header("Location: citaDetalle.php?turno=" . urlencode($turnoSeleccionado) . "&especialidad=" . urlencode($especialidadSeleccionada));
    exit();
}

require '../modelo/Clinica.php';

// Crear una instancia de la clase Clinica
$clinica = new Clinica();

$especialidades = $clinica->listarEspecialidades();
?>

<div class="personalDetalle__container">
    <form method="post" class="personalDetalle__form">
        <p class="personalDetalle__title">Datos importantes </p>
        <p class="personalDetalle__message">completa los siguientes campos para agendar una nueva cita</p>
        <div class="personalDetalle__select-container">
            <label>
                <span>Turno</span>
            </label>
            <select name="turno" class="personalDetalle__select" required>
                <option value="" disabled selected>Seleccione un turno</option>
                <option value="Mañana">Mañana</option>
                <option value="Tarde">Tarde</option>
            </select>
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
                        echo '<option value="' . htmlspecialchars($reg['id']) . '">' . htmlspecialchars($reg['nombre']) . '</option>';
                    }
                    ?>
                </select>
            </div>
        </div>
        <button type="submit" class="personalDetalle__submit">Continuar</button>
    </form>
</div>