<?php
require_once "../Modelo/Usuarios.php";




$usuario = new Usuario();
// recibimos los datos de nuestro formulario dependiendo del caso 
$codUsuario = isset($_POST["codUsuario"]) ? ($_POST["codUsuario"]) : "";
$codePersonal = isset($_GET["codPersonal"]) ? ($_GET["codPersonal"]) : "";
$codPersonal = isset($_POST["codPersonal"]) ? ($_POST["codPersonal"]) : "";
$nombreUsuario = isset($_POST["nombreUsuario"]) ? ($_POST["nombreUsuario"]) : "";
$clave = isset($_POST["clave"]) ? ($_POST["clave"]) : "";
$rol = isset($_POST["rol"]) ? ($_POST["rol"]) : "";
$nombreUsuario = isset($_POST['nombreUsuario']) ? $_POST['nombreUsuario'] : '';
$clave = isset($_POST['clave']) ? $_POST['clave'] : '';


switch ($_GET["op"]) {
    case 'guardarEditar':
        // Insertar o actualizar datos según la presencia de codCita
        if (empty($codUsuario)) {
            $rspta = $usuario->insertarDatos($codPersonal, $nombreUsuario, $clave, $rol);
            if ($rspta) {
                header("Location: ../vistas/mensaje.php?msg=success");
            } else {
                header("Location: ../vistas/mensaje.php?msg=errorRegistro");
            }
        } else {
            $rspta = $usuario->editarDatos($codUsuario, $codPersonal, $nombreUsuario, $clave, $rol);
            if ($rspta) {
                header("Location: ../vistas/mensaje.php?msg=updated");
            } else {
                header("Location: ../vistas/mensaje.php?msg=error");
            }
        }
        break;
    case 'verificarUsuario':
        $codigoPersonal = (int)$codePersonal;
        // Buscar si existe el usuario con ese codPersonal
        $resultado = $usuario->buscarPorCodPersonal($codigoPersonal);

        if ($resultado) {
            // Si se encontró el codPersonal, redirigir a usuarioDetalle.php con el codUsuario
            header("Location: ../vistas/usuarioDetalle.php?codUsuario=" . $resultado['codUsuario'] . '&codPersonal=' . $resultado['codPersonal']);
            exit();
        } else {
            // Si no se encontró el codPersonal, redirigir a usuario.php con el codPersonal
            header("Location: ../vistas/usuario.php?codPersonal=" . $codePersonal);
            exit();
        }
    case 'login':

        $usuario = $usuario->login($nombreUsuario, $clave);

        if ($usuario) {
            // Inicio de sesión exitoso
            session_start();
            $_SESSION['usuario'] = $usuario;
            $_SESSION['rol'] = $usuario['rol']; // Almacenar el rol del usuario

            header("Location: ../vistas/principal.php"); // Redirigir a la página principal después de iniciar sesión
            exit();
        } else {
            // Credenciales incorrectas

            header("Location: ../vistas/mensajeLogin.php?msg=ERROR");
            // header("Location: ../vistas/login.php");
            // exit();
        }
        break;
}
