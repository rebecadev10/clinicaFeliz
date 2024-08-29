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
        // Llama al método 'listar' del modelo
        $rspta = $paciente->listar();

        // Prepara un array para almacenar los datos
        $data = array();

        // Recorre directamente el array y agrega cada registro al array de datos
        foreach ($rspta as $reg) {
            $data[] = array(
                'codPaciente' => $reg['codPaciente'],
                'cedula' => $reg['cedula'],
                'nombre1' => $reg['nombre1'],
                'nombre2' => $reg['nombre2'],
                'apellido1' => $reg['apellido1'],
                'apellido2' => $reg['apellido2'],
                'fechaNac' => $reg['fechaNac'],
                'sexo' => $reg['sexo'],
                'correo' => $reg['correo'],
                'telefono' => $reg['telefono']
            );
        }

        // Prepara el resultado con el total de registros y los registros
        $result = array('total' => count($data), 'registros' => $data);

        // Devuelve los datos como JSON
        echo json_encode($result);
        break;

    case 'guardarEditar':
        if (empty($codPaciente)) {



            $rspta = $paciente->insertarDatos($cedula, $nombre1, $nombre2, $apellido1, $apellido2, $fechaNac, $sexo, $correo, $telefono);
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
        foreach ($rspta as $reg) {
            echo '<option value="' . $reg['codPaciente'] . '">' . $reg['datosPaciente'] . '</option>';
        }

        break;
}
