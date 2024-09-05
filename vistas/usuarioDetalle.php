<?php
require 'componentes/header.php';

require '../modelo/Personal.php';
require '../modelo/Usuarios.php';
$codPersonal = isset($_GET["codPersonal"]) ? $_GET["codPersonal"] : "";
$codUsuario = isset($_GET["codUsuario"]) ? $_GET["codUsuario"] : "";
// Instancias de los modelos
$personal = new Personal();
$usuario = new Usuario();
// mostrar los datos del usuario
$usuarioData = $usuario->mostrar($codUsuario);
if (!empty($codPersonal)) {
    // Obtener los datos del personal desde el modelo
    $personalData = $personal->mostrar($codPersonal);

    if ($personalData) {
        $cedula = $personalData['cedula'];
        $nombre1 = $personalData['nombre1'];
        $apellido1 = $personalData['apellido1'];
    } else {
        echo "<p>No se encontró información del personal con el código proporcionado.</p>";
        exit();
    }
} else {
    echo "<p>Código de personal no proporcionado.</p>";
    exit();
}






?>

<div class="personalDetalle__container">
    <div>
        <!-- Formulario de registro de cita -->
        <form action="../controlador/usuarios.php?op=guardarEditar" method="post" class="personalDetalle__form">
            <p class="personalDetalle__title">Creacion de usuarios </p>
            <p class="personalDetalle__message">Formulario de registro para usuario del sistema</p>
            <p class="avisoDetalle">Personal:</p>
            <span> <?php echo 'V-' . $cedula . ' ' . $nombre1 . ' ' . $apellido1 ?></span>

            <div class="personalDetalle__flex">
                <label>
                    <input type="hidden" value="<?php echo $codPersonal; ?>" name="codPersonal">
                    <input type="hidden" value="<?php echo $codUsuario; ?>" name="codUsuario">
                    <input class="personalDetalle__input" type="text" value="<?php echo $usuarioData['NombreUsuario']; ?>" name="nombreUsuario" placeholder="">
                    Nombre de Usuario:
                </label>
                <label>
                    <input class="personalDetalle__input" type="password" name="clave" value="<?php echo $usuarioData['clave']; ?>" placeholder="">
                    Clave:
                </label>
            </div>
            <div class="personalDetalle__select-container">
                <label>


                    <span>Asignar Rol:</span>
                </label>
                <select name="rol" class="personalDetalle__select">
                    <option value="" disabled <?php echo empty($usuarioData['rol']) ? 'selected' : ''; ?>>Seleccione una opción</option>
                    <option value="Medico" <?php echo ($usuarioData['rol'] === 'Medico') ? 'selected' : ''; ?>>Medico</option>
                    <option value="Enfermero" <?php echo ($usuarioData['rol'] === 'Enfermero') ? 'selected' : ''; ?>>Enfermero</option>
                    <option value="Administrador" <?php echo ($usuarioData['rol'] === 'Administrador') ? 'selected' : ''; ?>>Administrador</option>

                </select>
            </div>

            <div class="personalDetalle__botones">
                <button class="personalDetalle__cancel"><a href="pacientes.php?op=listar">Cancelar</a></button>
                <button type="submit" class="personalDetalle__submit">Guardar</button>
            </div>
        </form>
    </div>
</div>