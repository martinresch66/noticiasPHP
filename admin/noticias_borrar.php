<?php
    // 1. Inicia o reanuda la sesión en el servidor para verificar que el usuario esté logueado.
    session_start();

    // 2. Extrae automáticamente todas las variables que lleguen por métodos HTTP (GET o POST, como el 'id_noticia' y la 'imagen' que viajan por la URL).
    extract($_REQUEST);

    // 3. Valida si existe la variable de sesión que certifica que el usuario está autenticado; si no, lo echa al index.php.
    if (!isset($_SESSION['usuario_logueado']))
        header("location:index.php");

    // 4. Incluye el archivo con los datos de configuración para la conexión a la base de datos.
    require("conexion.php");

    // 5. Conecta físicamente al servidor de base de datos usando las credenciales.
    $conexion = mysqli_connect($server_db, $usuario_db, $password_db)
        or die("No se puede conectar con el servidor");

    // 6. Selecciona de manera específica la base de datos con la que se va a trabajar.
    mysqli_select_db($conexion, $base_db)
        or die("No se puede seleccionar la base de datos");
    
    // 7. Prepara la instrucción SQL de tipo DELETE para borrar de la tabla 'noticias' únicamente el registro cuyo ID coincida con el que llegó por la URL.
    $instruccion="delete from noticias where id_noticia='$id_noticia'";

    // 8. BORRADO FÍSICO: La función 'unlink()' borra definitivamente un archivo del disco rígido del servidor. 
    // En este caso, concatena la ruta de la carpeta con el nombre de la foto que vino por la URL para eliminar la imagen asociada a esa noticia y no dejar basura ocupando espacio.
    unlink("../imagenes_subidas/".$imagen);

    // 9. Ejecuta la consulta SQL de eliminación en la base de datos.
    $consulta=mysqli_query($conexion,$instruccion);
    
    // 10. Cierra la conexión abierta con el servidor de base de datos para liberar recursos.
    mysqli_close($conexion);

    // 11. Redirige al usuario de regreso al listado de noticias, enviando un mensaje por la URL. 
    // (Nota: aquí dice "?mensaje=Guardo", pero al ser el script de borrado, lo ideal para ser prolijos sería cambiarlo por "?mensaje=Borrado").
    header("location:noticias.php?mensaje=Guardo");
?>