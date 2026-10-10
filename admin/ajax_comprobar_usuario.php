<?php
// 1. Incluye el archivo de configuración con las credenciales para conectar a la base de datos.
include("conexion.php");

// 2. Extrae de forma automática las variables que lleguen por métodos HTTP (en este caso, rescata el "?usuario=" que mandó AJAX por GET).
extract($_REQUEST);

// 3. Intenta establecer la conexión física con el servidor de base de datos usando las variables del archivo de conexión.
$conexion = mysqli_connect($server_db, $usuario_db, "$password_db")
    or die("Error, no se puede realizar la conexion al Servidor");

// 4. Selecciona de manera específica la base de datos con la que se va a trabajar dentro del servidor.
mysqli_select_db($conexion, $base_db)
    or die("No se puede seleecionar la Base de Datos");

// 5. Configura la codificación de caracteres de la conexión a UTF-8 para evitar problemas con tildes o eñes.
mysqli_set_charset($conexion, "utf8");

// 6. Limpia y protege el texto recibido por la URL contra posibles ataques de Inyección SQL.
$usuario = mysqli_real_escape_string($conexion, $usuario);

// 7. Prepara la consulta SQL para buscar en la tabla 'usuarios' si ya existe un registro con el nombre de usuario tipeado.
$sql = "SELECT * FROM usuarios WHERE usuario='$usuario'";

// 8. Ejecuta la consulta contra la base de datos.
$res = mysqli_query($conexion, $sql);

// 9. Cuenta cuántas filas devolvió la consulta (si devuelve 1 o más, significa que el usuario ya existe).
$total = mysqli_num_rows($res);

// 10. Evalúa el resultado para responderle a AJAX de forma binaria o numérica.
if ($total > 0) {
    // 11. Si el total es mayor a 0, significa que el usuario ya está ocupado. Devuelve "1" al navegador.
    echo "1";
} else {
    // 12. Si el total es 0, significa que el nombre de usuario está libre. Devuelve "0" al navegador.
    echo "0";
}

// 13. Cierra la conexión abierta con el servidor de base de datos para liberar recursos del sistema.
mysqli_close($conexion);
?>