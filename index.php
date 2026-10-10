<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <!-- Carga los estilos de Bootstrap desde la carpeta local para que la página sea bonita y responsiva -->
    <link href="lib/bootstrap-5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Carga el archivo JavaScript de Bootstrap para los componentes interactivos -->
    <script src="lib/bootstrap-5.3.2/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container-fluid">
        <?php // require("menu.php"); ?>
        <h1>Noticias</h1>
        <h1>Mi diario</h1>
        <div class="row">
        <?php
        // Trae el archivo de configuración con los datos para conectarse a MySQL
        require("admin/conexion.php");

        // Abre la conexión con el servidor de base de datos usando las variables del archivo anterior
        $conexion = mysqli_connect($server_db, $usuario_db, $password_db)
            or die("No se puede conectar con el servidor");

        // Selecciona específicamente la base de datos que vamos a usar
        mysqli_select_db($conexion, $base_db)
            or die("No se puede seleccionar la base de datos");

        // Prepara la orden SQL: selecciona todo de la tabla noticias y ordénalas de la más nueva a la más vieja (fecha descendente)
        $instruccion = "select * from noticias  order by fecha desc";

        // Ejecuta la consulta SQL en la base de datos; si falla, corta la ejecución y muestra un error
        $consulta = mysqli_query($conexion, $instruccion) or die("no puedo consultar");

        // Cuenta cuántas filas (noticias) devolvió la consulta
        $nfilas = mysqli_num_rows($consulta);

        // Inicia un bucle que se va a repetir tantas veces como noticias existan en la tabla
        for ($i = 0; $i < $nfilas; $i++) {
            
            // Extrae una fila de resultados de la consulta en forma de array asociativo
            $resultado = mysqli_fetch_array($consulta);

            // Imprime código HTML combinándolo con PHP para armar una tarjeta (card) de Bootstrap por cada noticia
            print('
            <div class="col-4">
                <div class="card">
                <!-- Muestra la imagen de la noticia buscando en la carpeta imagenes_subidas/ el nombre guardado en la BD -->
                <!-- el '.' es una concatenacion de textos -->
                <img src="imagenes_subidas/'.$resultado['imagen'].'" class="card-img-top" alt="'.$resultado['titulo'].'">
                    <div class="card-body">
                            <!-- Imprime el título de la noticia -->
                            <h5 class="card-title">'.$resultado['titulo'].'</h5>
                        <!-- Muestra un extracto del copete cortado desde el caracter 0 al 40 -->
                        <p class="card-text">'.substr($resultado['copete'],0,40).'</p>
                        <!-- Dibuja un botón que redirige a ver_noticia.php pasando por la URL el id_noticia de este registro específico -->
                        <a href="ver_noticia.php?id_noticia='.$resultado['id_noticia'].'" class="btn btn-primary">Go somewhere</a>
                    </div>
                 </div>
            </div>         
            ');
        }

        // Cierra la conexión con la base de datos para liberar recursos del servidor
        mysqli_close($conexion);
        ?>
        </div>
</body>
</html>