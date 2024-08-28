<?php
require "../Config/Conexion.php";

class Cita
{

    public function __construct() {}

    public function listar()
    {
        $sql = "SELECT codCita,p.cedula AS cedulaPaciente,CONCAT( p.nombre1, ' ',p.apellido1)AS nombrePaciente, CONCAT(pe.nombre1,' ',pe.apellido1)AS nombrePersonal,fechaCita,horaCita,d.desDiagnostico AS diagnostico ,observaciones
         FROM citas c 
         INNER JOIN pacientes p ON c.codCita=p.codPaciente 
         INNER JOIN personal pe ON c.codPersonal= pe.codPersonal 
         INNER JOIN diagnosticos d ON d.codDiagnostico=c.codDiagnostico";
        return ejecutarConsulta($sql);
    }

    public function insertarDatos($codCita, $codPaciente, $codPersonal, $fechaCita, $horaCita, $estado, $codDiagnostico, $observaciones)
    {
        $sqlDisponibilidad = "SELECT * FROM citas WHERE codPersonal = '$codPersonal' AND fechaCita = '$fechaCita' AND horaCita = '$horaCita'";
        $disponibilidad = ejecutarConsulta($sqlDisponibilidad);
        if ($disponibilidad && mysqli_num_rows($disponibilidad) > 0) {
            // La cédula ya existe, no se inserta la información
            return false;
        } else {

            $sql_insertar = "INSERT INTO  citas ( codCita ,  codPaciente ,  codPersonal ,  fechaCita ,horaCita,estado,  codDiagnostico ,  observaciones ) 
            VALUES ('$codCita','$codPaciente','$codPersonal','$fechaCita','$horaCita','$estado','$codDiagnostico','$observaciones')";
            return ejecutarConsulta($sql_insertar);
        }
    }

    public function editarDatos($codCita, $codPaciente, $codPersonal, $fechaCita, $horaCita, $estado, $codDiagnostico, $observaciones)
    {
        $sql = "UPDATE  citas  SET   codPaciente ='$codPaciente', codPersonal ='$codPersonal', fechaCita ='$fechaCita',
        horaCita='$horaCita',estado='$estado' ,codDiagnostico ='$codDiagnostico', observaciones ='$observaciones' WHERE codCita ='$codCita'";
        return ejecutarConsulta($sql);
    }

    public function mostrar($codCita)
    {
        $sql = "SELECT codCita,CONCAT( 'V-',p.cedula,' ',p.nombre1, ' ',p.apellido1)AS datosPaciente, CONCAT('V-',pe.cedula,' ',pe.nombre1,' ',pe.apellido1)AS datosPersonal,fechaCita,estado,d.desDiagnostico AS diagnostico ,observaciones 
        FROM citas c 
        INNER JOIN pacientes p ON c.codCita=p.codPaciente 
        INNER JOIN personal pe ON c.codPersonal= pe.codPersonal 
        INNER JOIN diagnosticos d ON d.codDiagnostico=c.codDiagnostico
        WHERE codCita='$codCita' ";
        return ejecutarConsultaSimpleFila($sql);
    }

    public function listarDiagnosticos()
    {
        $sql = "SELECT * FROM  diagnosticos  ";
        return ejecutarConsulta($sql);
    }
}
