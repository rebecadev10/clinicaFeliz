<?php


class Paciente
{
    private $file = '../data/pacientes.json'; // Ruta al archivo JSON
    private $citas = '../data/citas.json';
    public function __construct() {}

    private function readJson($filename)
    {
        if (!file_exists($filename)) {
            return [];
        }
        $json = file_get_contents($filename);
        return json_decode($json, true);
    }

    private function writeJson($filename, $data)
    {
        $json = json_encode($data, JSON_PRETTY_PRINT);

        if ($json === false) {
            error_log('Error al convertir datos a JSON: ' . json_last_error_msg());
            return false;
        }

        $bytes = file_put_contents($filename, $json);

        if ($bytes === false) {
            error_log('Error al escribir el archivo JSON: ' . $filename);
            return false;
        }

        return true;
    }

    public function listar()
    {
        return  $this->readJson($this->file);
    }

    public function insertarDatos($cedula, $nombre1, $nombre2, $apellido1, $apellido2, $fechaNac, $sexo, $correo, $telefono)
    {
        $data = $this->readJson($this->file);

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
        $this->writeJson($this->file, $data);
        return true;
    }
    public function editarDatos($codPaciente, $cedula, $nombre1, $nombre2, $apellido1, $apellido2, $fechaNac, $sexo, $correo, $telefono)
    {
        // Leer el archivo JSON
        $data = $this->readJson($this->file);

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
        $this->writeJson($this->file, $data);
        return true;
    }


    public function mostrar($codPaciente)
    {
        $data = $this->readJson($this->file);

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
    public function verificarCitas($codPaciente)
    {
        $citas = $this->readJson($this->citas);
        foreach ($citas as $cita) {
            if ($cita['codPaciente'] == $codPaciente) {
                return true; // El personal tiene citas asignadas
            }
        }
        return false; // El personal no tiene citas asignadas
    }

    public function eliminar($codPaciente)
    {
        $data = $this->readJson($this->file);
        $data = array_filter($data, fn($registro) => $registro['codPaciente'] != $codPaciente);
        $this->writeJson($this->file, $data);
        return true;
    }
}
