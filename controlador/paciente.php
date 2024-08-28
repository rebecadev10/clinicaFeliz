<?php
require_once "../Modelo/Paciente.php";
$paciente = new Paciente();
$codPaciente = isset($_POST["codPaciente"]) ? limpiarCadena($_POST["codPaciente"]) : "";
$cedula = isset($_POST["cedula"]) ? limpiarCadena($_POST["cedula"]) : "";
$nombre1 = isset($_POST["nombre1"]) ? limpiarCadena($_POST["nombre1"]) : "";
$nombre2 = isset($_POST["nombre2"]) ? limpiarCadena($_POST["nombre2"]) : "";
$apellido1 = isset($_POST["apellido1"]) ? limpiarCadena($_POST["apellido1"]) : "";
$apellido2 = isset($_POST["apellido2"]) ? limpiarCadena($_POST["apellido2"]) : "";
$fechaNac = isset($_POST["fechaNac"]) ? limpiarCadena($_POST["fechaNac"]) : "";
$sexo = isset($_POST["sexo"]) ? limpiarCadena($_POST["sexo"]) : "";
$correo = isset($_POST["correo"]) ? limpiarCadena($_POST["correo"]) : "";
$telefono = isset($_POST["telefono"]) ? limpiarCadena($_POST["telefono"]) : "";





switch ($_GET["op"]) {

    case 'listar':
        $rspta = $paciente->listar();
        $data = array();
        while ($reg = $rspta->fetch_object()) {
            $data[] = $reg;
        }
        $result = array('total' => count($data), 'registros' => $data);
        return $result;

    case 'guardarEditar':
        if (empty($codPaciente)) {



            $rspta = $paciente->insertarDatos($codPaciente, $cedula, $nombre1, $nombre2, $apellido1, $apellido2, $fechaNac, $sexo, $correo, $telefono);
            // echo $rspta ? "Los Datos han sido cargados exitosamente" : "";
            if ($rspta) {
                // Redirigir al usuario si la operación fue exitosa
                header("Location: ../vistas/mensaje.php?msg=success");
            } else {
                // Redirigir con un mensaje de error si la operación falló
                header("Location: ../vistas/mensaje.php?msg=errorRegistro");
            }
        } else {
            $rspta = $paciente->editarDatos($codPaciente, $cedula, $nombre1, $nombre2, $apellido1, $apellido2, $fechaNac, $sexo, $correo, $telefono);
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
        $rspta = $paciente->mostrar($codPaciente);

        $data = $rspta;

        return $data;
    case 'listarPacientes':

        $rspta = $paciente->listarPacientes();

        while ($reg = $rspta->fetch_object()) {
            echo '<option value=' . $reg->codPaciente . '>' . $reg->datosPaciente . '</option>';
        }
        break;
}
