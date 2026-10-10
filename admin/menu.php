        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="home.php">Inicio</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="noticias.php">Noticias</a>
            </li>

            <?php 
                // Verificamos si el usuario es administrador
                if (isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] == 'admin') { 
                    // Si es ADMIN, el botón de usuarios funciona con normalidad
            ?>
                    <li class="nav-item">
                        <a class="nav-link" href="usuarios.php">Usuarios</a>
                    </li>
            <?php 
                } else { 
                    // Si es AUTOR, el botón se muestra pero con la clase 'disabled' para que no funcione
            ?>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Usuarios</a>
                    </li>
            <?php 
                } 
            ?>
            
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Salir</a>
            </li>
            <li class="nav-item">
                <?php 
                       print("<a class='nav-link disabled'>".$_SESSION['nombre']." ".$_SESSION['apellido']."</a>");
                ?>
            </li>
        </ul>