<?php
require 'componentes/header.php';
require '../modelo/Citas.php';
function limpiarCadena($cadena)
{
    return htmlspecialchars(trim($cadena), ENT_QUOTES, 'UTF-8');
}
// Inicializar variables
$citas = [];
$cedula = '';
$busquedaRealizada = false; // Bandera para saber si se ha realizado una búsqueda

// Verifica si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cedula'])) {
    $cedula = limpiarCadena($_POST['cedula']);
    $busquedaRealizada = true; // Marca que se realizó una búsqueda

    // Instanciar la clase Cita
    $cita = new Cita();

    // Obtener las citas del paciente usando la cédula
    $citas = $cita->obtenerCitasPorCedula($cedula);
}
?>

<div class="historial__contenedor">
    <h3 class="historial__titulo">Historial médico del paciente</h3>
    <div class="historial__busqueda">

        <form action="" method="post">
            <div class="personalDetalle__flex">
                <input type="text" name="cedula" class="personalDetalle__select" placeholder="Ingresa la cédula del paciente" value="<?php echo htmlspecialchars($cedula); ?>" required>
                <button type="submit" class="historial__btn">Buscar</button>
            </div>
        </form>
    </div>
    <div class="historial__informacion">
        <?php if ($busquedaRealizada): ?>
            <?php if (!empty($citas)): ?>
                <ul class="historial__informacion-contenedor">
                    <?php foreach ($citas as $cita): ?>
                        <li class="historial__informacion-detalle">
                            <div class="historial__item">
                                <strong class="historial__etiqueta">Fecha:</strong><span class="historial__dato"> <?php echo htmlspecialchars($cita['fechaCita']); ?><br></span>
                            </div>
                            <div class="historial__item">
                                <strong class="historial__etiqueta">Hora:</strong><span class="historial__dato"> <?php echo htmlspecialchars($cita['horaCita']); ?><br></span>
                            </div>
                            <div class="historial__item">
                                <strong class="historial__etiqueta">Doctor:</strong><span class="historial__dato"> <?php echo htmlspecialchars($cita['nombrePersonal']); ?><br></span>
                            </div>
                            <div class="historial__item">
                                <strong class="historial__etiqueta">Diagnóstico:</strong> <span class="historial__dato"><?php echo htmlspecialchars($cita['diagnostico']); ?><br></span>
                            </div>
                            <div class="historial__item">
                                <strong class="historial__etiqueta">Observaciones:</strong> <span class="historial__dato"><?php echo htmlspecialchars($cita['observaciones']); ?><br></span>
                            </div>
                        </li>
                        <hr>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No se encontraron citas para la cédula proporcionada.</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<?php
require 'componentes/footer.php';
?>