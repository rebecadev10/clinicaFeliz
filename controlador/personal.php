<?php
require_once "../Modelo/Personal.php";
$personal = new Personal();
$codePersonal = isset($_GET["codPersonal"]) ? limpiarCadena($_GET["codPersonal"]) : "";
$codPersonal = isset($_POST["codPersonal"]) ? limpiarCadena($_POST["codPersonal"]) : "";
$cedula = isset($_POST["cedula"]) ? limpiarCadena($_POST["cedula"]) : "";
$nombre1 = isset($_POST["nombre1"]) ? limpiarCadena($_POST["nombre1"]) : "";
$nombre2 = isset($_POST["nombre2"]) ? limpiarCadena($_POST["nombre2"]) : "";
$apellido1 = isset($_POST["apellido1"]) ? limpiarCadena($_POST["apellido1"]) : "";
$apellido2 = isset($_POST["apellido2"]) ? limpiarCadena($_POST["apellido2"]) : "";
$codEspecialidad = isset($_POST["codEspecialidad"]) ? limpiarCadena($_POST["codEspecialidad"]) : "";
$codCargo = isset($_POST["codCargo"]) ? limpiarCadena($_POST["codCargo"]) : "";
$codDepartamento = isset($_POST["codDepartamento"]) ? limpiarCadena($_POST["codDepartamento"]) : "";
$turno = isset($_POST["turno"]) ? limpiarCadena($_POST["turno"]) : "";

$fechaIngreso = isset($_POST["fechaIngreso"]) ? limpiarCadena($_POST["fechaIngreso"]) : "";
$fechaEgreso = isset($_POST["fechaEgreso"]) ? limpiarCadena($_POST["fechaEgreso"]) : "";


switch ($_GET["op"]) {
    case 'listar':
        $rspta = $personal->listar();
        $data = array();
        while ($reg = $rspta->fetch_object()) {
            $data[] = $reg;
        }

        $result = array('total' => count($data), 'registros' => $data);
        return $result;
        // break;

    case 'guardarEditar':
        if (empty($codPersonal)) {



            $rspta = $personal->insertarDatos($codPersonal, $cedula, $nombre1, $nombre2, $apellido1, $apellido2, $codEspecialidad, $codCargo, $codDepartamento, $turno,  $fechaIngreso, $fechaEgreso);
            // echo $rspta ? "Los Datos han sido cargados exitosamente" : "";
            if ($rspta) {
                // Redirigir al usuario si la operación fue exitosa
                header("Location: ../vistas/mensaje.php?msg=success");
            } else {
                // Redirigir con un mensaje de error si la operación falló
                header("Location: ../vistas/mensaje.php?msg=errorRegistro");
            }
        } else {
            $rspta = $personal->editarDatos($codPersonal, $cedula, $nombre1, $nombre2, $apellido1, $apellido2, $codEspecialidad, $codCargo, $codDepartamento, $turno,  $fechaIngreso, $fechaEgreso);
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
        $rspta = $personal->mostrar($codePersonal);

        $data = $rspta;

        return $data;
    case 'listarPersonal':

        $rspta = $personal->listarPersonal();

        while ($reg = $rspta->fetch_object()) {
            echo '<option value=' . $reg->codPersonal . '>' . $reg->datosPersonal . '</option>';
        }
        break;
    case 'listarPersonalTurno':

        $rspta = $personal->listarPersonalTurno($turno, $especialidadSeleccionada);

        while ($reg = $rspta->fetch_object()) {
            echo '<option value=' . $reg->codPersonal . '>' . $reg->datosPersonal . '</option>';
        }
        break;
}
