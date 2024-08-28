<?php
require "../Config/Conexion.php";

class Paciente
{

    public function __construct() {}

    public function listar()
    {
        $sql = "SELECT  codPaciente ,  cedula , CONCAT( nombre1,' ',  nombre2) AS nombres ,CONCAT(  apellido1 ,' ',  apellido2)AS apellidos ,   correo ,  telefono  FROM  pacientes ";
        return ejecutarConsulta($sql);
    }

    public function insertarDatos($codPaciente, $cedula, $nombre1, $nombre2, $apellido1, $apellido2, $fechaNac, $sexo, $correo, $telefono)
    {
        $sql_verificar = "SELECT cedula FROM pacientes WHERE cedula='$cedula'";
        $resultado_verificar = ejecutarConsulta($sql_verificar);
        if ($resultado_verificar && mysqli_num_rows($resultado_verificar) > 0) {
            // la cedula ya existe, no se inserta la informacion 
            return false;
        } else {
            $sql_insertar = "INSERT INTO  pacientes ( codPaciente ,  cedula ,  nombre1 ,  nombre2 ,  apellido1 ,  apellido2 ,  fechaNac ,  sexo ,  correo ,  telefono ) 
            VALUES ('$codPaciente','$cedula','$nombre1','$nombre2','$apellido1','$apellido2','$fechaNac','$sexo','$correo','$telefono')";
            return ejecutarConsulta($sql_insertar);
        }
    }

    public function editarDatos($codPaciente, $cedula, $nombre1, $nombre2, $apellido1, $apellido2, $fechaNac, $sexo, $correo, $telefono)
    {
        $sql = "UPDATE  pacientes  SET  cedula ='$cedula', nombre1 ='$nombre1', nombre2 ='$nombre2', apellido1 ='$apellido1',
         apellido2 ='$apellido2', fechaNac ='$fechaNac', sexo ='$sexo', correo ='$correo', telefono ='$telefono' WHERE codPaciente='$codPaciente' ";
        return ejecutarConsulta($sql);
    }

    public function mostrar($codPaciente)
    {
        $sql = "SELECT * FROM pacientes WHERE codPaciente='$codPaciente' ";
        return ejecutarConsultaSimpleFila($sql);
    }

    public function listarPacientes()
    {
        $sql = "SELECT  codPaciente , CONCAT('V-', cedula ,' ', nombre1 ,' ', apellido1 )AS datosPaciente FROM  pacientes ";
        return ejecutarConsulta($sql);
    }
}
