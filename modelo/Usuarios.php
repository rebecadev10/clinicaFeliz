<?php
class Usuario
{
    private $file = '../data/usuarios.json';

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
    public function insertarDatos($codPersonal, $nombreUsuario, $clave, $rol)
    {
        $data = $this->readJson($this->file);



        // Determinar el siguiente codPersonal
        $ultimoId = 0;
        if (!empty($data)) {
            foreach ($data as $registro) {
                if (isset($registro['codUsuario']) && $registro['codUsuario'] > $ultimoId) {
                    $ultimoId = $registro['codUsuario'];
                }
            }
        }

        // Si no hay registros, el primer codPersonal será 1
        $nuevoCodUsuario = $ultimoId + 1;


        $codPersonal = (int)$codPersonal;
        // Crear un nuevo registro
        $nuevoRegistro = [
            "codUsuario" => $nuevoCodUsuario,
            "codPersonal" => $codPersonal,
            "NombreUsuario" => $nombreUsuario,
            "clave" => $clave,
            "rol" => $rol

        ];

        $data[] = $nuevoRegistro;
        $this->writeJson($this->file, $data);
        return true;
    }
    public function editarDatos($codUsuario, $codPersonal, $nombreUsuario, $clave, $rol)
    {
        // Leer el archivo JSON
        $data = $this->readJson($this->file);
        $codUsuario = (int)$codUsuario;
        $codPersonal = (int)$codPersonal;
        // Recorrer los registros para encontrar el que coincide con codPersonal
        foreach ($data as &$registro) {
            if ($registro['codUsuario'] == $codUsuario) {
                // Actualizar los datos del registro encontrado
                $registro['codPersonal'] = $codPersonal;
                $registro['NombreUsuario'] = $nombreUsuario;
                $registro['clave'] = $clave;
                $registro['rol'] = $rol;

                break;
            }
        }

        // Guardar los datos actualizados en el archivo JSON
        $this->writeJson($this->file, $data);
        return true;
    }



    public function buscarPorCodPersonal($codPersonal)
    {
        // Leer los datos del archivo JSON
        $data = $this->readJson($this->file);

        // Recorrer los registros para buscar el codPersonal
        foreach ($data as $registro) {
            if (isset($registro['codPersonal']) && $registro['codPersonal'] == $codPersonal) {
                // Retorna el codUsuario si encuentra el codPersonal
                return [
                    'codUsuario' => $registro['codUsuario'],
                    'codPersonal' => $registro['codPersonal']
                ];
            }
        }

        // Retorna null si no encuentra ningún registro con ese codPersonal
        return null;
    }
    public function mostrar($codUsuario)
    {
        // Leer los datos del archivo JSON
        $data = $this->readJson($this->file);

        // Filtrar el array para encontrar el usuario con el codUsuario específico
        $usuario = array_filter($data, fn($u) => $u['codUsuario'] == $codUsuario);

        // Si no se encontró ningún usuario, retornar null
        if (empty($usuario)) {
            return null;
        }

        // Extraer el primer elemento del array filtrado (debería haber solo uno)
        $usuario = reset($usuario);

        // Retornar la información del usuario encontrado
        return $usuario;
    }
    public function login($nombreUsuario, $clave)
    {
        $usuarios = $this->readJson($this->file);

        foreach ($usuarios as $usuario) {
            if ($usuario['NombreUsuario'] === $nombreUsuario && $usuario['clave'] === $clave) {
                return $usuario; // Retorna el usuario si las credenciales son correctas
            }
        }

        return null; // Retorna null si las credenciales son incorrectas
    }
}
