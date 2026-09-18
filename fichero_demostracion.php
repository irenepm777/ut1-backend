<?php
date_default_timezone_set('Europe/Madrid');

$fechaActual = date('d/m/Y');
$horaActual = date('H:i:s');
$mensaje = 'El contenido de esta página ha sido generado dinámicamente con PHP.';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demostración de PHP dinámico</title>
</head>

<body>
    <header>
        <h1>Prueba de Concepto Backend</h1>
    </header>

    <main>
        <h2>Datos generados por el servidor</h2>

        <p>
            Fecha actual:
            <strong><?= htmlspecialchars($fechaActual, ENT_QUOTES, 'UTF-8') ?></strong>
        </p>

        <p>
            Hora actual:
            <strong><?= htmlspecialchars($horaActual, ENT_QUOTES, 'UTF-8') ?></strong>
        </p>

        <p>
            <?= htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8') ?>
        </p>

        <?php
        /*
         * htmlspecialchars() convierte caracteres especiales antes de mostrarlos como HTML.
         * Así el contenido no confiable pueda interpretarse como codigo HTML o JavaScript 
         * en el navegador, ayudando a prevenir XSS.
         */
        ?>
    </main>

    <footer>
        <p>Entorno local ejecutado mediante XAMPP</p>
    </footer>
</body>
</html>