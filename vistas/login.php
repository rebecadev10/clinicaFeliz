<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clinica vacaciones Felices</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Oswald:wght@200..700&display=swap" rel="stylesheet">

    <!-- traemos todos nuestros estilos -->
    <link rel="stylesheet" href="../public/css/base/base.css">
    <link rel="stylesheet" href="../public/css/componentes/mensaje/mensaje.css">
    <link rel="stylesheet" href="../public/css/componentes/personal/personal.css">
    <link rel="stylesheet" href="../public/css/componentes/personal/personalDetalle.css">
</head>

<body>

    <div class=" personalDetalle__container">
        <h2 class="personalDetalle__title">Iniciar Sesión</h2>
        <form action="../controlador/usuarios.php?op=login" method="post" class="personalDetalle__form">
            <div class="personalDetalle__flex  ">
                <label for="nombreUsuario">
                    <input class="personalDetalle__input" type="text" id="nombreUsuario" name="nombreUsuario" required>
                    <span>Nombre de Usuario:</span>
                </label>

            </div>
            <div class="personalDetalle__flex">
                <label for="clave">
                    <input class="personalDetalle__input" type="password" id="clave" name="clave" required>
                    <span>Contraseña</span>
                </label>
            </div>
            <div class="personalDetalle__flex">
                <button type="submit" class="personalDetalle__submit">Iniciar Sesión</button>
            </div>
        </form>
    </div>
</body>

</html>