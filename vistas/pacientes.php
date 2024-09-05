<?php
require 'componentes/header.php';

// Incluir el archivo controlador del personal

// recibo el total de registros de mi funcion listar  


// Verificar si los datos ya están en la sesión
if (!isset($_SESSION['listaPac'])) {
    // Incluir el archivo controlador del paciente y obtener los datos
    include '../controlador/paciente.php';

    // Guardar el resultado en la sesión para futuras solicitudes
    $_SESSION['listaPac'] = $result;
} else {
    // Recuperar los datos de la sesión
    $result = $_SESSION['listaPac'];
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
            Pacientes registrados
        </h2>
        <div class="personal__btn">
            <a class="personal__btn-content" href="historial.php">Historial Médico</a>
        </div>
        <div class="personal__btn">
            <a class="personal__btn-content" href="pacienteDetalle.php">Registrar paciente</a>
        </div>
    </div>
    <div class="personal__tabla-container">
        <table class="personal__tabla ">
            <thead>
                <tr>
                    <th>Opción</th>
                    <th>Cédula</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Correo</th>
                    <th>Telefonos</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Mostrar solo los registros correspondientes a la página actual
                for ($i = $inicio; $i < $fin; $i++):
                    $reg = $data[$i];
                ?>
                    <tr>
                        <td><a class="personal__btn-detalle" href="pacienteDetalleMostrar.php?codPaciente=<?php echo $reg['codPaciente']; ?>">Ver</a>
                            <a class="personal__btn-detalle" href="../controlador/paciente.php?op=verificarCitas&codPaciente=<?php echo $reg['codPaciente']; ?>">Eliminar</a>
                        </td>
                        <td><?php echo $reg['cedula']; ?></td>
                        <td><?php echo $reg['nombre1'] . ' ' . $reg['nombre2']; ?></td>
                        <td><?php echo $reg['apellido1'] . ' ' . $reg['apellido2']; ?></td>
                        <td><?php echo $reg['correo']; ?></td>
                        <td><?php echo $reg['telefono']; ?></td>
                    </tr>
                <?php
                endfor; ?>
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