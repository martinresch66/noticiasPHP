<?php
session_start();
extract($_REQUEST);
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
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- include summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

</head>

<body>
    <div class="container">
        <?php require("menu.php"); ?>
        <h1>Noticias Nueva</h1>

        <!-- Formulario que envía los datos por POST al archivo de guardado; incluye 'enctype' indispensable para subir archivos. -->
        <form action="noticias_nueva_guardar.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="titulo" class="form-label">Titulo</label>
                <input type="text" class="form-control" id="titulo" name="titulo" placeholder="titulo" required>
            </div>
            <div class="mb-3">
                <label for="copete" class="form-label">Copete</label>
                <input type="text" class="form-control" id="copete" name="copete" required>
            </div>
            <div class="mb-3">
                <label for="cuerpo" class="form-label">cuerpo</label>
                <textarea  rows="10" class="form-control" id="cuerpo" name="cuerpo" required></textarea>
            </div>
            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen</label>
                <input  type="file" class="form-control" id="imagen" name="imagen" required></input>
            </div>
            <div class="mb-3">
                <label for="categoria" class="form-label">Imagen</label>
                <select class="form-control" id="categoria" name="categoria" required>
                    <option value="Deportes">Deportes</option>
                    <option value="Moda">Moda</option>
                    <option value="Sociales">Sociales</option>
                </select>
            </div>
            <div class="mb-3">
                <input type="submit" class="btn btn-success" id="enviar" name="enviar" value="GUARDAR">
            </div>


        </form>

        <div id="librerias">
        <script>
            /*Summernote es una biblioteca de JavaScript (un plugin de código abierto) que se utiliza 
            para transformar un aburrido cuadro de texto (<textarea>) en un editor de texto enriquecido tipo Word directamente en la página web. */
            $(document).ready(function() {
                $('#cuerpo').summernote({
                    height: 200
                });
            });
        </script>

    </div>

    </div>
</body>

</html>