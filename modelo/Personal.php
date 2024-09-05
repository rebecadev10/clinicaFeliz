<?php

class Personal
{
    private $file = '../data/personal.json'; // Ruta al archivo JSON
    private $citas = '../data/citas.json';

    // archivos de definicion
    private $especialidadesFile = '../data/datos/especialidades.json';
    private $cargosFile = '../data/datos/cargos.json';
    private $departamentoFile = '../data/datos/departamentos.json';
    public function __construct() {}

    // Leer y devolver todos los registros 
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


    // Leer y devolver todos los registros de personal public function listar()
    public function listar()
    {
        $personal = $this->readJson($this->file);
        $especialidades = $this->readJson($this->especialidadesFile);
        $cargos = $this->readJson($this->cargosFile);
        $departamentos = $this->readJson($this->departamentoFile);

        $result = [];
        foreach ($personal as $p) {
            $especialidad = array_filter($especialidades, fn($e) => $e['id'] == $p['codEspecialidad']);
            $cargo = array_filter($cargos, fn($c) => $c['id'] == $p['codCargo']);
            $departamento = array_filter($departamentos, fn($d) => $d['id'] == $p['codDepartamento']);

            $result[] = [
                'codPersonal' => $p['codPersonal'],
                'cedula' => $p['cedula'],
                'nombre1' => $p['nombre1'],
                'nombre2' => $p['nombre2'],
                'apellido1' => $p['apellido1'],
                'apellido2' => $p['apellido2'],
                'codEspecialidad' => $p['codEspecialidad'],
                'especialidad' => $especialidad ? reset($especialidad)['nombre'] : '',
                'cargo' => $cargo ? reset($cargo)['nombre'] : '',
                'departamento' => $departamento ? reset($departamento)['nombre'] : '',
                'turno' => $p['turno'],
                'disponibilidad' => $p['disponibilidad']

            ];
        }

        return $result;
    }
    // Insertar un nuevo registro en el archivo JSON
    public function insertarDatos($cedula, $nombre1, $nombre2, $apellido1, $apellido2, $codEspecialidad, $codCargo, $codDepartamento, $turno, $fechaIngreso, $fechaEgreso)
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
            "fechaEgreso" => $fechaEgreso,
            "disponibilidad" => 'SI'
        ];

        $data[] = $nuevoRegistro;
        $this->writeJson($this->file, $data);
        return true;
    }


    // Actualizar un registro existente en el archivo JSON
    public function editarDatos($codPersonal, $cedula, $nombre1, $nombre2, $apellido1, $apellido2, $codEspecialidad, $codCargo, $codDepartamento, $turno, $fechaIngreso, $fechaEgreso)
    {
        // Leer el archivo JSON
        $data = $this->readJson($this->file);


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
        $this->writeJson($this->file, $data);
        return true;
        // Guardar los datos actualizados en el archivo JSON

    }

    // Mostrar un registro específico por su ID
    public function mostrar($codPersonal)
    {
        $data = $this->readJson($this->file);

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
    public function listarPersonalTurno($turnoSeleccionado, $especialidad)
    {
        // Obtener todos los registros de personal
        $data = $this->listar();
        $resultados = [];

        foreach ($data as $registro) {
            // Verificar que el turno y especialidad coincidan, y que la disponibilidad sea "SI"
            if (
                $registro['turno'] == $turnoSeleccionado
                && $registro['codEspecialidad'] == $especialidad
                && $registro['disponibilidad'] == 'SI'
            ) {

                $resultados[] = [
                    'codPersonal' => $registro['codPersonal'],
                    'datosPersonal' => 'V-' . $registro['cedula'] . ' ' . $registro['nombre1'] . ' ' . $registro['apellido1']
                ];
            }
        }

        return $resultados;
    }

    public function verificarCitas($codPersonal)
    {
        $citas = $this->readJson($this->citas);
        foreach ($citas as $cita) {
            if ($cita['codPersonal'] == $codPersonal) {
                return true; // El personal tiene citas asignadas
            }
        }
        return false; // El personal no tiene citas asignadas
    }

    public function eliminar($codPersonal)
    {
        // Leer los datos actuales del archivo JSON
        $data = $this->readJson($this->file);

        // Verificar datos antes de la eliminación
        error_log('Datos antes de la eliminación: ' . json_encode($data, JSON_PRETTY_PRINT));

        // Filtrar los registros para excluir el registro con el codPersonal especificado
        $data = array_filter($data, function ($registro) use ($codPersonal) {
            return $registro['codPersonal'] != $codPersonal;
        });

        // Reindexar el array para evitar posibles problemas de claves
        $data = array_values($data);

        // Verificar datos después de la "eliminación"
        error_log('Datos después de la eliminación: ' . json_encode($data, JSON_PRETTY_PRINT));

        // Escribir los datos actualizados en el archivo JSON
        $resultadoEscritura = $this->writeJson($this->file, $data);

        if (!$resultadoEscritura) {
            error_log('Error al escribir el archivo JSON después de la eliminación.');
        }

        return $resultadoEscritura;
    }




    public function actualizarEgreso($codPersonal, $fechaEgreso, $disponibilidad)
    {
        $data = $this->readJson($this->file);

        foreach ($data as &$registro) {
            if ($registro['codPersonal'] == $codPersonal) {
                $registro['fechaEgreso'] = $fechaEgreso;
                $registro['disponibilidad'] = $disponibilidad;
                break;
            }
        }

        $this->writeJson($this->file, $data);
        return true;
    }
    public function obtenerPersonalDisponible()
    {
        $data = $this->listar();
        $resultados = [];

        foreach ($data as $registro) {
            // Verificar que el personal tenga disponibilidad  "SI"
            if (
                $registro['disponibilidad'] == 'SI'
            ) {
                // devolvemos el personal disponible
                $resultados[] = [
                    'codPersonal' => $registro['codPersonal'],
                    'datosPersonal' => 'V-' . $registro['cedula'] . ' ' . $registro['nombre1'] . ' ' . $registro['apellido1']
                ];
            }
        }

        return $resultados;
    }
}
