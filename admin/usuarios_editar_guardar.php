<?php
    session_start();
    extract($_REQUEST);
    if (!isset($_SESSION['usuario_logueado']))
        header("location:index.php");

    require("conexion.php");
    $conexion = mysqli_connect($server_db, $usuario_db, $password_db)
        or die("No se puede conectar con el servidor");
    mysqli_select_db($conexion, $base_db)
        or die("No se puede seleccionar la base de datos");

    // Limpiamos los datos
/* ESTO SERIA PARA EL METODO 1 PERO USAMOS METODO 2 PARA PRACTICAR OTRA FORMA
   $usuario = mysqli_real_escape_string($conexion, $usuario);
    $nombre = mysqli_real_escape_string($conexion, $nombre);
    $apellido = mysqli_real_escape_string($conexion, $apellido);
*/
    // Encriptamos la contraseña
    $salt = substr($usuario, 0, 2);
    $clave_crypt = crypt($password, $salt);

    // MÉTODO 2: Actualización con consulta preparada (Prepared Statement)
    // Usamos signos de interrogación (?) para los valores que van a ser enlazados de forma segura
    $instruccion = "UPDATE usuarios SET nombre = ?, apellido = ?, usuario = ?, password = ? WHERE id_usuario = ?";
    $stmt = mysqli_prepare($conexion, $instruccion);
    
    // Vinculamos los parámetros: 'ssssi' significa 4 strings (s) y 1 entero (i) para el id_usuario
    mysqli_stmt_bind_param($stmt, 'ssssi', $nombre, $apellido, $usuario, $clave_crypt, $id_usuario);
    
    // Ejecutamos la consulta preparada
    mysqli_stmt_execute($stmt);

    mysqli_close($conexion);
    header("location:usuarios.php?mensaje=Modificado");
?>