<?php
    require_once 'conexion.php';
    class Modelo extends Conexion{
        public function tabla_inscripciones(){
            $sql = "SELECT Alumnos.nombre AS alumno, Secciones.nombre AS clase, ACT_Actividades.nombre AS actividad
                FROM Alumnos
                JOIN Secciones ON Alumnos.idSeccion = Secciones.idSeccion
                LEFT JOIN ACT_Inscripciones ON ACT_Inscripciones.id_alumno = Alumnos.idAlumno
                LEFT JOIN ACT_Actividades ON ACT_Inscripciones.id_actividad = ACT_Actividades.id
                WHERE ACT_Actividades.nombre IS NOT NULL
                ORDER BY actividad, clase, alumno;";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
        
            $resultado = $stmt->get_result();
            $datos = array();
            while ($fila = $resultado->fetch_assoc()) {
                $actividad = $fila['actividad'];
                $clase = $fila['clase'];
                $alumno = $fila['alumno'];
        
                // Agrupar los datos por actividad y luego por clase dentro de cada actividad
                if (!isset($datos[$actividad])) {
                    $datos[$actividad] = array();
                }
        
                if (!isset($datos[$actividad][$clase])) {
                    $datos[$actividad][$clase] = array();
                }
        
                $datos[$actividad][$clase][] = $alumno;
            }
        
            return $datos;
        }
        /**
         * Devuelve los datos de todas las atividades
         */
        public function tabla_actividad(){
            $sql = "SELECT nombre
                FROM ACT_Actividades
                INNER JOIN ACT_Inscripciones ON ACT_Actividades.id = ACT_Inscripciones.id_actividad
                GROUP BY ACT_Actividades.id;";
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
    }