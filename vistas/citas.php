<?php

require 'componentes/header.php';
session_start();

// Verificar si los datos ya están en la sesión
if (!isset($_SESSION['listaCita'])) {
    // Incluir el archivo controlador del personal y obtener los datos
    include '../controlador/citas.php';

    // Guardar el resultado en la sesión para futuras solicitudes
    $_SESSION['listaCita'] = $result;
} else {
    // Recuperar los datos de la sesión
    $result = $_SESSION['listaCita'];
}

// Recibir el total de registros de la variable $result almacenada en la sesión
$totalRegistros = $result['total'];
$data = $result['registros'];
var_dump($data);
// Definir el número de registros por página
$registrosPorPagina = 5;

// Calcular el número total de páginas
$totalPaginas = ceil($totalRegistros / $registrosPorPagina);

// Obtener la página actual desde la URL, si no está definida, es la página 1
$paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$paginaActual = max(1, min($paginaActual, $totalPaginas)); // Asegurar que la página está dentro de los límites

// Calcular el índice de inicio y fin para la paginación
$inicio = ($paginaActual - 1) * $registrosPorPagina;
$fin = min($inicio + $registrosPorPagina, $totalRegistros);

?>
<div class="personal__container">
    <div class="personal__encabezado">
        <h2 class="personal__titulo">
            Citas registrados
        </h2>
        <div class="personal__btn">
            <a class="personal__btn-content" href="turno.php">Nueva Cita</a>
        </div>
    </div>
    <div class="personal__tabla-container">
        <table class="personal__tabla ">
            <thead>
                <tr>
                    <th>Opción</th>
                    <th>Cédula Paciente</th>
                    <th>Nombre Paciente</th>
                    <th>Nombre medico</th>
                    <th>Fecha Cita</th>
                    <th>diagnostico</th>


                </tr>
            </thead>
            <tbody>
                <?php
                // Mostrar solo los registros correspondientes a la página actual
                for ($i = $inicio; $i < $fin; $i++):
                    $reg = $data[$i];
                ?>

                    <tr>
                        <td><a class="personal__btn-detalle" href="citaDetalleMostrar.php?codCita=<?php echo $reg['codCita']; ?>">Ver</a></td>
                        <td><?php echo $reg['cedulaPaciente']; ?></td>
                        <td><?php echo $reg['nombrePaciente']; ?></td>
                        <td><?php echo $reg['nombrePersonal']; ?></td>
                        <td><?php echo $reg['fechaCita']; ?></td>
                        <td><?php echo $reg['horaCita']; ?></td>

                    </tr>
                <?php endfor; ?>
            </tbody>
        </table>
    </div>

    <!-- Botones de navegación -->
    <div class="personal__pagination">
        <?php if ($paginaActual > 1): ?>
            <a class="personal__btn-content" href="?pagina=<?php echo $paginaActual - 1; ?>">Volver</a>
        <?php endif; ?>

        <?php if ($paginaActual < $totalPaginas): ?>
            <a class="personal__btn-content" href="?pagina=<?php echo $paginaActual + 1; ?>">Mostrar más</a>
        <?php endif; ?>
    </div>