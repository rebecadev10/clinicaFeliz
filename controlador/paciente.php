<?php
require_once "../Modelo/Paciente.php";
$paciente = new Paciente();
$codePaciente = isset($_GET["codPaciente"]) ? ($_GET["codPaciente"]) : "";
$codPaciente = isset($_POST["codPaciente"]) ? ($_POST["codPaciente"]) : "";
$cedula = isset($_POST["cedula"]) ? ($_POST["cedula"]) : "";
$nombre1 = isset($_POST["nombre1"]) ? ($_POST["nombre1"]) : "";
$nombre2 = isset($_POST["nombre2"]) ? ($_POST["nombre2"]) : "";
$apellido1 = isset($_POST["apellido1"]) ? ($_POST["apellido1"]) : "";
$apellido2 = isset($_POST["apellido2"]) ? ($_POST["apellido2"]) : "";
$fechaNac = isset($_POST["fechaNac"]) ? ($_POST["fechaNac"]) : "";
$sexo = isset($_POST["sexo"]) ? ($_POST["sexo"]) : "";
$correo = isset($_POST["correo"]) ? ($_POST["correo"]) : "";
$telefono = isset($_POST["telefono"]) ? ($_POST["telefono"]) : "";





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
        json_encode($result);
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
    case 'verificarCitas':
        if (empty($codePaciente)) {
            header("Location: ../vistas/pacienteEliminar.php?error=codigoInvalido");
            exit();
        }

        $tieneCitas = $paciente->verificarCitas($codePaciente);

        if ($tieneCitas) {
            header("Location: ../vistas/pacienteEliminar.php?asignado=true&codPaciente=" . urlencode($codePaciente));
        } else {
            header("Location: ../vistas/pacienteEliminar.php?asignado=false&codPaciente=" . urlencode($codePaciente));
        }
        break;

    case 'eliminar':
        $rspta = $personal->eliminar($codPaciente);
        if ($rspta) {
            header("Location: ../vistas/mensaje.php?msg=eliminado");
        } else {
            header("Location: ../vistas/mensaje.php?msg=error");
        }
        break;
}
