<?php
    require_once 'controlador.php';
    require_once 'php/model/mmomento.php';
    
    class Momento extends Controlador{
        public $vista;
        function __construct(){
            $this->Modelo = new MMomento();
        }

        public function vistaListar(){
            $this->vista = 'vistaListarMomentos';
            session_start();
            if(isset($_SESSION['id'])){
                if($_SESSION['perfil'] == 1){
                    $momentos = $this->Modelo->momentos();
                    return $momentos;
                }
            }
        }

        public function vistaFormularioMomento(){
            $this->vista = 'vistaCrearMomento';
            session_start();
            if(isset($_SESSION['id'])){
                if($_SESSION['perfil'] == 1){
                    if(isset($_GET['id'])){
                        $this->vista = 'vistaModificarMomento';
                        $id = $_GET['id'];
                        $momento = $this->Modelo->datos_momento($id);
                        return $momento;
                    }
                    return;
                }
            }
        }
       
        public function crearMomento(){
            $this->vista = 'vistaListarMomentos';
            session_start();
            if(isset($_SESSION['id'])){
                if($_SESSION['perfil'] == 1){
                    if($_POST['nombre']=='' || $_POST['fecha_inicio'] == '' || $_POST['fecha_fin'] == ''){
                        $this->vista = 'vistaCrearMomento';
                        $datos = array(
                            'mensaje' => 'Pon to los datos pa'
                        );
                        return $datos;
                    }
                    $nombre = $_POST['nombre'];
                    $fechaInicio = $_POST['fecha_inicio'];
                    $fechaFin = $_POST['fecha_fin'];
                    if(!$mensaje = $this->Modelo->insertar_momento($nombre, $fechaInicio, $fechaFin)){
                        $momentos = $this->Modelo->momentos();
                        return $momentos;
                    }
                    else{
                        $this->vista = 'vistaCrearMomento';
                        $datos = array(
                            'mensaje' => $mensaje
                        );
                        return $datos;
                    }
                }
            }
        }
        public function modificarMomento(){
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
        public function borrarMomento(){
            $this->vista = 'vistaListarMomentos';
            session_start();
            if(isset($_SESSION['id'])){
                if($_SESSION['perfil'] == 1){
                    $id = $_GET['id'];
                    if($this->Modelo->borrar_momento($id))
                        $momentos = $this->Modelo->momentos();
                    return $momentos;
                }
            }
        }
    }