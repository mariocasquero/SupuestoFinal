<?php
    require_once "core/181025validacionFormularios.php"; //Se incluye la librería de validación de formularios
    require "model/Usuario.php"; //Se incluye la clase Usuario
    require "model/Jamon.php"; //Se incluye la clase Jamon
    
    define("OBLIGATORIO", 1);
    define("NOOBLIGATORIO", 0);
    define("MINCODDESCUSUARIO", 3);
    define("MAXCODUSUARIO", 10);
    define("MAXDESCUSUARIO", 255);
    define("NUMREGISTROS", 3);
    
    //Se almacena en el array asociativo las rutas a los controladores
    $controladores=[
        "login"=>"controller/cLogin.php",
        "inicio"=>"controller/cInicio.php",
        "registro"=>"controller/cRegistro.php",
        "correo"=>"controller/cEnviarCorreo.php"
    ];
    
    //Se almacena en el array asociativo las rutas a las vistas
    $vistas=[
        "layout"=>"view/layout.php",
        "login"=>"view/vLogin.php",
        "inicio"=>"view/vInicio.php",
        "registro"=>"view/vRegistro.php",
        "correo"=>"view/vEnviarCorreo.php"
    ];