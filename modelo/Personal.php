<?php

class Personal
{
    private $file = '../data/personal.json'; // Ruta al archivo JSON

    public function __construct() {}

    // Leer y devolver todos los registros de personal
    public function listar()
    {
        return $this->leerArchivo();
    }

    // Insertar un nuevo registro en el archivo JSON
    public function insertarDatos($cedula, $nombre1, $nombre2, $apellido1, $apellido2, $codEspecialidad, $codCargo, $codDepartamento, $turno, $fechaIngreso, $fechaEgreso)
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
        if (!empty($data)) {
            foreach ($data as $registro) {
                if (isset($registro['codPersonal']) && $registro['codPersonal'] > $ultimoId) {
                    $ultimoId = $registro['codPersonal'];
                }
            }
        }

        // Si no hay registros, el primer codPersonal será 1
        $nuevoCodPersonal = $ultimoId + 1;

        // Convertir los códigos a enteros
        $codEspecialidad = (int)$codEspecialidad;
        $codCargo = (int)$codCargo;
        $codDepartamento = (int)$codDepartamento;
        $turno = (int)$turno;

        // Crear un nuevo registro
        $nuevoRegistro = [
            "codPersonal" => $nuevoCodPersonal,
            "cedula" => $cedula,
            "nombre1" => $nombre1,
            "nombre2" => $nombre2,
            "apellido1" => $apellido1,
            "apellido2" => $apellido2,
            "codEspecialidad" => $codEspecialidad,
            "codCargo" => $codCargo,
            "codDepartamento" => $codDepartamento,
            "turno" => $turno,
            "fechaIngreso" => $fechaIngreso,
            "fechaEgreso" => $fechaEgreso
        ];

        $data[] = $nuevoRegistro;
        return $this->escribirArchivo($data);
    }


    // Actualizar un registro existente en el archivo JSON
    public function editarDatos($codPersonal, $cedula, $nombre1, $nombre2, $apellido1, $apellido2, $codEspecialidad, $codCargo, $codDepartamento, $turno, $fechaIngreso, $fechaEgreso)
    {
        // Leer el archivo JSON
        $data = $this->leerArchivo();

        // Recorrer los registros para encontrar el que coincide con codPersonal
        foreach ($data as &$registro) {
            if ($registro['codPersonal'] == $codPersonal) {
                // Actualizar los datos del registro encontrado
                $registro['cedula'] = $cedula;
                $registro['nombre1'] = $nombre1;
                $registro['nombre2'] = $nombre2;
                $registro['apellido1'] = $apellido1;
                $registro['apellido2'] = $apellido2;

                // Convertir los campos a enteros antes de asignarlos
                $registro['codEspecialidad'] = (int)$codEspecialidad;
                $registro['codCargo'] = (int)$codCargo;
                $registro['codDepartamento'] = (int)$codDepartamento;

                // Asignar el turno y las fechas sin cambios
                $registro['turno'] = $turno;
                $registro['fechaIngreso'] = $fechaIngreso;
                $registro['fechaEgreso'] = $fechaEgreso;
                break;
            }
        }

        // Guardar los datos actualizados en el archivo JSON
        return $this->escribirArchivo($data);
    }

    // Mostrar un registro específico por su ID
    public function mostrar($codPersonal)
    {
        $data = $this->leerArchivo();

        foreach ($data as $registro) {
            if ($registro['codPersonal'] == $codPersonal) {
                return $registro;
            }
        }

        return null; // No se encontró el registro
    }

    // Listar personal con un formato específico
    public function listarPersonal()
    {
        $data = $this->listar();
        $resultados = [];

        foreach ($data as $registro) {
            $resultados[] = [
                'codPersonal' => $registro['codPersonal'],
                'datosPersonal' => 'V-' . $registro['cedula'] . ' ' . $registro['nombre1'] . ' ' . $registro['apellido1']
            ];
        }

        return $resultados;
    }

    // Listar personal por turno y especialidad
    public function listarPersonalTurno($turno, $especialidadSeleccionada)
    {
        $data = $this->listar();
        $resultados = [];

        foreach ($data as $registro) {
            if ($registro['turno'] == $turno && $registro['codEspecialidad'] == $especialidadSeleccionada) {
                $resultados[] = [
                    'codPersonal' => $registro['codPersonal'],
                    'datosPersonal' => 'V-' . $registro['cedula'] . ' ' . $registro['nombre1'] . ' ' . $registro['apellido1']
                ];
            }
        }

        return $resultados;
    }

    // Leer el archivo JSON
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
