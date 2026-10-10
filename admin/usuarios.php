<?php
    // 1. Inicia o reanuda la sesión del servidor para verificar que el usuario esté logueado.
    session_start();

    // 2. Extrae las variables que puedan llegar por petición (por ejemplo, mensajes de éxito en la URL).
    extract($_REQUEST);

    // 3. Valida si el usuario está autenticado; si no, lo expulsa al login.
    if (!isset($_SESSION['usuario_logueado']))
        header("location:index.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link href="../lib/bootstrap-5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="../lib/bootstrap-5.3.2/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container-fluid"><!--class ="container" es una clase de bootstrap,Crea una caja centrada que deja márgenes vacíos a los lados en pantallas grandes (computadoras), adaptándose por saltos (breakpoints).-->
        <?php require("menu.php");?>
        <h1>Usuarios</h1>
        <?php 
            if(isset($mensaje)){
                print("<h3 style='color:#cc00ff'>".$mensaje."</h3>");
            } 
        ?>
        <a href="usuarios_nueva.php" class = "btn btn-primary">Nuevo Usuario</a>   
    </div>

     <table class="table">
        <tr>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Usuario</th>
            <th>Tipo de Usuario</th>
            <th>editar</th>
            <th>borrar</th>
        </tr>
        <?php
            require("conexion.php");
            $conexion = mysqli_connect($server_db, $usuario_db, $password_db)
                or die("No se puede conectar con el servidor");
            mysqli_select_db($conexion, $base_db)
                or die("No se puede seleccionar la base de datos");
            $instruccion="select * from usuarios order by id_usuario desc";
            //trabajar con super usuario y discriminacion de usuarios
            /*
            if(isset($_SESSION['SUPER']))
                $instruccion="select * from noticias order by fecha desc";
                else
                $instruccion="select * from noticias where id_usuario=".$_SESSION['id_usuario']." order by fecha desc";
        */
                $consulta=mysqli_query($conexion,$instruccion) or die("no puedo consultar");
        
                $nfilas=mysqli_num_rows($consulta);
            for($i=0;$i<$nfilas;$i++)
            {
                $resultado=mysqli_fetch_array($consulta);
                print('
                <tr>
                    <td>'.trim($resultado['nombre']).'</td>
                    <td>'.trim($resultado['apellido']).'</td>
                    <td>'.trim($resultado['usuario']).'</td>
                    <td>'.trim($resultado['tipo_usuario']).'</td>
                    <td><a href="usuarios_editar.php?id_usuario='.$resultado['id_usuario'].'" class="btn btn-secondary">editar</a></td>
                    <!--&quot escribe comillas dobles ya que hay muchas comillas se confunde el programa si pusiese " " -->
                    <td><a href="usuarios_borrar.php?id_usuario='.$resultado['id_usuario'].'" class="btn btn-danger" onclick="return confirm(&quot; Desea eliminar el usuario? &quot;)">borrar</a></td>
                </tr>
                
                ');
            }
            mysqli_close($conexion);
        ?>
    </table>

    
</body>
</html>