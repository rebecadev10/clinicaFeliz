<?php
require_once "../Modelo/Citas.php";

// Sanitize and validate inputs
function limpiarCadena($cadena)
{
    return htmlspecialchars(trim($cadena), ENT_QUOTES, 'UTF-8');
}

$cita = new Cita();
$codCita = isset($_POST["codCita"]) ? limpiarCadena($_POST["codCita"]) : "";
$codPaciente = isset($_POST["codPaciente"]) ? limpiarCadena($_POST["codPaciente"]) : "";
$codPersonal = isset($_POST["codPersonal"]) ? limpiarCadena($_POST["codPersonal"]) : "";
$fechaCita = isset($_POST["fechaCita"]) ? limpiarCadena($_POST["fechaCita"]) : "";
$horaCita = isset($_POST["horaCita"]) ? limpiarCadena($_POST["horaCita"]) : "";
$estado = isset($_POST["estado"]) ? limpiarCadena($_POST["estado"]) : "";
$codDiagnostico = isset($_POST["codDiagnostico"]) ? limpiarCadena($_POST["codDiagnostico"]) : "";
$observaciones = isset($_POST["observaciones"]) ? limpiarCadena($_POST["observaciones"]) : "";

switch ($_GET["op"]) {
    case 'listar':
        // Obtener los datos de las citas
        $rspta = $cita->listar();

        // Prepara un array para almacenar los datos
        $data = array();

        // Recorre directamente el array y agrega cada registro al array de datos
        foreach ($rspta as $reg) {
            $data[] = array(
                'codCita' => $reg['codCita'],
                'cedulaPaciente' => $reg['cedulaPaciente'],
                'nombrePaciente' => $reg['nombrePaciente'],
                'nombrePersonal' => $reg['nombrePersonal'],
                'fechaCita' => $reg['fechaCita'],
                'horaCita' => $reg['horaCita'],

            );
        }

        // Prepara el resultado con el total de registros y los registros
        $result = array('total' => count($data), 'registros' => $data);

        // Devuelve los datos como JSON
        echo json_encode($result);
        break;

    case 'guardarEditar':
        // Insertar o actualizar datos según la presencia de codCita
        if (empty($codCita)) {
            $success = $cita->insertarDatos($codCita, $codPaciente, $codPersonal, $fechaCita, $horaCita, $estado, $codDiagnostico, $observaciones);
        } else {
            $success = $cita->editarDatos($codCita, $codPaciente, $codPersonal, $fechaCita, $horaCita, $estado, $codDiagnostico, $observaciones);
        }

        if ($success) {
            // Redirigir al usuario si la operación fue exitosa
            header("Location: ../vistas/mensaje.php?msg=success");
        } else {
            // Redirigir con un mensaje de error si la operación falló
            header("Location: ../vistas/mensaje.php?msg=errorRegistro");
        }
        break;

    case 'mostrar':
        // Mostrar una cita específica
        $data = $cita->mostrar($codCita);

        // Devolver el resultado como JSON
        echo json_encode($data);
        break;

    case 'listarDiagnosticos':
        // Obtener los diagnósticos

        echo json_encode($cita->listarDiagnosticos());
        // $data = $cita->listarDiagnosticos();

        // // Mostrar los diagnósticos en formato de opciones HTML
        // foreach ($data as $reg) {
        //     echo '<option value="' . htmlspecialchars($reg['codDiagnostico']) . '">' . htmlspecialchars($reg['desDiagnostico']) . '</option>';
        // }
        break;

    case 'listarCitasPorCedula':
        $citas = $cita->obtenerCitasPorCedula($cedula);

        // Verificar si se encontraron citas
        if (!empty($citas)) {
            // Preparar la respuesta
            $result = array('total' => count($citas), 'citas' => $citas);
        } else {
            // No se encontraron citas para la cédula proporcionada
            $result = array('total' => 0, 'citas' => []);
        }

        // Devolver el resultado como JSON
        echo json_encode($result);
        break;
}
