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
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link href="../lib/bootstrap-5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="../lib/bootstrap-5.3.2/js/bootstrap.bundle.min.js"></script>

</head>

<body>
    <div class="container-fluid"><!--clase de bootstrap,Crea un contenedor que ocupa el 100% del ancho de la pantalla, de lado a lado, sin importar si estás en un monitor gigante o en un celular. Se estira de forma fluida.-->
       <?php require("menu.php");?>
       <h1>Noticias</h1>
       <?php
            if(isset($mensaje))
                print("<h3 style='color:#cc00ff'>".$mensaje."</h3>");
       ?>
       <a href="noticias_nueva.php" class="btn btn-primary">Nueva Noticia</a>
    </div>

<?php 
        // 1. Evalúa si la variable 'mensaje' está presente en la URL (método GET). 
        // Esto ocurre cuando se redirige con un parámetro como ?mensaje=Borrado exitoso.
        if (isset($_GET['mensaje'])){
?> 
    

            <!-- 2. Si la condición anterior es verdadera, imprime este contenedor div estilizado 
                con clases de Bootstrap para mostrar una alerta visual ("alert", "alert-warning" para color amarillo, 
                "alert-dismissible" para permitir cerrarla, y "fade show" para que tenga un efecto visual suave al aparecer). -->
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                
                <?php 
                    // 3. Imprime en pantalla el texto del mensaje que viajó por la URL. 
                    // La función 'htmlspecialchars()' es fundamental por seguridad: convierte caracteres especiales 
                    // en entidades HTML válidas, evitando ataques de tipo XSS (Cross-Site Scripting) 
                    // por si alguien intenta inyectar código malicioso en la URL.
                    echo htmlspecialchars($_GET['mensaje']); 
                ?>

                <!-- 4. Dibuja el botón con forma de "X" (cierre) en la esquina derecha de la alerta. 
                    Los atributos de Bootstrap 'data-bs-dismiss="alert"' le dan la funcionalidad de JavaScript 
                    para que, al hacerle clic, la alerta desaparezca de la pantalla automáticamente. -->
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            
            </div>
<?php 
        }
?>

    <table class="table">
        <tr>
            <th>titulo</th>
            <th>Copete</th>
            <th>editar</th>
            <th>borrar</th>
        </tr>
    <?php
        require("conexion.php");
        $conexion = mysqli_connect($server_db, $usuario_db, $password_db)
            or die("No se puede conectar con el servidor");
        mysqli_select_db($conexion, $base_db)
            or die("No se puede seleccionar la base de datos");
         $instruccion="select * from noticias  order by fecha desc";
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
                <td>'.trim($resultado['titulo']).'</td>
                <td>'.substr($resultado['copete'],0,50).'...</td>
                
            ');

            // Condición visual: Solo mostramos el botón de borrar si es admin o si el id_usuario coincide con el dueño de la noticia
            if ($_SESSION['tipo_usuario'] == 'admin' || $_SESSION['id_usuario'] == $resultado['id_usuario']) {
                print('<td><a href="noticias_editar.php?id_noticia='.$resultado['id_noticia'].'" class="btn btn-secondary">editar</a></td>');
                print('<td><a href="noticias_borrar.php?id_noticia='.$resultado['id_noticia'].'&imagen='.$resultado['imagen'].'" class="btn btn-danger" onclick="return confirm(&quot;¿Desea eliminar?&quot;)">borrar</a></td>');
            } else {
                print('<td><span class="text-muted">Sin permisos</span></td>');
                print('<td><span class="text-muted">Sin permisos</span></td>');
            }

            print('</tr>');
        }
        mysqli_close($conexion);
    ?>
    </table>
</body>

</html>