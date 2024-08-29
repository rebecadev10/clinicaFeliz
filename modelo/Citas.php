<?php

class Cita
{
    private $file = '../data/citas.json'; // Ruta al archivo JSON
    private $pacientesFile = '../data/pacientes.json';
    private $personalFile = '../data/personal.json';
    private $diagnosticosFile = '../data/datos/diagnosticos.json';

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

        // Verificar disponibilidad
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
        foreach ($citas as &$cita) {
            if ($cita['codCita'] == $codCita) {
                $cita['codPaciente'] = (int)$codPaciente;
                $cita['codPersonal'] = (int)$codPersonal;
                $cita['fechaCita'] = $fechaCita;
                $cita['horaCita'] = $horaCita;
                $cita['estado'] = $estado;
                $cita['codDiagnostico'] = (int)$codDiagnostico;
                $cita['observaciones'] = $observaciones;
                $this->writeJson($this->file, $citas);
                return true;
            }
        }
        return false;
    }

    public function mostrar($codCita)
    {
        $citas = $this->readJson($this->file);
        $pacientes = $this->readJson($this->pacientesFile);
        $personal = $this->readJson($this->personalFile);
        $diagnosticos = $this->readJson($this->diagnosticosFile);

        $cita = array_filter($citas, fn($c) => $c['codCita'] == $codCita);
        if (!$cita) {
            return null;
        }
        $cita = reset($cita);

        $paciente = array_filter($pacientes, fn($p) => $p['codPaciente'] == $cita['codPaciente']);
        $medico = array_filter($personal, fn($p) => $p['codPersonal'] == $cita['codPersonal']);
        $diagnostico = array_filter($diagnosticos, fn($d) => $d['codDiagnostico'] == $cita['codDiagnostico']);

        return [
            'codCita' => $cita['codCita'],
            'datosPaciente' => $paciente ? reset($paciente)['nombre'] : '',
            'datosPersonal' => $medico ? reset($medico)['nombre'] : '',
            'fechaCita' => $cita['fechaCita'],
            'estado' => $cita['estado'],
            'diagnostico' => $diagnostico ? reset($diagnostico)['desDiagnostico'] : '',
            'observaciones' => $cita['observaciones'],
        ];
    }

    public function listarDiagnosticos()
    {
        return $this->readJson($this->diagnosticosFile);
    }
}
