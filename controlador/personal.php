<?php
require_once "../Modelo/Personal.php";
$personal = new Personal();

$codePersonal = isset($_GET["codPersonal"]) ? $_GET["codPersonal"] : "";
$codPersonal = isset($_POST["codPersonal"]) ? $_POST["codPersonal"] : "";
$cedula = isset($_POST["cedula"]) ? $_POST["cedula"] : "";
$nombre1 = isset($_POST["nombre1"]) ? $_POST["nombre1"] : "";
$nombre2 = isset($_POST["nombre2"]) ? $_POST["nombre2"] : "";
$apellido1 = isset($_POST["apellido1"]) ? $_POST["apellido1"] : "";
$apellido2 = isset($_POST["apellido2"]) ? $_POST["apellido2"] : "";
$codEspecialidad = isset($_POST["codEspecialidad"]) ? $_POST["codEspecialidad"] : "";
$codCargo = isset($_POST["codCargo"]) ? $_POST["codCargo"] : "";
$codDepartamento = isset($_POST["codDepartamento"]) ? $_POST["codDepartamento"] : "";
$turno = isset($_POST["turno"]) ? $_POST["turno"] : "";

$fechaIngreso = isset($_POST["fechaIngreso"]) ? $_POST["fechaIngreso"] : "";
$fechaEgreso = isset($_POST["fechaEgreso"]) ? $_POST["fechaEgreso"] : "";

switch ($_GET["op"]) {

    case 'listar':
        // Llama al método 'listar' del modelo
        $rspta = $personal->listar();

        // Prepara un array para almacenar los datos
        $data = array();

        // Recorre directamente el array y agrega cada registro al array de datos
        foreach ($rspta as $reg) {
            $data[] = array(
                'codPersonal' => $reg['codPersonal'],
                'cedula' => $reg['cedula'],
                'nombre1' => $reg['nombre1'],
                'nombre2' => $reg['nombre2'],
                'apellido1' => $reg['apellido1'],
                'apellido2' => $reg['apellido2'],
                'codEspecialidad' => $reg['codEspecialidad'],
                'codCargo' => $reg['codCargo'],
                'codDepartamento' => $reg['codDepartamento']
            );
        }

        // Prepara el resultado con el total de registros y los registros
        $result = array('total' => count($data), 'registros' => $data);

        // Devuelve los datos como JSON
        echo json_encode($result);
        break;
    case 'guardarEditar':
        if (empty($codPersonal)) {
            $rspta = $personal->insertarDatos($cedula, $nombre1, $nombre2, $apellido1, $apellido2, $codEspecialidad, $codCargo, $codDepartamento, $turno, $fechaIngreso, $fechaEgreso);

            // $rspta = $personal->insertarDatos($codPersonal, $cedula, $nombre1, $nombre2, $apellido1, $apellido2, $codEspecialidad, $codCargo, $codDepartamento, $turno, $fechaIngreso, $fechaEgreso);

            if ($rspta) {
                header("Location: ../vistas/mensaje.php?msg=success");
            } else {
                header("Location: ../vistas/mensaje.php?msg=errorRegistro");
            }
        } else {
            $rspta = $personal->editarDatos($codPersonal, $cedula, $nombre1, $nombre2, $apellido1, $apellido2, $codEspecialidad, $codCargo, $codDepartamento, $turno, $fechaIngreso, $fechaEgreso);
            if ($rspta) {
                header("Location: ../vistas/mensaje.php?msg=updated");
            } else {
                header("Location: ../vistas/mensaje.php?msg=error");
            }
        }
        break;

    case 'mostrar':
        $rspta = $personal->mostrar($codePersonal);
        echo json_encode($rspta); // Retorna el registro específico como JSON
        break;

    case 'listarPersonal':
        $rspta = $personal->listarPersonal();
        foreach ($rspta as $reg) {
            echo '<option value="' . $reg['codPersonal'] . '">' . $reg['datosPersonal'] . '</option>';
        }
        break;

    case 'listarPersonalTurno':
        $rspta = $personal->listarPersonalTurno($turno, $codEspecialidad);
        foreach ($rspta as $reg) {
            echo '<option value="' . $reg['codPersonal'] . '">' . $reg['datosPersonal'] . '</option>';
        }
        break;
}
