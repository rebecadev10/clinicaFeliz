<?php

class Conexiones
{
    protected $file;

    public function __construct($file)
    {
        $this->file = $file;
    }

    // Leer el archivo JSON
    protected function leerArchivo()
    {
        if (!file_exists($this->file)) {
            return []; // Retornar un array vacío si el archivo no existe
        }

        $data = file_get_contents($this->file);
        return json_decode($data, true); // Convertir el JSON a array asociativo
    }

    // Escribir en el archivo JSON
    protected function escribirArchivo($data)
    {
        $jsonData = json_encode($data, JSON_PRETTY_PRINT);
        $resultado = file_put_contents($this->file, $jsonData);
        return $resultado !== false; // Devuelve true si la escritura fue exitosa
    }
}
