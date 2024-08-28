<?php
require "../Config/Conexion.php";

class Clinica
{

    public function __construct() {}

    public function listarEspecialidades()
    {
        $sql = "SELECT * FROM `especialidades`";
        return ejecutarConsulta($sql);
    }
    public function listarCargos()
    {
        $sql = "SELECT * FROM `cargos`";
        return ejecutarConsulta($sql);
    }
    public function listarDepartamentos()
    {
        $sql = "SELECT * FROM `departamentos`";
        return ejecutarConsulta($sql);
    }
}
