<?php
require_once '../Modelo/Clinica.php';

$clinica = new Clinica();

header('Content-Type: application/json'); // Asegúrate de establecer el encabezado correcto

switch ($_GET['op']) {
    case 'listarEspecialidad':

        echo json_encode($clinica->listarEspecialidades());
        break;
    case 'listarCargo':
        echo json_encode($clinica->listarCargos());
        break;
    case 'listarDepartamento':
        echo json_encode($clinica->listarDepartamentos());
        break;
    default:
        echo json_encode(['error' => 'Falta el parámetro "op"']);
        break;
}
