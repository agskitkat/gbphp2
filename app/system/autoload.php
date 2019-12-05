<?php
    namespace App\System;

    class Autoload {
        public function loadClass($className) {
            //echo("LoadClass: " . $className . "<br>");
            $ds = DIRECTORY_SEPARATOR;
            $file = $_SERVER['DOCUMENT_ROOT'] . $ds . $className . ".php";
            if(file_exists($file)) {
                include_once($file);
            }
        }
    }