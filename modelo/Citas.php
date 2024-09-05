<?php

class Cita
{
    private $file = '../data/citas.json'; // Ruta al archivo JSON
    private $pacientesFile = '../data/pacientes.json';
    private $personalFile = '../data/personal.json';
    private $diagnosticosFile = '../data/datos/diagnosticos.json';

    private $departamentoFile = '../data/datos/departamentos.json';

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
        file_put_contents($filename, $json);
    }

    public function listar()
    {
        $citas = $this->readJson($this->file);
        $pacientes = $this->readJson($this->pacientesFile);
        $personal = $this->readJson($this->personalFile);
        $diagnosticos = $this->readJson($this->diagnosticosFile);

        $result = [];
        foreach ($citas as $cita) {
            $paciente = array_filter($pacientes, fn($p) => $p['codPaciente'] == $cita['codPaciente']);
            $medico = array_filter($personal, fn($p) => $p['codPersonal'] == $cita['codPersonal']);
            $diagnostico = array_filter($diagnosticos, fn($d) => $d['id'] == $cita['codDiagnostico']);

            $result[] = [
                'codCita' => $cita['codCita'],
                'cedulaPaciente' => $paciente ? reset($paciente)['cedula'] : '',
                'nombrePaciente' => $paciente ? reset($paciente)['nombre1'] : '',
                'nombrePersonal' => $medico ? reset($medico)['nombre2'] : '',
                'fechaCita' => $cita['fechaCita'],
                'horaCita' => $cita['horaCita'],
                'diagnostico' => $diagnostico ? reset($diagnostico)['descripcion'] : '',
                'observaciones' => $cita['observaciones'],
            ];
        }

        return $result;
    }

    public function insertarDatos($codCita, $codPaciente, $codPersonal, $fechaCita, $horaCita, $estado, $codDiagnostico, $observaciones)
    {
        $citas = $this->readJson($this->file);

        // Si no hay citas, el codCita será 1
        if (empty($citas)) {
            $codCita = 1;
        } else {
            // Si se está agregando una nueva cita sin un codCita específico, asignar el siguiente número disponible
            if ($codCita == 0) {
                // Obtener el mayor codCita existente y sumarle 1
                $maxCodCita = max(array_column($citas, 'codCita'));
                $codCita = $maxCodCita + 1;
            }
        }

        // Verificar disponibilidad de la cita para el mismo médico, fecha y hora
        $disponibilidad = array_filter($citas, fn($c) => $c['codPersonal'] == $codPersonal && $c['fechaCita'] == $fechaCita && $c['horaCita'] == $horaCita);
        if (count($disponibilidad) > 0) {
            // La cita ya existe
            return false;
        }

        // Insertar nueva cita
        $citas[] = [
            'codCita' => (int)$codCita,
            'codPaciente' => (int)$codPaciente,
            'codPersonal' => (int)$codPersonal,
            'fechaCita' => $fechaCita,
            'horaCita' => $horaCita,
            'estado' => $estado,
            'codDiagnostico' => (int)$codDiagnostico,
            'observaciones' => $observaciones,
        ];

        $this->writeJson($this->file, $citas);
        return true;
    }

    public function editarDatos($codCita, $codPaciente, $codPersonal, $fechaCita, $horaCita, $estado, $codDiagnostico, $observaciones)
    {
        $citas = $this->readJson($this->file);
        $updated = false; // Indicador para saber si se actualizó algún dato

        foreach ($citas as &$cita) {
            if ($cita['codCita'] == $codCita) {
                // Actualizar los datos de la cita
                $cita['codPaciente'] = (int)$codPaciente;
                $cita['codPersonal'] = (int)$codPersonal;
                $cita['fechaCita'] = $fechaCita;
                $cita['horaCita'] = $horaCita;
                $cita['estado'] = $estado;
                $cita['codDiagnostico'] = (int)$codDiagnostico;
                $cita['observaciones'] = $observaciones;
                $updated = true;
                break;
            }
        }

        if ($updated) {
            $this->writeJson($this->file, $citas);
            return true; // Se actualizó la cita
        } else {
            return false; // No se encontró la cita con el codCita dado
        }
    }


    public function mostrar($codCita)
    {
        $citas = $this->readJson($this->file);
        $pacientes = $this->readJson($this->pacientesFile);
        $personal = $this->readJson($this->personalFile);
        $diagnosticos = $this->readJson($this->diagnosticosFile);
        $departamentos = $this->readJson($this->departamentoFile);

        $cita = array_filter($citas, fn($c) => $c['codCita'] == $codCita);
        if (!$cita) {
            return null;
        }
        $cita = reset($cita);

        $paciente = array_filter($pacientes, fn($p) => $p['codPaciente'] == $cita['codPaciente']);
        $medico = array_filter($personal, fn($p) => $p['codPersonal'] == $cita['codPersonal']);

        // Verifica si se encontró un médico
        if ($medico) {
            $medico = reset($medico); // Obtener el primer (y único) médico encontrado
            if (is_array($medico)) {
                $departamento = array_filter($departamentos, fn($d) => $d['id'] == $medico['codDepartamento']);
            } else {
                $departamento = null;
            }
        } else {
            $medico = null;
            $departamento = null;
        }

        $diagnostico = array_filter($diagnosticos, fn($d) => $d['id'] == $cita['codDiagnostico']);

        return [
            'codCita' => $cita['codCita'],
            'idPaciente' => reset($paciente)['codPaciente'],
            'datosPaciente' => $paciente && is_array(reset($paciente)) ? 'V-' . reset($paciente)['cedula'] . ' ' . reset($paciente)['nombre1'] . ' ' . reset($paciente)['apellido1'] : '',
            'datosPersonal' => $medico && is_array($medico) ? 'V-' . $medico['cedula'] . ' ' . $medico['nombre1'] . ' ' . $medico['apellido1'] : '',
            'turno' => $medico && is_array($medico) ? $medico['turno'] : '',
            'especialidad' => $medico && is_array($medico) ? $medico['codEspecialidad'] : '',
            'fechaCita' => $cita['fechaCita'],
            'horaCita' => $cita['horaCita'],
            'estado' => $cita['estado'],
            'diagnostico' => $diagnostico && is_array(reset($diagnostico)) ? reset($diagnostico)['descripcion'] : '',
            'observaciones' => $cita['observaciones'],
            'descDepartamento' => $departamento && is_array(reset($departamento)) ? reset($departamento)['nombre'] : '',
        ];
    }

    public function listarDiagnosticos()
    {
        return $this->readJson($this->diagnosticosFile);
    }
    public function obtenerCitasPorCedula($cedula)
    {
        // Leer el archivo de pacientes para obtener el codPaciente
        $pacientes = $this->readJson($this->pacientesFile);
        $paciente = array_filter($pacientes, fn($p) => $p['cedula'] == $cedula);

        if (!$paciente) {
            return []; // No se encontró el paciente con la cédula proporcionada
        }

        $paciente = reset($paciente);
        $codPaciente = $paciente['codPaciente'];

        // Leer las citas y filtrar por el codPaciente
        $citas = $this->readJson($this->file);
        $citasPaciente = array_filter($citas, fn($cita) => $cita['codPaciente'] == $codPaciente);

        // Leer los archivos adicionales necesarios
        $personal = $this->readJson($this->personalFile);
        $diagnosticos = $this->readJson($this->diagnosticosFile);

        // Añadir datos adicionales a cada cita
        foreach ($citasPaciente as &$cita) {
            $medico = array_filter($personal, fn($p) => $p['codPersonal'] == $cita['codPersonal']);
            $diagnostico = array_filter($diagnosticos, fn($d) => $d['id'] == $cita['codDiagnostico']);

            $cita['nombrePersonal'] = $medico ? reset($medico)['nombre1'] . ' ' . reset($medico)['apellido1'] : 'No disponible';
            $cita['diagnostico'] = $diagnostico ? reset($diagnostico)['descripcion'] : 'No disponible';
        }

        // Ordenar las citas por fecha (y opcionalmente por hora)
        usort($citasPaciente, function ($a, $b) {
            $fechaHoraA = strtotime($a['fechaCita'] . ' ' . $a['horaCita']);
            $fechaHoraB = strtotime($b['fechaCita'] . ' ' . $b['horaCita']);
            return $fechaHoraA - $fechaHoraB;
        });

        return $citasPaciente;
    }
    public function eliminarDatos($codCita)
    {
        $citas = $this->readJson($this->file);

        // Buscar la cita por el código dado
        $cita = array_filter($citas, function ($cita) use ($codCita) {
            return $cita['codCita'] == $codCita;
        });

        if (empty($cita)) {
            return ['status' => false, 'message' => 'Cita no encontrada.'];
        }

        $cita = reset($cita); // Obtener la primera (y única) cita encontrada

        // Obtener la fecha y hora de la cita desde el archivo JSON
        $fechaCita = $cita['fechaCita'];
        $horaCita = $cita['horaCita'];

        // Obtener la fecha y hora actual en formato string
        $fechaActual = date('Y-m-d');
        $horaActual = date('H:i:s');

        // Convertir fechas y horas a timestamps para comparar
        $timestampCita = strtotime($fechaCita . ' ' . $horaCita);
        $timestampActual = strtotime($fechaActual . ' ' . $horaActual);

        // Debug: Verificar los valores de timestamp
        error_log("Timestamp Cita: $timestampCita");
        error_log("Timestamp Actual: $timestampActual");

        // Comparar los timestamps
        if ($timestampCita <= $timestampActual) {
            // La cita ya ha pasado o es hoy, no se puede eliminar
            return ['status' => false];
        } else {
            // Filtrar las citas para excluir la que queremos eliminar
            $citas = array_filter($citas, function ($cita) use ($codCita) {
                return $cita['codCita'] != $codCita;
            });

            // Reindexar el array para asegurarse de que las claves sean continuas (opcional)
            $citas = array_values($citas);

            // Escribir los datos actualizados al archivo JSON
            $this->writeJson($this->file, $citas);

            return ['status' => true];
        }
    }
}
