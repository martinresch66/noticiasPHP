<?php
    session_start();
    extract($_REQUEST); // Aquí rescata el id_usuario que viene por la URL (ej: usuarios_editar.php?id_usuario=3)

    if (!isset($_SESSION['usuario_logueado']) || $_SESSION['tipo_usuario'] != 'admin') {
        header("location:index.php");
        exit();
    }

    // 1. Nos conectamos a la base de datos para buscar los datos actuales del usuario
    require("conexion.php");
    $conexion = mysqli_connect($server_db, $usuario_db, $password_db)
        or die("No se puede conectar con el servidor");
    mysqli_select_db($conexion, $base_db)
        or die("No se puede seleccionar la base de datos");

    // 2. Consultamos los datos del usuario específico
    $instruccion = "SELECT * FROM usuarios WHERE id_usuario = '$id_usuario'";
    $consulta = mysqli_query($conexion, $instruccion) or die("Error al consultar usuario");
    $resultado = mysqli_fetch_array($consulta);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Editar Usuario</title>
    <link href="../lib/bootstrap-5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="../lib/bootstrap-5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>

<body>
    <div class="container">
        <?php require("menu.php"); ?>
        <h1>Editar Usuario</h1>

        <!-- El action apunta al archivo que procesará la actualización -->
        <form action="usuarios_editar_guardar.php" method="post">
            
            <!-- CAMPO OCULTO: Vital para que el sistema sepa qué ID estamos editando -->
            <input type="hidden" name="id_usuario" value="<?php echo $resultado['id_usuario']; ?>">

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <!-- Rellenamos el value con el dato actual de la base de datos -->
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo trim($resultado['nombre']); ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="apellido" class="form-label">Apellido</label>
                <input type="text" class="form-control" id="apellido" name="apellido" value="<?php echo trim($resultado['apellido']); ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario</label>
                <input type="text" class="form-control" id="usuario" name="usuario" value="<?php echo trim($resultado['usuario']); ?>" onkeyup="comprobar_usuario(this.value)" required>
                <span id="mensaje"></span>
            </div>
            
            <div class="mb-3">
                <label for="password" class="form-label">Nueva Password (o dejar la misma)</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Escribe la password">
            </div>

            <!-- Selector de tipo de usuario con preselección -->
            <div class="mb-3">
                <label for="tipo_usuario" class="form-label">Tipo de Usuario</label>
                <select class="form-control" id="tipo_usuario" name="tipo_usuario" required>
                    <option value="autor" <?php if($resultado['tipo_usuario'] == 'autor') print("selected"); ?>>Autor</option>
                    <option value="admin" <?php if($resultado['tipo_usuario'] == 'admin') print("selected"); ?>>Administrador</option>
                </select>
            </div>


            <div class="mb-3">
                <input type="submit" class="btn btn-success" id="enviar" name="enviar" value="MODIFICAR">
                <a href="usuarios.php" class="btn btn-info">Regresar</a>
            </div>
        </form>

        <div id="librerias">
            <script>
                function comprobar_usuario(str) {
                    if (str.length == 0) {
                        document.getElementById("mensaje").innerHTML = "";
                        return;
                    } else {
                        var xmlhttp = new XMLHttpRequest();
                        xmlhttp.onreadystatechange = function() {
                            if (this.readyState == 4 && this.status == 200) {
                                if(this.responseText == 1) {
                                    document.getElementById("enviar").disabled = true;
                                    document.getElementById("mensaje").innerHTML = "<p style='color:red'>Usuario No Disponible</p>";
                                } else {
                                    document.getElementById("enviar").disabled = false;
                                    document.getElementById("mensaje").innerHTML = "";
                                }
                            }
                        };
                        xmlhttp.open("GET", "ajax_comprobar_usuario.php?usuario=" + str, true);
                        xmlhttp.send();
                    }
                }
            </script>
        </div>
    </div>
</body>
</html>

<?php 
    mysqli_close($conexion); 
?>