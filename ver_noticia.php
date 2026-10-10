<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <!-- Carga Bootstrap -->
    <link href="lib/bootstrap-5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="lib/bootstrap-5.3.2/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container-fluid">
        <?php // require("menu.php"); ?>
        <h1>Noticias</h1>
        <h1>Mi diario</h1>
        <div class="row">
        <?php
        // Extrae automáticamente todas las variables que lleguen por métodos HTTP (GET o POST, como el id_noticia por la URL)
        extract($_REQUEST);

        // Incluye los datos de conexión
        require("admin/conexion.php");

        // Conecta al servidor de base de datos
        $conexion = mysqli_connect($server_db, $usuario_db, $password_db)
            or die("No se puede conectar con el servidor");

        // Selecciona la base de datos
        mysqli_select_db($conexion, $base_db)
            or die("No se puede seleccionar la base de datos");

        // Prepara la consulta SQL para buscar UNICAMENTE la noticia cuyo id coincida con el que viajó por la URL
        $instruccion = "select * from noticias  where id_noticia=".$id_noticia;

        // Ejecuta la consulta en la base de datos
        $consulta = mysqli_query($conexion, $instruccion) or die("no puedo consultar");

        $nfilas = mysqli_num_rows($consulta);
        for ($i = 0; $i < $nfilas; $i++) {
            $resultado = mysqli_fetch_array($consulta);
            
             // Segunda consulta: como en la noticia solo tenemos el id_usuario, buscamos en la tabla usuarios el nombre del autor
             $inst2="select * from usuarios where id_usuario='".$resultado['id_usuario']."'";
             $consulta2=mysqli_query($conexion, $inst2) or die("no puedo consultar");
             $autor = mysqli_fetch_array($consulta2);

             // PROTECCIÓN: Verificamos si la consulta del autor trajo datos (si $autor existe y no está vacío),
             /*no se usa la variable nombreautor pero se ermplazaria en la estructura del HTML y funcionaria, dejo asi porque el profe lo hizo asi */
             if ($autor) {
                 $nombreAutor = $autor['nombre'] . " " . $autor['apellido'];
             } else {
                 $nombreAutor = "Autor desconocido";
             }

             // Imprime la estructura HTML expandida para mostrar la noticia completa
            print('
            <div class="col-12">
                <div class="card">
                <!-- Muestra la imagen -->
                <img src="imagenes_subidas/'.$resultado['imagen'].'" class="card-img-top" alt="'.$resultado['titulo'].'">
                    <div class="card-body">
                            <!-- Título completo -->
                            <h5 class="card-title">'.$resultado['titulo'].'</h5>
                        <!-- Copete completo -->
                        <p class="card-text">'.substr($resultado['copete'],0,40).'</p>
                        <!-- Imprime el nombre del autor obtenido en la segunda consulta -->
                        <p class="card-text">'.$autor['nombre'].''." ".''.$autor['apellido'].'</p>
                        <p class="card-text">'.$autor['apellido'].'</p>
                        
                        <!-- Un botón que usa JavaScript para volver a la página anterior en el historial del navegador -->
                        <a href="javascript:history.back()" class="btn btn-primary">Volver a Pagina anterior</a>
                    </div>
                 </div>
            </div>
            ');
        }

        // Cierra la conexión a la base de datos
        mysqli_close($conexion);
        ?>
        </div>
</body>
</html>