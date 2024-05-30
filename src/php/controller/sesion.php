<?php
    require_once 'controlador.php';
    require_once 'php/model/msesion.php';

    class Sesion extends Controlador{
        private $Sesion;
        function __construct(){
            $this->Sesion = new MSesion();
            $this->Modelo = new Modelo();
        }

        // Método para verificar el acceso usando el correo electrónico de Google
        function inicioSesion(){
            session_start();
            if($_POST['nombreUsuario']){
                $usuario = $_POST['nombreUsuario'];

                $datos = $this->Sesion->inicio_sesion($usuario);
                if($datos){
                    $_SESSION['id']=$datos['id'];
                    $_SESSION['nombre']=$datos['nombre'];
                    $_SESSION['perfil']=$datos['perfil'];
                    if(isset($_POST['recuerdame'])){
                        $cookie=$_SESSION['id'].'/'.$_SESSION['nombre'];
                        setcookie('sesion', $cookie, time()+60*60*24*30, '/'); /* Dura 30 días */
                    }
                    switch ($datos['perfil']) {
                        case 2:
                            $this->vista = 'vistaClase';
                            $alumnos = $this->Modelo->tabla_alumno_inscripcion($_SESSION['id']);
                            break;
                        default:
                            $this->vista = 'vistaListado';
                            $alumnos = $this->Modelo->tabla_inscripciones();
                            
                    }
                    if(!empty($alumnos)){
                        return $alumnos;
                    }
                }
                else{
                    $this->mensaje = 'Usuario o contraseña incorrectos.';
                    $this->vista = 'vistaSesion';
                }
            }
            else{
                $this->mensaje = 'Rellene todos los campos';
                $this->vista = 'vistaSesion';
            }
        }
        /**
         * Método que cierra la sesión abierta y manda a la vista de inicio de sesión.
         */
        public function cerrarSesion(){
            $this->vista = 'vistaSesion';
            session_start();
            session_unset();
            session_destroy();
            if(isset($_COOKIE['sesion'])){
                setcookie('sesion', '', time()-1, '/');
            }
            $this->mensaje = 'Se ha cerrado la sesión';
        }
         /**
         * Método que crea un nuevo usuario y genera una sesión.
         * Devuleve el formulario si los campos están vacío y si el usuario ya existe.
         */
        public function registroSesion(){
            $this->vista='vistaCrearClase';
            if(isset($_POST['nombreTutor'], $_POST['nombreUsuario'], $_POST['pswUsuario'])){
                $nombre=$_POST['nombreTutor'];  
                $usuario=$_POST['nombreUsuario'];
                $psw=$_POST['pswUsuario'];

                if(!$this->Sesion->comprobar_usuario_tutor($usuario)){
                    $hash = password_hash($psw, PASSWORD_DEFAULT);
                    $id=$this->Sesion->registro($nombre,$usuario,$hash);
                    if ($id !== null) {
                        session_start();
                        $_SESSION['id']=$id;
                        $_SESSION['nombre']=$nombre;
                    } else {
                        $this->mensaje = "Error al registrar.";
                    }
                }
                else{
                    $this->mensaje = $usuario.' ya existe.';
                    $this->vista = 'vistaRegistro';
                }
            }
            else{
                $this->mensaje = 'Rellene todos los campos del formulario';
                $this->vista = 'vistaRegistro';
            }
        }
    }