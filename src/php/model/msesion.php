<?php
    require_once 'conexion.php';
    class MSesion extends Conexion{
        /**
         * Función que devuleve los datos del tutor o false si no devuelve ninguna fila.
         */
        public function inicio_sesion($correo){
            $sql = "SELECT Usuarios.idUsuario AS id, Usuarios.nombre, idPerfil AS perfil FROM Usuarios
            JOIN Perfiles_Usuarios ON Usuarios.idUsuario = Perfiles_Usuarios.idUsuario
            WHERE correo = ?;";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param('s', $correo);
            $stmt->execute();

            $resul = $stmt->get_result();
            $stmt->close();
            if($resul->num_rows > 0){
                $datos = $resul->fetch_assoc();
                return $datos;
            }
            else{
                return false;
            }
        }
        /**
         * Método que comprueba si el nombre de usuario existe al registrarse el tutor
         */
        public function comprobar_usuario_tutor($usuario){
            $sql = "SELECT usuario FROM tutor WHERE usuario = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param('s', $usuario);
            $stmt->execute();

            $resul = $stmt->get_result();
            $stmt->close();
            if($resul->num_rows > 0){
                return true;
            }
            else{
                return false;
            }
        }
        public function comprobar_nombre_clase($clase){
            
        }
        /**
         * Método para registrar al tutor
         */
        public function registro($nombre,$usuario,$hash){
            $sql = "INSERT INTO tutor (nombre, usuario, psw) VALUES(?, ?, ?);";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param('sss', $nombre,$usuario,$hash);
            if ($stmt->execute()) {
                return $this->conexion->insert_id;
            } else {
                return null;
            }
        }
    }