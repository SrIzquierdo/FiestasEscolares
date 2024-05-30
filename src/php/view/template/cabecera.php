<!DOCTYPE html>
<html>
    <head>
        <title>Inscripciones</title>
        <link rel="stylesheet" href="css/style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <header>
            <div class="cabeceraIzquierda">
                <h1>Inscripciones Fiestas Escolares</h1>
            </div>
            <div class="cabeceraDerecha">
                <nav>
                    <?php
                        if(isset($_SESSION['id'])){
                            if($_SESSION['perfil'] == 2){ ?>
                            <a href="?controlador=Controlador&metodo=vistaClase" class="verTabla">Clase</a> <!-- Solo si es tutor -->
                            <a href="?controlador=Controlador&metodo=vistaActividades" class="verTabla">Inscripciones</a> <!-- Solo si es tutor o coordinador -->
                            <?php }
                            if($_SESSION['perfil'] == 1){ ?>
                                <a href="?controlador=Momento&metodo=vistaListar" class="verTabla">Momentos</a> <!-- Solo si es coordinador -->
                                <a href="?controlador=Actividad&metodo=vistaListar" class="verTabla">Actividades</a>
                            <?php }?>
                            <a href="?controlador=Sesion&metodo=cerrarSesion" class="botonSesion">Cerrar sesión</a>
                            <?php
                        }
                    ?>
                </nav>
            </div>
        </header>