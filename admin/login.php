<?php
    // Inicia o reanuda el sistema de sesiones de PHP para poder almacenar datos temporales del usuario.
    session_start();
   
    // Captura automáticamente todos los datos enviados por método GET o POST y los convierte en variables individuales.
    extract($_REQUEST);

    // Incluye el archivo de configuración externo que contiene los datos de acceso a la base de datos.
    require("conexion.php");

    // Línea comentada para depuración (servía para imprimir en pantalla todo lo que llegaba por la petición HTTP).
    //var_dump($_REQUEST);
    
    // Intenta establecer la conexión física con el servidor de MySQL usando las credenciales del archivo de conexión.
    $conexion = mysqli_connect ($server_db, $usuario_db,$password_db)
        // Si la conexión falla, detiene la ejecución del script por completo y muestra este mensaje de error.
        or die ("No se puede conectar con el servidor");

    // Selecciona la base de datos específica que vamos a utilizar dentro del servidor MySQL.
    mysqli_select_db ($conexion,$base_db)
        // Si no encuentra la base de datos seleccionada, detiene la ejecución con un mensaje.
        or die ("No se puede seleccionar la base de datos");

    // Limpia caracteres maliciosos del nombre de usuario para evitar ataques de Inyección SQL.
    $usuario=mysqli_real_escape_string($conexion,$usuario);

    // Limpia caracteres maliciosos de la contraseña para evitar ataques de Inyección SQL.
    $password=mysqli_real_escape_string($conexion,$password);

    // Validamos que el usuario tenga al menos 2 caracteres para poder extraer el salt
    if (strlen($usuario) < 2) {
        header("location:index.php?mensaje=Usuario y contraseña incorrecto");
        exit();
    }
    // Extrae los primeros 2 caracteres del nombre de usuario para usarlos como "semilla" (salt) de encriptación.
    $salt = substr ($usuario, 0, 2);

    /* crypt es una función que encripta un string dado ($usuario) a partir de un substring
    ($salt) que lo toma como semilla de encriptación en este caso son dos caracteres*/
   
    // Encripta la contraseña ingresada por el usuario utilizando la semilla ($salt) obtenida anteriormente.
    $clave_crypt = crypt ($password, $salt);/*HAY UN PROBLEMA SI PONGO LA CONTRASENIA guillermos en vez de guillermo me loguea igual!!!!!!!!!!!!!!!!!! */

    
    // Prepara la sentencia SQL para buscar en la tabla 'usuarios' donde coincidan el nombre y la clave encriptada.
    $instruccion = "select * from usuarios where usuario = '$usuario'" .
    " and password = '$clave_crypt'";

    // Ejecuta la consulta SQL anterior contra la base de datos.
    $consulta = mysqli_query ($conexion,$instruccion)
    // Si la consulta SQL falla por un error de sintaxis o de tabla, detiene la ejecución.
    or die ("Fallo en la consulta");

    // Cuenta cuántas filas o registros devolvió la consulta (será 1 si el usuario existe, o 0 si no coincide).
    $nfilas = mysqli_num_rows ($consulta);
    
    // Evalúa si se encontró al menos un resultado (es decir, si el usuario y la contraseña son correctos).
    if($nfilas>0)
    {
        // Extrae la fila de resultados de la base de datos y la convierte en un arreglo asociativo.
        $resultado=mysqli_fetch_array($consulta);

        // Guarda el nombre del usuario en la sesión activa del servidor.
        $_SESSION['nombre']=$resultado['nombre'];

        // Guarda el apellido del usuario en la sesión activa del servidor.
        $_SESSION['apellido']=$resultado['apellido'];

        // Guarda el ID único del usuario en la sesión para identificarlo en operaciones futuras.
        $_SESSION['id_usuario']=$resultado['id_usuario'];

        // Guardamos el rol que viene de la base de datos
        $_SESSION['tipo_usuario'] = $resultado['tipo_usuario'];

        // Crea una bandera de control que confirma que este navegador tiene una sesión de administración iniciada.
        $_SESSION['usuario_logueado']="SI";

        // Redirige automáticamente al usuario hacia el panel principal de control (home.php).
        header("location:home.php");
    }
    // Si la consulta devolvió 0 filas ($nfilas no es mayor a 0), significa que falló el acceso.
    else
    {
       // Opción alternativa comentada para guardar el mensaje de error en una variable de sesión.
       // $_SESSION['mensaje']="Usuario y contraseña incorrecto";

       // Redirige de regreso al formulario de login (index.php) adjuntando un mensaje de error por la URL.
        header("location:index.php?mensaje=Usuario y contraseña incorrecto");
    }
    
    // Cierra la conexión activa con el servidor MySQL para liberar recursos de memoria.
    mysqli_close($conexion);
?>