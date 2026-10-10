<?php
    session_start();
        extract($_REQUEST);
    if (!isset($_SESSION['usuario_logueado'])){
        header("location:index.php");
        exit();
    }

    require("conexion.php");
    $conexion = mysqli_connect($server_db, $usuario_db, $password_db)
        or die("No se puede conectar con el servidor");
    mysqli_select_db($conexion, $base_db)
        or die("No se puede seleccionar la base de datos");

    // 1. Verificamos permisos antes de actualizar la base de datos
    $sql_check = "SELECT id_usuario FROM noticias WHERE id_noticia = '$id_noticia'";
    $res_check = mysqli_query($conexion, $sql_check);
    
    if (mysqli_num_rows($res_check) == 0) {
        mysqli_close($conexion);
        header("location:noticias.php?mensaje=Error de operacion");
        exit();
    }

    $row_noticia = mysqli_fetch_array($res_check);


    // 2. ¿Es admin o el dueño?
    if ($_SESSION['tipo_usuario'] != 'admin' && $_SESSION['id_usuario'] != $row_noticia['id_usuario']) {
        mysqli_close($conexion);
        header("location:noticias.php?mensaje=" . urlencode("Acceso no autorizado"));
        exit();
    }

    // 3. Limpieza de datos
    $titulo = mysqli_real_escape_string($conexion, $titulo);
    $copete = mysqli_real_escape_string($conexion, $copete);
    $cuerpo = mysqli_real_escape_string($conexion, $cuerpo);

    //subir imagen
    $copiarArchivo=false;
    if(is_uploaded_file($_FILES['imagen']['tmp_name']))
    {
        $nombreDirectorio="../imagenes_subidas/";
        $idUnico=time();
        $nombrefichero=$idUnico. "-" .$_FILES['imagen']['name'];
        $copiarArchivo=true;
    }
        else 
         $nombrefichero=$imagencita;
   
         if($copiarArchivo){
            unlink($nombreDirectorio.$imagencita);
            move_uploaded_file($_FILES['imagen']['tmp_name'],$nombreDirectorio.$nombrefichero);
        }
        
    // 4. Ejecución del UPDATE
    $instruccion="update noticias set titulo='$titulo',copete='$copete',cuerpo='$cuerpo',imagen='$nombrefichero',categoria='$categoria' where id_noticia='$id_noticia'";
    $consulta=mysqli_query($conexion,$instruccion) 
            or die("no pudo insertar");
    
    mysqli_close($conexion);
    header("location:noticias.php?mensaje=Guardo&id_noticia=".$id_noticia);
?>  