<main class="formMomento">
        <h1>Nuevo Momento</h1>
        <?php if(isset($datos['mensaje'])){ ?>
        <p><?php echo $datos['mensaje']; ?></p>
        <?php } ?>
        <form action="?controlador=Momento&metodo=crearMomento" method="POST">
            <label for="nombre">Nombre del Momento:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="fecha_inicio">Fecha de Inicio:</label>
            <input type="date" id="fecha_inicio" name="fecha_inicio" required>

            <label for="fecha_fin">Fecha de Fin:</label>
            <input type="date" id="fecha_fin" name="fecha_fin" required>

            <input type="submit" value="Crear Momento">
        </form>
    </main>
    </body>
</html>