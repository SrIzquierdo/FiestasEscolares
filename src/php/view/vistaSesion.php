        <main class="sesion">
            <h1>Inicio de sesión</h1>
            <?php 
                if($Control->mensaje){
                    echo '<h2 class="mensaje">'.$Control->mensaje.'</h2>';
                }
            ?>
            <form action="?controlador=Sesion&metodo=inicioSesion" method="post">
                
                <label for="nombreUsuario">Correo electrónico:</label>
                <input type="text" name="nombreUsuario" id="nombreUsuario">
                
                <p>
                    <label for="recuerdame">¿Recordar sesión?</label>
                    <input type="checkbox" name="recuerdame" id="recuerdame">
                </p>
                <input type="submit" value="Iniciar Sesión">
            </form>
        </main>
    </body>
</html>