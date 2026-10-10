<?php
    // Inicia o reanuda el sistema de sesiones del servidor para poder identificar al usuario activo que va a salir.
    session_start();
   
    // Destruye y borra por completo todos los datos almacenados en la sesión actual (usuario logueado, nombre, ID, etc.).
    session_destroy();
   
    // Redirige automáticamente al navegador de vuelta a la pantalla de inicio de sesión (index.php).
    header("location:index.php");
?>