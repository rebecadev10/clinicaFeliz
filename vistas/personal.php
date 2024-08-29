<?php
require 'componentes/header.php';
session_start();

// Verificar si los datos ya están en la sesión
if (!isset($_SESSION['listaPer'])) {
    // Incluir el archivo controlador del personal y obtener los datos
    include '../controlador/personal.php';

    // Guardar el resultado en la sesión para futuras solicitudes
    $_SESSION['listaPer'] = $result;
} else {
    // Recuperar los datos de la sesión
    $result = $_SESSION['listaPer'];
}

// Recibir el total de registros de la variable $result almacenada en la sesión
$totalRegistros = $result['total'];
$data = $result['registros'];

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
            Listado de personal
        </h2>
        <div class="personal__btn">
            <a class="personal__btn-content" href="personalDetalle.php">Agregar personal</a>
        </div>
    </div>
    <div class="personal__tabla-container">
        <table class="personal__tabla">
            <thead>
                <tr>
                    <th>Opción</th>
                    <th>Cédula</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Especialidad</th>
                    <th>Cargos</th>
                    <th>Departamento</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Mostrar solo los registros correspondientes a la página actual
                for ($i = $inicio; $i < $fin; $i++):
                    $reg = $data[$i];
                ?>
                    <tr>
                        <td><a class="personal__btn-detalle" href="personalDetalleMostrar.php?codPersonal=<?php echo $reg['codPersonal']; ?>">Ver</a></td>
                        <td><?php echo $reg['cedula']; ?></td>
                        <td><?php echo $reg['nombre1'] . ' ' . $reg['nombre2']; ?></td>
                        <td><?php echo $reg['apellido1'] . ' ' . $reg['apellido2']; ?></td>
                        <td><?php echo $reg['codEspecialidad']; ?></td>
                        <td><?php echo $reg['codCargo']; ?></td>
                        <td><?php echo $reg['codDepartamento']; ?></td>
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
</div>