<?php
session_start();
extract($_REQUEST);
// REGLA DE SEGURIDAD: Solo los administradores pueden crear usuarios
if (!isset($_SESSION['usuario_logueado']) || $_SESSION['tipo_usuario'] != 'admin') {
    header("location:index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Nuevo Usuario</title>
    <link href="../lib/bootstrap-5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="../lib/bootstrap-5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- include summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

</head>

<body>
    <div class="container">
        <?php require("menu.php"); ?>
        <h1>Nuevo Usuario</h1>

        <form action="usuarios_nueva_guardar.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nombre" class="form-label">nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="nombre" required>
            </div>
            <div class="mb-3">
                <label for="apellido" class="form-label">apellido</label>
                <input type="text" class="form-control" id="apellido" name="apellido" placeholder="apellido" required>
            </div>
            <div class="mb-3">
                <label for="usuario" class="form-label">usuario</label>
                <!--onkeyup: Es un evento de JavaScript que se dispara cada vez que el usuario suelta una tecla mientras escribe dentro de ese input, this.value es el valor actual del input -->
                <input type="text" class="form-control" id="usuario" name="usuario" placeholder="usuario" onkeyup="comprobar_usuario(this.value)" required>
                <span id="mensaje"></span>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="password" required>
            </div>
            <!-- Selector de tipo de usuario -->
            <div class="mb-3">
                <label for="tipo_usuario" class="form-label">Tipo de Usuario</label>
                <select class="form-control" id="tipo_usuario" name="tipo_usuario" required>
                    <option value="autor">Autor</option>
                    <option value="admin">Administrador</option>
                </select>
            </div>

            <div class="mb-3">
                <input type="submit" class="btn btn-success" id="enviar" name="enviar" value="GUARDAR">
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
                        //Crea el objeto que permite hacer peticiones HTTP en segundo plano sin recargar la página.
                        var xmlhttp = new XMLHttpRequest();
                        //Se queda escuchando a que el servidor devuelva una respuesta.
                        xmlhttp.onreadystatechange = function() {
                            //Verifica que la petición haya terminado por completo y que la respuesta del servidor sea exitosa.
                            if (this.readyState == 4 && this.status == 200) {
                                //Si el archivo de verificación responde con un 1 (porque el usuario ya está ocupado en la base de datos)
                                if(this.responseText==1)
                                {
                                    document.getElementById("enviar").disabled = true;//bloquea el botón
                                    document.getElementById("mensaje").innerHTML = "<p style='color:red'>Usuario No Disponible</p>";//y escribe "Usuario No Disponible" en rojo.
                                }
                                else{
                                    document.getElementById("enviar").disabled = false;
                                    document.getElementById("mensaje").innerHTML = "";
                                }
                            }
                        };



                        xmlhttp.open("GET", "ajax_comprobar_usuario.php?usuario=" + str, true);//primero comprueba el usuario y luego, true: Define si la petición es asincrónica (true) o sincrónica (false)(asincrona el usuario puede seguir haciendo cosas mientras comprueba no s econgela la pantalla)
                        xmlhttp.send();//esta orden ejecuta y dispara la petición de inmediato.
                    }
                }
            </script>

        </div>

    </div>
</body>

</html>