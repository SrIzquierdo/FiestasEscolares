<?php
    require_once 'controlador.php';
    require_once 'php/model/mactividad.php';
    
    class Actividad extends Controlador{
        public $vista;
        function __construct(){
            $this->Modelo = new MActividad();
        }

        public function vistaListar(){
            $this->vista = 'vistaListarActividades';
            session_start();
            if(isset($_SESSION['id'])){
                if($_SESSION['perfil'] == 1){
                    $actividades = $this->Modelo->actividades();
                    return $actividades;
                }
            }
        }

        public function vistaFormularioActividad(){
            $this->vista = 'vistaCrearActividad';
            session_start();
            if(isset($_SESSION['id'])){
                if($_SESSION['perfil'] == 1){
                    if(isset($_GET['id'])){
                        $this->vista = 'vistaModificarMomento';
                        $id = $_GET['id'];
                        $actividades = $this->Modelo->datos_momento($id);
                        return $actividades;
                    }
                    return;
                }
            }
        }
       
        public function crearActividad(){
            $this->vista = 'vistaListarActividades';
            session_start();
            if(isset($_SESSION['id'])){
                if($_SESSION['perfil'] == 1){
                    if($_POST['nombre']=='' || $_POST['genero'] == '' || $_POST['descripcion'] == '' || $_POST['fecha_fin'] == ''|| $_POST['nMaxAlumnos'] == '' || $_POST['momento'] == ''){
                        $this->vista = 'vistaCrearActividad';
                        $datos = array(
                            'mensaje' => 'Pon to los datos pa'
                        );
                        return $datos;
                    }
                    $nombre = $_POST['nombre'];
                    $genero = $_POST['genero'];
                    $fechaFin = $_POST['fecha_fin'];
                    $descripcion = $_POST['descripcion'];
                    $momento = $_POST['momento'];
                    $id_coordinador =$_SESSION['id'];
                    $nmaxalumn=$_POST['nMaxAlumnos'];
                    if(!$mensaje = $this->Modelo->insertar_actividad($nombre, $genero, $fechaFin, $momento, $descripcion,$id_coordinador,$nmaxalumn)){
                        $actividades = $this->Modelo->actividades();
                        return $actividades;
                    }
                    else{
                        $this->vista = 'vistaCrearActividad';
                        $datos = array(
                            'mensaje' => $mensaje
                        );
                        return $datos;
                    }
                }
            }
        }
        public function modificarActividad(){
            $this->vista = 'vistaListarMomentos';
            session_start();
            if(isset($_SESSION['id'])){
                if($_SESSION['perfil'] == 1){
                    if($_POST['nombre']=='' || $_POST['fecha_inicio'] == '' || $_POST['fecha_fin'] == ''){
                        $this->vista = 'vistaModificarMomento';
                        $datos = array(
                            'mensaje' => 'Pon to los datos pa'
                        );
                        return $datos;
                    }
                    $nombre = $_POST['nombre'];
                    $fechaInicio = $_POST['fecha_inicio'];
                    $fechaFin = $_POST['fecha_fin'];
                    $id = $_POST['id'];
                    if(!$mensaje = $this->Modelo->modificar_momento($nombre, $fechaInicio, $fechaFin,$id)){
                        $momentos = $this->Modelo->momentos();
                        return $momentos;
                    }
                    else{
                        $this->vista = 'vistaModificarMomento';
                        $datos = array(
                            'mensaje' => $mensaje
                        );
                        return $datos;
                    }
                }
            }
        }
        public function borrarActividad(){
            $this->vista = 'vistaListarActividades';
            session_start();
            if(isset($_SESSION['id'])){
                if($_SESSION['perfil'] == 1){
                    $id = $_GET['id'];
                    if($this->Modelo->borrar_actividad($id))
                        $actividades = $this->Modelo->actividades();
                    return $actividades;
                }
            }
        }
    }