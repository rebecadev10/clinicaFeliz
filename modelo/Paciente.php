<?php
require "../Config/Conexion.php";

class Paciente
{
    private $file = '../data/pacientes.json'; // Ruta al archivo JSON
    public function __construct() {}

    public function listar()
    {
        return $this->leerArchivo();
    }

    public function insertarDatos($cedula, $nombre1, $nombre2, $apellido1, $apellido2, $fechaNac, $sexo, $correo, $telefono)
    {
        $data = $this->leerArchivo();

        // Verificar si la cédula ya existe en el archivo
        foreach ($data as $registro) {
            if ($registro['cedula'] == $cedula) {
                return false; // La cédula ya existe
            }
        }
        // Determinar el siguiente codPersonal
        $ultimoId = 0;
        foreach ($data as $registro) {
            if (isset($registro['codPaciente']) && $registro['codPaciente'] > $ultimoId) {
                $ultimoId = $registro['codPaciente'];
            }
        }
        $nuevoCodPaciente = $ultimoId + 1;
        $nuevoRegistro =
            [
                "codPaciente" => $nuevoCodPaciente,
                "cedula" => $cedula,
                "nombre1" => $nombre1,
                "nombre2" => $nombre2,
                "apellido1" => $apellido1,
                "apellido2" => $apellido2,
                "fechaNac" => $fechaNac,
                "sexo" => $sexo,
                "correo" => $correo,
                "telefono" => $telefono

            ];
        $data[] = $nuevoRegistro;
        return $this->escribirArchivo($data);
    }
    public function editarDatos($codPaciente, $cedula, $nombre1, $nombre2, $apellido1, $apellido2, $fechaNac, $sexo, $correo, $telefono)
    {
        // Leer el archivo JSON
        $data = $this->leerArchivo();

        // Recorrer los registros para encontrar el que coincide con codPersonal
        foreach ($data as &$registro) {
            if ($registro['codPaciente'] == $codPaciente) {
                // Actualizar los datos del registro encontrado
                $registro['cedula'] = $cedula;
                $registro['nombre1'] = $nombre1;
                $registro['nombre2'] = $nombre2;
                $registro['apellido1'] = $apellido1;
                $registro['apellido2'] = $apellido2;
                $registro['fechaNac'] = $fechaNac;
                $registro['sexo'] = $sexo;
                $registro['correo'] = $correo;
                $registro['telefono'] = $telefono;

                break;
            }
        }

        // Guardar los datos actualizados en el archivo JSON
        return $this->escribirArchivo($data);
    }


    public function mostrar($codPaciente)
    {
        $data = $this->leerArchivo();

        foreach ($data as $registro) {
            if ($registro['codPaciente'] == $codPaciente) {
                return $registro;
            }
        }

        return null; // No se encontró el registro
    }



    public function listarPacientes()
    {
        $data = $this->listar();
        $resultados = [];

        foreach ($data as $registro) {
            $resultados[] = [
                'codPaciente' => $registro['codPaciente'],
                'datosPaciente' => 'V-' . $registro['cedula'] . ' ' . $registro['nombre1'] . ' ' . $registro['apellido1']
            ];
        }

        return $resultados;
    }
    private function leerArchivo()
    {
        if (!file_exists($this->file)) {
            return []; // Retornar un array vacío si el archivo no existe
        }

        $data = file_get_contents($this->file);
        return json_decode($data, true); // Convertir el JSON a array asociativo
    }

    // Escribir en el archivo JSON
    private function escribirArchivo($data)
    {
        $jsonData = json_encode($data, JSON_PRETTY_PRINT);
        $resultado = file_put_contents($this->file, $jsonData);
        return $resultado !== false; // Devuelve true si la escritura fue exitosa
    }
}
