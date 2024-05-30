<main class="formMomento">
        <h1>Nueva Actividad</h1>
        <?php if(isset($datos['mensaje'])){ ?>
        <p><?php echo $datos['mensaje']; ?></p>
        <?php } ?>
        <form action="?controlador=Actividad&metodo=crearActividad" method="POST">
            <label for="nombre">Nombre de la actividad:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="genero">Género:</label>
            <input type="text" id="genero" name="genero" required>

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" required></textarea>

            <label for="fecha_fin">Fecha de Fin:</label>
            <input type="date" id="fecha_fin" name="fecha_fin" required>

            <label for="nmaxalumnos">Número Máximo de Alumnos:</label>
            <input type="number" id="nMaxAlumnos" name="nMaxAlumnos" required>

            <label for="momento">Momento:</label>
            <input type="text" id="momento" name="momento" required>

            <input type="submit" value="Crear Actividad">
        </form>
    </main>
    </body>
</html>