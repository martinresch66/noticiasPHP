<?php
    // 1. Inicia o reanuda la sesión del servidor para poder acceder a las variables temporales (como el ID del usuario logueado).
    session_start();
      
    // 2. Extrae y convierte en variables independientes todos los datos que llegaron por la petición HTTP (vía POST o GET).
    extract($_REQUEST);

    // 3. Valida si existe la variable de sesión 'usuario_logueado'. Si no existe (nadie inició sesión)...
    /*esto sirve cuando quier poner en la url http://localhost/2026/noticiasPHP/admin/noticias_nuevas.php me redirige a loguearme ya que si no 
    seria una vulnerabilidad que alguien agregue noticias sin loguearse */
    if (!isset($_SESSION['usuario_logueado']))
        header("location:index.php");

    // 4. Incluye el archivo de configuración externo que contiene los datos de acceso a la base de datos.
    require("conexion.php");

    // 5. Establece la conexión física con el servidor de MySQL usando las credenciales del archivo anterior.
    $conexion = mysqli_connect($server_db, $usuario_db, $password_db)
        // Si la conexión falla, detiene la ejecución del script por completo y muestra un mensaje de error.
        or die("No se puede conectar con el servidor");

    // 6. Selecciona específicamente la base de datos que se va a utilizar en el servidor.
    mysqli_select_db($conexion, $base_db)
        // Si no se encuentra la base de datos, detiene la ejecución con un mensaje de error.
        or die("No se puede seleccionar la base de datos");

    // 7. Obtiene la fecha actual del servidor en formato Año-Mes-Día (ej: 2026-10-09) para registrar cuándo se creó la noticia.
    $fecha = date("Y-m-d");

    // 8. Recupera el ID único del administrador que está creando la noticia a partir de la sesión activa.
    $id_usuario = $_SESSION['id_usuario'];

    // --- MÉTODO 1: LIMPIEZA Y SEGURIDAD DE TEXTOS ---
    // 9. Escapa caracteres especiales en el título para prevenir ataques de Inyección SQL.
    $titulo = mysqli_real_escape_string($conexion, $titulo);
    /*
        Por ejemplo, si el usuario escribe:
        O'Connor

        La función mysqli_real_escape_string lo transforma en:
        O\'connor 
        PARA EVITAR INYECCIONES SQL MALINTENCIONADAS(buscando caracteres especiales y agregandole \)
    */
    
    // 10. Escapa caracteres especiales en el copete (resumen) de la noticia.
    $copete = mysqli_real_escape_string($conexion, $copete);
    
    // 11. Escapa caracteres especiales en el cuerpo (texto largo formateado por Summernote).
    $cuerpo = mysqli_real_escape_string($conexion, $cuerpo);

    // --- LÓGICA DE SUBIDA DE IMAGEN ---
    // 12. Inicializa una bandera (interruptor) booleana en falso para controlar si se debe copiar el archivo o no.
    $copiarArchivo = false;


    // PARA ENTENDER ESTO IR AL ARCHIVO explicacion_subir_imagen.txt que esta en esta misma carpeta(noticiasPHP)!!!!!!!!!!!

    // 13. Comprueba mediante PHP si se subió correctamente un archivo temporal en el campo 'imagen' del formulario.
    if(is_uploaded_file($_FILES['imagen']['tmp_name']))
    {
        // 14. Define la carpeta física del servidor donde se almacenarán las imágenes subidas.
        $nombreDirectorio = "../imagenes_subidas/";
        
        // 15. Genera un número único basado en la marca de tiempo actual (timestamp con 'time()').
        $idUnico = time();
        
        // 16. Crea un nombre único combinando el timestamp y el nombre original del archivo (ej: 17182839-foto.jpg) para evitar que dos fotos iguales se sobrescriban.
        $nombrefichero = $idUnico . "-" . $_FILES['imagen']['name'];
        
        // 17. Cambia la bandera a verdadero porque el archivo existe y está listo.
        $copiarArchivo = true;
    }
    else 
        // 18. Si el usuario no adjuntó ninguna imagen, deja la variable del nombre del fichero vacía.
       $nombrefichero = "";
   
    // 19. Si la bandera es verdadera, traslada físicamente el archivo desde la ubicación temporal de PHP hacia la carpeta definitiva en el disco.
    if($copiarArchivo)
        move_uploaded_file($_FILES['imagen']['tmp_name'], $nombreDirectorio . $nombrefichero);
    
    // --- INSERCIÓN EN LA BASE DE DATOS ---
    // 20. Prepara la instrucción SQL de tipo INSERT para guardar todos los datos recolectados en la tabla 'noticias'.
    $instruccion = "insert into noticias (titulo, copete, cuerpo, imagen, categoria, id_usuario, fecha) values ('$titulo', '$copete', '$cuerpo', '$nombrefichero', '$categoria', '$id_usuario', '$fecha')";
    
    // 21. Ejecuta la consulta SQL en la base de datos; si la inserción falla, corta la ejecución y muestra un mensaje de error.
    $consulta = mysqli_query($conexion, $instruccion) 
            or die("no pudo insertar");

    // --- MÉTODO 2 (ALTERNATIVO Y COMENTADO) ---
    /*PARA ENTENDER ESTE METODO IR A explicacion_Metodo2_Evitar_Inyeccion_SQL.txt */
    // El profesor dejó de ejemplo este bloque alternativo usando "Consultas Preparadas" (Prepared Statements), que es una forma mucho más moderna y segura de evitar la Inyección SQL sin usar mysqli_real_escape_string.
    /*
    $stmt = mysqli_prepare($conexion, "insert into noticias (titulo,copete,cuerpo,imagen,categoria,id_usuario,fecha) values (?,?,?,?,?,?,?)");
    mysqli_stmt_bind_param($stmt, 'sssssds', $titulo, $copete, $cuerpo, $imagen, $categoria, $id_usuario, $fecha);
    mysqli_stmt_execute($stmt);
    */

    // 22. Cierra la conexión activa con el servidor de MySQL para liberar memoria y recursos del sistema.
    mysqli_close($conexion);

    // 23. Redirige al usuario de vuelta al listado general de noticias (noticias.php) y le adjunta un mensaje de éxito por la URL.
    header("location:noticias.php?mensaje=Guardo");
?>