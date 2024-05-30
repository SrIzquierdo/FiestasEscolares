<?php
    /**
     * Clase de conexión a la base de datos.
     */
    class Conexion
    {
        protected $conexion = null;

        public function __construct()
        {
            require_once 'php/config/configDB.php';

            $this->conexion = new mysqli(HOST, USER, PSW, BDD);
            $this->conexion->set_charset("utf8");

             // Configura mysqli para lanzar excepciones en lugar de advertencias
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        }
    }