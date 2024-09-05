<?php
session_start(); // Iniciar sesión

// Destruir la sesión
session_unset();
session_destroy();

// Redirigir al login
header("Location: ../vistas/login.php");
exit();
