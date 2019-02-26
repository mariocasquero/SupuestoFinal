<?php
    
    require_once "config/conf.php"; //Se incluye el archivo de configuracion de vistas y controladores
    require_once "config/conexionDB.php"; //Se incluye el archivo de configuración de la DB  
    
    session_start();
    
    //Si el usuario ha iniciado sesión pero no ha accedido a ninguna ventana, será mandado a la ventana de inicio
    if(isset($_SESSION["usuario"]) && !isset($_SESSION["pagina"])){
        $controlador=$controladores["inicio"]; //Se almacena el controlador de inicio en la variable
        require_once $controlador; //Se incluye el controlador
    }
    
    //Si ha accedido a alguna ventana, será mandado a la correspondiente
    if(isset($_SESSION["pagina"])){
        $controlador=$controladores[$_SESSION["pagina"]]; //Se almacena el controlador de la ventana en la variable
        require_once $controlador; //Se incluye el controlador
    }
    //Si no se cumple nada de lo anterior será mandado a la ventana de Login
    else{
        $controlador=$controladores["login"]; //Se almacena el controlador del login en la variable
        require_once $controlador; //Se incluye el controlador
    } 
?>
