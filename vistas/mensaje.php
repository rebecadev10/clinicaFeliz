<?php
require 'componentes/header.php';
?>
<div class="mensajeContainer">
    <h6 class="mensajeTitulo">
        <?php

        if (isset($_GET['msg'])) {
            switch ($_GET['msg']) {
                case 'success':
                    echo "<p class='sucess'>Datos guardados exitosamente.</p>";
                    break;
                case 'successDelete':
                    echo "<p class='sucess'>Datos eliminados  correctamente.</p>";
                    break;

                case 'updated':
                    echo "<p class='sucess'>Datos actualizados exitosamente.</p>";
                    break;
                case 'eliminado':
                    echo "<p class='sucess'>Datos eliminados correctamente.</p>";
                    break;
                case 'error':
                    echo "<p class='error'>Hubo un error al procesar la solicitud.</p>";
                    break;
                case 'errorRegistro':
                    echo "<p class='error'>La cédula ingresada ya se encuentra registrada</p>";
                    break;
                case 'errorDelete':
                    echo "<p class='error'>No se puede eliminar la cita, porque la fecha ya pasó</p>";
                    break;
            }
        }

        ?>

    </h6>
    <div class="mensajeContainer__btn">
        <button class="mensaje__btn"><a href="principal.php" class="">Volver</a></button>
    </div>
</div>