<?php
session_start(); // Iniciar sesión

// Verificar si la sesión de usuario está activa
if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
    $rol = isset($_SESSION['rol']) ? $_SESSION['rol'] : null; // Obtener el rol del usuario
} else {
    $rol = null; // No hay sesión activa, rol no definido
}
?>
<nav>
    <div class="navbar__container">
        <div class="navbar__container-items-left" role="menu">
            <a href="#" class="navbar__enlace" role="menuitem" tabindex="-1" id="user-menu-item-0">Inicio</a>
            <!-- Solo los administradores pueden acceder al módulo de personal -->
            <?php if ($rol === 'Administrador') { ?>
                <a href="personal.php?op=listar" class="navbar__enlace" role="menuitem" tabindex="-1" id="user-menu-item-1">Personal</a>
            <?php } ?>
            <a href="pacientes.php?op=listar" class="navbar__enlace" role="menuitem" tabindex="-1" id="user-menu-item-2">Pacientes</a>
            <a href="citas.php?op=listar" class="navbar__enlace" role="menuitem" tabindex="-1" id="user-menu-item-3">Citas</a>
        </div>
        <div class="navbar__container-items-right">
            <a href="../controlador/logout.php" class="navbar__enlace">Cerrar Sesión</a>
        </div>
    </div>
</nav>