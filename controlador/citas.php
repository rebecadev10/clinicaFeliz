<?php
require_once "../Modelo/Citas.php";
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
        $rspta = $cita->listar();
        $data = array();
        while ($reg = $rspta->fetch_object()) {
            $data[] = $reg;
        }
        $result = array('total' => count($data), 'registros' => $data);
        return $result;

    case 'guardarEditar':
        if (empty($codCita)) {



            $rspta = $cita->insertarDatos($codCita, $codPaciente, $codPersonal, $fechaCita, $horaCita, $estado, $codDiagnostico, $observaciones);
            // echo $rspta ? "Los Datos han sido cargados exitosamente" : "";
            if ($rspta) {
                // Redirigir al usuario si la operación fue exitosa
                header("Location: ../vistas/mensaje.php?msg=success");
            } else {
                // Redirigir con un mensaje de error si la operación falló
                header("Location: ../vistas/mensaje.php?msg=errorRegistro");
            }
        } else {
            $rspta = $cita->editarDatos($codCita, $codPaciente, $codPersonal, $fechaCita, $horaCita, $estado, $codDiagnostico, $observaciones);
            if ($rspta) {
                // Redirigir al usuario si la operación fue exitosa
                header("Location: ../vistas/mensaje.php?msg=updated");
            } else {
                // Redirigir con un mensaje de error si la operación falló
                header("Location: ../vistas/mensaje.php?msg=error");
            }
        }

        break;
    case 'mostrar':
        $rspta = $cita->mostrar($codCita);

        $data = $rspta;

        return $data;
    case 'listarDiagnosticos':

        $rspta = $cita->listarDiagnosticos();

        while ($reg = $rspta->fetch_object()) {
            echo '<option value=' . $reg->codDiagnostico . '>' . $reg->desDiagnostico . '</option>';
        }
        break;
}
