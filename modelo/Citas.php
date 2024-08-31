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
}
