<?php
    $_SESSION["criterio"]="todos";
    $pag=$_REQUEST["pagina"]; //Se almacena el valor de la página actual en la variable
    $descJamon=$_REQUEST["descripcionJamon"]; //Se almacena el valor de la descripción en la variable
    
    //Si el usuario no ha escrito nada en la descripción se guarda como campo vacío
    if($descJamon==NULL){
        $descJamon='';
    }      
    
    if($pag==NULL){
        $pag=1;
    }
    
    $numeroReg=Jamon::contarJamones($descJamon, $filtro);
    $totalPaginas=ceil($numeroReg/NUMREGISTROS); //Se establece el total de páginas que se van a tener
    $jamones=Jamon::buscaJamonPorDescripcion($descJamon, $filtro, $pag, NUMREGISTROS); //Se guardan los jamones obtenidos como resultado del metodo buscar por descripcion
    
    //Si el usuario PULSA SALIR
    if(isset($_REQUEST["salir"])){
        unset($_SESSION["usuario"]); //Se destruye la variable de sesión que almacena el objeto de la clase Usuario
        session_destroy(); //Se destruye la sesión
        header('Location: index.php'); //Se le redirige al index
        exit;
    }
    //Si el usuario ha SELECCIONADO un criterio
    if(isset($_REQUEST["criterio"])){
        //Si el criterio es igual a ALTA
        if($_REQUEST["criterio"]=="blanco"){
            $filtro="blanco"; //Se guarda el filtro en la variable
            $_SESSION["criterio"]="blanco";
        }
        else{
            //Si el criterio es igual a BAJA
            if($_REQUEST["criterio"]=="bellota"){
                $filtro="bellota"; //Se guarda el filtro en la variable
                $_SESSION["criterio"]="bellota";
            }
            else{
                if($_REQUEST["criterio"]=="cebo"){
                    $filtro="cebo"; //Se guarda el filtro en la variable
                    $_SESSION["criterio"]="cebo";
                }
                else{
                    if($_REQUEST["criterio"]=="recebo"){
                        $filtro="recebo"; //Se guarda el filtro en la variable
                        $_SESSION["criterio"]="recebo";
                    }
                }
            }
        }
    }
    //Si NO EXISTE la SESIÓN del USUARIO
    if(!isset($_SESSION["usuario"])){
        header('Location: index.php'); //Se le redirige al index
        exit;
    }
    //Si el usuario PULSA BUSCAR
    if(isset($_REQUEST["buscarJamon"])){
        $descJamon=$_REQUEST["descripcionJamon"]; //Se almacena en la variable la desccripción del jamón correspondiente
        $numeroReg=Jamon::contarJamones($descJamon, $filtro);
        $totalPaginas=ceil($numeroReg/NUMREGISTROS); //Se establece el total de páginas que se van a tener
        $jamones=Jamon::buscaJamonPorDescripcion($descJamon, $filtro, $pag, NUMREGISTROS); //Se guardan los jamones obtenidos como resultado del metodo buscar por descripcion
        require_once $vistas["layout"]; //Se carga la vista correspondiente        
    }
    //Si NO se ha PULSADO ningún BOTÓN
    else{
        $numeroReg=Jamon::contarJamones($descJamon, $filtro);
        $totalPaginas=ceil($numeroReg/NUMREGISTROS); //Se establece el total de páginas que se van a tener
        $jamones=Jamon::buscaJamonPorDescripcion($descJamon, $filtro, $pag, NUMREGISTROS); //Se guardan los jamones obtenidos como resultado del metodo buscar por descripcion
        $_SESSION["pagina"]="inicio"; //Se guarda en la variable de sesión la ventana de mantenimiento de jamones
        require_once $vistas["layout"]; //Se carga la vista correspondiente           
    }
    
?>