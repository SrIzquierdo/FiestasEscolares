    <main class="formMomento">
        <h1>Nuevo Momento</h1>
        <?php if(isset($datos['mensaje'])){ ?>
        <p><?php echo $datos['mensaje']; ?></p>
        <?php } ?>
        <form action="?controlador=Momento&metodo=modificarMomento" method="POST">
            <label for="nombre">Nombre del Momento:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo $datos['nombre']; ?>" required>

            <label for="fecha_inicio">Fecha de Inicio:</label>
            <input type="date" id="fecha_inicio" name="fecha_inicio" value="<?php echo date('Y-m-d', strtotime($datos['fecha_inicio'])); ?>" required>

            <label for="fecha_fin">Fecha de Fin:</label>
            <input type="date" id="fecha_fin" name="fecha_fin" value="<?php echo date('Y-m-d', strtotime($datos['fecha_fin'])); ?>" required>

            <input type="hidden" id="id" name="id" value="<?php echo $datos['id']; ?>">
        
            <input type="submit" value="Modificar Momento">
        </form>
    </main>
    </body>
</html>