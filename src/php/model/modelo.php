<?php
    require 'php/config/configDB.php';
    require_once 'conexion.php';
    class Modelo extends Conexion{
        /**
         * Devuelve los datos de todas las atividades
         */
        public function tabla_actividad(){
            $sql = "SELECT * FROM ACT_Actividades";
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
        /**
         * Método que devuleve el número de alumnos inscritos por actividad de un Usuarios en específico.
         */
        public function numero_alumnos_inscritos_por_actividad($Usuarios){
            $sql="SELECT COUNT(ACT_Inscripciones.id_alumno) AS numero_alumnos_inscritos, ACT_Inscripciones.id_actividad AS actividad
            FROM ACT_Inscripciones
            JOIN Alumnos ON ACT_Inscripciones.id_alumno = Alumnos.idAlumno
            JOIN Secciones ON Alumnos.idSeccion = Secciones.idSeccion
            JOIN Usuarios ON Secciones.idTutor = Usuarios.idUsuario
            WHERE Usuarios.idUsuario = ?
            GROUP BY ACT_Inscripciones.id_actividad;";

            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param('i', $Usuarios);
            $stmt->execute();

            $resultado = $stmt->get_result();
            $datos = array();
            while ($fila = $resultado->fetch_assoc()) {
                array_push($datos, $fila);
            }

            $stmt->close();
            $this->conexion->close();

            return $datos;
        }
        /**
         * Devuleve los datos de los alumnos inscritos en alguna actividad
         */
        public function tabla_alumno_inscripcion($Usuarios){
            $sql = "SELECT Alumnos.nombre AS alumno, Secciones.codSeccion AS clase, ACT_Actividades.nombre AS actividad
                FROM Alumnos
                JOIN Secciones ON Alumnos.idSeccion = Secciones.idSeccion
                LEFT JOIN ACT_Inscripciones ON ACT_Inscripciones.id_alumno = Alumnos.idAlumno
                LEFT JOIN ACT_Actividades ON ACT_Inscripciones.id_actividad = ACT_Actividades.id
                JOIN Usuarios ON Secciones.idTutor = Usuarios.idUsuario
                WHERE Usuarios.idUsuario = ?;";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param('i', $Usuarios);
            $stmt->execute();

            $resultado = $stmt->get_result();
            $datos = array();
            while ($fila = $resultado->fetch_assoc()) {
                array_push($datos, $fila);
            }

            $stmt->close();
            $this->conexion->close();

            return $datos;
        }
        /**
         * Devuelve los datos de la actividad, los alumnos que se pueden inscribir y los alumnos inscritos
        */
        public function select_alumnos_inscripcion($actividad, $Usuarios){
            $sqlActividad = "SELECT * FROM ACT_Actividades WHERE id = ?";

            $stmtActividad = $this->conexion->prepare($sqlActividad);
            $stmtActividad->bind_param('i', $actividad);
            $stmtActividad->execute();

            $resulActividad = $stmtActividad->get_result();
            $stmtActividad->close();

            $datosActividad = $resulActividad->fetch_assoc();
            $genero = $datosActividad['genero'];

            $datos = [
                "id" => $datosActividad['id'],
                "actividad" => $datosActividad['nombre'],
                "max_alumnos" => $datosActividad['nMaxAlumnos'],
                "alumnos" => $this->datos_alumnos_por_genero($genero, $Usuarios),
                "alumnos_inscritos" => $this->datos_alumnos_inscritos_por_clase($actividad, $Usuarios)
            ];
            $this->conexion->close();

            return $datos;
        }
        /**
         * Devuleve los alumnos de una Secciones por el genero de la actividad o por del propio genero del Alumnos.
         */
        public function datos_alumnos_por_genero($genero, $Usuarios){
            $stmtAlumno = null;
            $sqlAlumno = "SELECT Alumnos.idAlumno AS id, Alumnos.nombre AS nombre
                FROM Alumnos
                JOIN Secciones ON Alumnos.idSeccion = Secciones.idSeccion
                JOIN Usuarios ON Secciones.idTutor = Usuarios.idUsuario
                WHERE Usuarios.idUsuario = ?";
            if (strcasecmp($genero, 'x') == 0){
                $stmtAlumno = $this->conexion->prepare($sqlAlumno);
                $stmtAlumno->bind_param('i', $Usuarios);
            }
            else{
                $sqlAlumno .= " AND Alumnos.sexo = ?";
                $stmtAlumno = $this->conexion->prepare($sqlAlumno);
                $stmtAlumno->bind_param('is', $Usuarios, $genero);
            }
            $stmtAlumno->execute();

            $resulAlumno = $stmtAlumno->get_result();
            $stmtAlumno->close();
            
            $alumnos = array();
            while ($fila = $resulAlumno->fetch_assoc()) {
                array_push($alumnos, $fila);
            }
            return $alumnos;
        }
        /**
         * Devuleve los alumnos inscritos en una actividad en una Secciones
         */
        public function datos_alumnos_inscritos_por_clase($actividad, $Usuarios){
            $sql = "SELECT id_alumno FROM ACT_Inscripciones
            JOIN Alumnos ON ACT_Inscripciones.id_alumno = Alumnos.idAlumno
            JOIN Secciones ON Alumnos.idSeccion = Secciones.idSeccion
            JOIN Usuarios ON Secciones.idTutor = Usuarios.idUsuario
            WHERE ACT_Inscripciones.id_actividad = ? AND Usuarios.idUsuario=?;";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param('ii', $actividad,$Usuarios);
            $stmt->execute();

            $resul = $stmt->get_result();
            $stmt->close();

            $alumnos_inscritos = array();
            while ($fila = $resul->fetch_assoc()) {
                array_push($alumnos_inscritos, $fila);
            }
            return $alumnos_inscritos;
        }
        /**
         * Elimina el Alumnos inscrito en una actividad.
         */
        public function eliminar_inscrito($Alumnos, $actividad){
            $sql = "DELETE FROM ACT_Inscripciones WHERE id_alumno = ? AND id_actividad = ?;";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param('ii', $Alumnos, $actividad);
            $stmt->execute();
        }
        /**
         * Guarda en la base de datos la id del Alumnos, la actividad y la fecha al inscribir.
         */
        public function inscribir_alumno($Alumnos, $actividad){
            $fecha = new DateTime();
            $fechaFormateada = $fecha->format('Y-m-d H:i:s');
            $sql = "INSERT INTO ACT_Inscripciones (id_alumno, id_actividad, fecha_hora) VALUES(?,?,?);";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param('iis', $Alumnos, $actividad, $fechaFormateada);
            $stmt->execute();
        }
        /**
         * Devuelve todos los alumnos que están inscritos.
         */
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
        public function tabla_actividad_nombre(){
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