<?php
require "../Config/Conexion.php";

class Personal
{

    public function __construct() {}
    public function listar()
    {
        $sql = " SELECT codPersonal,cedula, CONCAT(nombre1,' ',nombre2)AS nombres,CONCAT(apellido1,' ',apellido2)AS apellidos,e.desEspecialidad,c.desCargos,d.desDepartamento FROM personal p INNER JOIN especialidades e ON p.codEspecialidad = e.codEspecialidad INNER JOIN cargos c ON p.codCargo=c.codCargos INNER JOIN departamentos d ON p.codDepartamento = d.codDepartamento";
        return ejecutarConsulta($sql);
    }
    public function insertarDatos($codPersonal, $cedula, $nombre1, $nombre2, $apellido1, $apellido2, $codEspecialidad, $codCargo, $codDepartamento, $turno,  $fechaIngreso, $fechaEgreso,)
    {


        // Verificar si la cédula ya existe en la base de datos
        $sql_verificar = "SELECT cedula FROM personal WHERE cedula = '$cedula'";
        $resultado_verificar = ejecutarConsulta($sql_verificar);
        if ($resultado_verificar && mysqli_num_rows($resultado_verificar) > 0) {
            // La cédula ya existe, no se inserta la información
            return false;
        } else {

            // La cédula no existe, se procede a insertar la información
            $sql_insertar = "INSERT INTO personal(codPersonal, cedula, nombre1,nombre2,apellido1, apellido2,codEspecialidad,codCargo,codDepartamento, turno,fechaIngreso,fechaEgreso) VALUES 
                ('$codPersonal','$cedula','$nombre1','$nombre2','$apellido1','$apellido2','$codEspecialidad','$codCargo','$codDepartamento','$turno','$fechaIngreso','$fechaEgreso')";
            return ejecutarConsulta($sql_insertar);
        }
    }
    public function editarDatos($codPersonal, $cedula, $nombre1, $nombre2, $apellido1, $apellido2, $codEspecialidad, $codCargo, $codDepartamento, $turno,  $fechaIngreso, $fechaEgreso)
    {
        $sql = "UPDATE personal SET cedula='$cedula',nombre1='$nombre1',nombre2='$nombre2',apellido1='$apellido1', apellido2='$apellido2', codEspecialidad='$codEspecialidad',codCargo='$codCargo',codDepartamento='$codDepartamento',
        turno='$turno',fechaIngreso='$fechaIngreso',fechaEgreso='$fechaEgreso'
        WHERE codPersonal='$codPersonal'";
        return ejecutarConsulta($sql);
    }

    public function mostrar($codPersonal)
    {
        $sql = "SELECT codPersonal,cedula, nombre1,nombre2,apellido1,apellido2,p.codEspecialidad,e.desEspecialidad,p.codCargo,c.desCargos,p.codDepartamento,d.desDepartamento, turno,disponibilidad,fechaIngreso,fechaEgreso,cantPacientes,cantCitas 
        FROM personal p 
        INNER JOIN especialidades e ON p.codEspecialidad = e.codEspecialidad
        INNER JOIN cargos c ON p.codCargo=c.codCargos 
        INNER JOIN departamentos d ON p.codDepartamento = d.codDepartamento
        WHERE p.codPersonal ='$codPersonal'";
        return ejecutarConsultaSimpleFila($sql);
    }
    public function listarPersonal()
    {
        $sql = "SELECT  codPersonal , CONCAT('V-', cedula ,' ', nombre1 ,' ', apellido1 )AS datosPersonal FROM  personal ";
        return ejecutarConsulta($sql);
    }
    public function listarPersonalTurno($turno, $especialidadSeleccionada)
    {
        $sql = "SELECT  codPersonal , CONCAT('V-', cedula ,' ', nombre1 ,' ', apellido1 )AS datosPersonal FROM  personal WHERE turno ='$turno' AND codEspecialidad ='$especialidadSeleccionada' ";
        return ejecutarConsulta($sql);
    }

    public function disponobilidadPersonal($fechaCita, $codPersonal)
    {
        $sql = "SELECT CONCAT('V ', p.cedula ,' ', p.nombre1 ,' ', p.apellido1 ) AS datosPersonal, fechaCita, COUNT(*) AS cantidad_citas FROM citas c INNER JOIN personal p ON p.codPersonal = c.codPersonal WHERE c.fechaCita = '$fechaCita' AND c.codPersonal ='$codPersonal' GROUP BY c.codPersonal, c.fechaCita ORDER BY fechaCita ASC";
        return ejecutarConsultaSimpleFila($sql);
    }
}
