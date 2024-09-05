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

<body></body>
<div class="mensajeContainer">
    <h6 class="mensajeTitulo">
        <?php

        if (isset($_GET['msg'])) {
            switch ($_GET['msg']) {

                case 'ERROR':
                    echo "<p class='error'>Hubo un error al procesar la solicitud.</p>";
                    break;
            }
        }

        ?>

    </h6>
    <div class="mensajeContainer__btn">
        <button class="mensaje__btn"><a href="login.php" class="">Volver a Iniciar Sesion</a></button>
    </div>
</div>
</body>

</html>