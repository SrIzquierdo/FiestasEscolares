<main class="sesion">
        <div class="header-momentos">
            <h2>Listado de Momentos</h2>
            <a href='?controlador=Momento&metodo=vistaFormularioMomento' class="boton" id="crearMomento">Crear Momento</a>
        </div>
        <table>
            <caption>Momentos Registrados</caption>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            
            <tbody>
                <?php
                    foreach ($datos as $momento) { ?>
                        <tr>
                            <td><?php echo $momento['nombre'] ?></td>
                            <td><?php echo $momento['fecha_inicio'] ?></td>
                            <td><?php echo $momento['fecha_fin'] ?></td>
                            <td>
                                <a href='?controlador=Momento&metodo=vistaFormularioMomento&id=<?php echo $momento['id'] ?>' class='boton modificar'>Modificar</a>
                                <a href='?controlador=Momento&metodo=borrarMomento&id=<?php echo $momento['id'] ?>' class='boton borrar'>Borrar</a>
                            </td>
                       </tr>
                    <?php }
                ?>
            </tbody>

        </table>
    </main>
    </body>
</html>