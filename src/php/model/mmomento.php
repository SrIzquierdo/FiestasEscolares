<?php
    require_once 'conexion.php';
    class MMomento extends Conexion{
        public function momentos(){
            $sql = "SELECT * FROM ACT_Momentos";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();

            $resultado = $stmt->get_result();
            $datos = array();
            while ($fila = $resultado->fetch_assoc()) {
                array_push($datos, $fila);
            }

            $stmt->close();

            return $datos;
        }

        public function datos_momento($id){
            $sql = "SELECT * FROM ACT_Momentos WHERE id = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param('i',$id);
            $stmt->execute();

            $resultado = $stmt->get_result();
            $datos = $resultado->fetch_assoc();

            $stmt->close();

            return $datos;
        }

        public function borrar_momento($id){
            $sql = "DELETE FROM ACT_Momentos WHERE id = ?;";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param('i', $id);
            if($stmt->execute()){
                return true;
            }
            return false;
        }
        public function insertar_momento($nombre, $fecha_inicio, $fecha_fin) {
            $sql = "INSERT INTO ACT_Momentos (nombre, fecha_inicio, fecha_fin) VALUES (?, ?, ?);";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param('sss', $nombre, $fecha_inicio, $fecha_fin);
    
            try {
                $stmt->execute();
                return false; // Cambiado a true para indicar éxito en la inserción
            } catch (mysqli_sql_exception $e) {
                if ($e->getCode() == 1062) { // Código de error de MySQL para entrada duplicada
                    return 'Pon otro nombre';
                } else {
                    // Manejar otros tipos de errores de mysqli si es necesario
                    return 'Error al insertar el momento: ' . $e->getMessage();
                }
            }
        }
        public function modificar_momento($nombre, $fecha_inicio, $fecha_fin,$id) {
            $sql = "UPDATE ACT_Momentos SET nombre = ?, fecha_inicio = ?, fecha_fin = ? WHERE id = ?;";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param('sssi', $nombre, $fecha_inicio, $fecha_fin, $id);

    
            try {
                $stmt->execute();
                return false; // Cambiado a true para indicar éxito en la inserción
            } catch (mysqli_sql_exception $e) {
                if ($e->getCode() == 1062) { // Código de error de MySQL para entrada duplicada
                    return 'Pon otro nombre';
                } else {
                    // Manejar otros tipos de errores de mysqli si es necesario
                    return 'Error al insertar el momento: ' . $e->getMessage();
                }
            }
        }
    }