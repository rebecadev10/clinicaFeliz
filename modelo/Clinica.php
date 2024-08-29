<?php

class Clinica
{

    private $rutaEspecialidades = '../data/datos/especialidades.json';
    private $rutaCargos = '../data/datos/cargos.json';
    private $rutaDepartamentos = '../data/datos/departamentos.json';

    public function __construct() {}

    private function leerDatos($ruta)
    {
        // Lee el archivo JSON y decodifica el contenido en un array
        if (file_exists($ruta)) {
            $json = file_get_contents($ruta);
            return json_decode($json, true); // Devuelve un array asociativo
        } else {
            return []; // Devuelve un array vacío si el archivo no existe
        }
    }

    public function listarEspecialidades()
    {
        return $this->leerDatos($this->rutaEspecialidades);
    }

    public function listarCargos()
    {
        return $this->leerDatos($this->rutaCargos);
    }

    public function listarDepartamentos()
    {
        return $this->leerDatos($this->rutaDepartamentos);
    }
}
