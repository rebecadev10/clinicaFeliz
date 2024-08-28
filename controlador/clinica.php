<?php
require_once "../Modelo/Clinica.php";
$clinica = new Clinica();

switch ($_GET["op"]) {

    case 'listarEspecialidad':

        $rspta = $clinica->listarEspecialidades();

        while ($reg = $rspta->fetch_object()) {
            echo '<option value=' . $reg->codEspecialidad . '>' . $reg->desEspecialidad . '</option>';
        }
        break;
    case 'listarCargo':

        $rspta = $clinica->listarCargos();

        while ($reg = $rspta->fetch_object()) {
            echo '<option value=' . $reg->codCargos . '>' . $reg->desCargos . '</option>';
        }
        break;
    case 'listarDepartamento':

        $rspta = $clinica->listarDepartamentos();

        while ($reg = $rspta->fetch_object()) {
            echo '<option value=' . $reg->codDepartamento . '>' . $reg->desDepartamento . '</option>';
        }
        break;
}
