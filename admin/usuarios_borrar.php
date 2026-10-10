<?php
    session_start();
    extract($_REQUEST);

    // REGLA DE SEGURIDAD: Solo los administradores pueden borrar usuarios
    if (!isset($_SESSION['usuario_logueado']) || $_SESSION['tipo_usuario'] != 'admin') {
        header("location:index.php");
        exit();
    }

    require("conexion.php");

    $conexion = mysqli_connect($server_db,$usuario_db,$password_db)
        or die("no se puede conectar con el servidor");

    mysqli_select_db($conexion, $base_db)
        or die("No se puede seleccionar la base de datos");

    $instruccion = "delete from usuarios where id_usuario ='$id_usuario'";

    $consulta = mysqli_query($conexion,$instruccion);

    mysqli_close($conexion);

    header("location:usuarios.php?mensaje=" . urlencode("Usuario borrado correctamente"));
    exit();
?>