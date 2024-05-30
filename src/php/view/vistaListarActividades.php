<main class="sesion">
    <div class="header-momentos">
        <h2>Listado de Actividades</h2>
        <a href='?controlador=Actividad&metodo=vistaFormularioActividad' class="boton" id="crearMomento">Crear Actividad</a>
    </div>
    <table>
        <caption>Actividades registradas</caption>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Género</th>
                <th>Descripción</th>
                <th>Fecha Fin</th>
                <th>Número Máximo de Alumnos</th>
                <th>Coordinador</th>
                <th>Momento</th>
                <th>Acciones</th>
            </tr>
        </thead>
        
        <tbody>
            <?php
                foreach ($datos as $actividad) { ?>
                    <tr>
                        <td><?php echo $actividad['nombre'] ?></td>
                        <td><?php echo $actividad['genero'] ?></td>
                        <td><?php echo $actividad['descripcion'] ?></td>
                        <td><?php echo $actividad['fecha_fin'] ?></td>
                        <td><?php echo $actividad['nMaxAlumnos'] ?></td>
                        <td><?php echo $actividad['coordinador'] ?></td>
                        <td><?php echo $actividad['momento'] ?></td>
                        <td>
                            <a href='?controlador=Momento&metodo=vistaFormularioMomento&id=<?php echo $actividad['id'] ?>' class='boton modificar'>Modificar</a>
                            <a href='?controlador=Actividad&metodo=borrarActividad&id=<?php echo $actividad['id'] ?>' class='boton borrar'>Borrar</a>
                        </td>
                   </tr>
                <?php }
            ?>
        </tbody>
    </table>
</main>
</body>
</html>
