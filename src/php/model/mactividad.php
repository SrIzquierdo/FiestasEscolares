<?php
    require_once 'conexion.php';
    class MActividad extends Conexion{
        public function actividades(){  
            $sql = "SELECT ACT_Actividades.*, Usuarios.nombre AS coordinador, ACT_Momentos.nombre AS momento FROM ACT_Actividades
            JOIN Usuarios ON ACT_Actividades.id_coordinador = Usuarios.idUsuario
            LEFT JOIN ACT_Momentos ON ACT_Actividades.id_momento = ACT_Momentos.id";
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

        public function borrar_actividad($id){
            $sql = "DELETE FROM ACT_Actividades WHERE id = ?;";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param('i', $id);
            if($stmt->execute()){
                return true;
            }
            return false;
        }
        public function insertar_actividad($nombre, $genero, $fechaFin, $momento, $descripcion,$id_coordinador,$nmaxalumnos) {
            $sql = "INSERT INTO ACT_Actividades (nombre, genero, fecha_fin,id_momento,descripcion,id_coordinador,nMaxAlumnos) VALUES (?, ?, ?, ? ,?,?,?);";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param('sssisii', $nombre, $genero, $fechaFin, $momento, $descripcion,$id_coordinador,$nmaxalumnos);
    
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