<?php
    /**
    * @author Mario Casquero Jáñez
    */

    $entradaOK=true; //Se declara e inicializa la variable
    
    //Se declara e inicializa el array con los mensajes de error
    $aErrores=[
        "usuarioR"=>NULL,
        "descripcionR"=>NULL,
        "passwordR"=>NULL,
    ];
    
    //Si el usuario PULSA CANCELAR
    if(isset($_REQUEST["volver"])){
        $_SESSION["pagina"]="login"; //Se guarda en la variable de sesión la ventana de login
        header('Location: index.php'); //Se le redirige al index
        require_once $vistas["layout"]; //Se carga la vista correspondiente
        exit;
    }
    
    //Si el usuario PULSA ACEPTAR se pasa a validar la información
    if(isset($_REQUEST["aceptar"])){
        $aErrores["usuarioR"]=validacionFormularios::comprobarAlfabetico($_REQUEST["usuarioR"], MAXCODUSUARIO, MINCODDESCUSUARIO, OBLIGATORIO); //Se valida el usuario y se almacenan los posibles errores en el array
        $aErrores["descripcionR"]=validacionFormularios::comprobarAlfaNumerico($_REQUEST["descripcionR"], 100, MINCODDESCUSUARIO, OBLIGATORIO); //Se valida la descripción y se almacenan los posibles errores en el array
        $aErrores["passwordR"]=validacionFormularios::comprobarAlfaNumerico($_REQUEST["passwordR"], 30, 1, OBLIGATORIO); //Se valida el password y se almacenan los posibles errores en el array
        
        //Si el USUARIO con el que se intenta registrar YA EXISTE
        if(!(Usuario::validarCodNoExiste($_REQUEST["usuarioR"]))){
            $aErrores["usuarioR"].=" El usuario ya existe!"; //Se almacena un mensaje de error
        }
        
        //Se recorre el array en busca de mensajes de error
        foreach($aErrores as $campo=>$error){
            if($error!=null){ //Si alguna posición contiene un mensaje de error
                $entradaOK=false; //Se le cambia el valor a la variable
                $_REQUEST[$campo]=""; //Se limpia el campo erróneo
            }
        }
    }
    //Si el usuario PULSA ACEPTAR y NO hay ERRORES
    if(isset($_REQUEST["aceptar"]) && $entradaOK){
        $codUsuario=$_REQUEST["usuarioR"]; //Se almacena el usuario en la variable
        $descripcion=$_REQUEST["descripcionR"]; //Se almacena la descripción en la variable
        $password=$_REQUEST["passwordR"]; //Se almacena el password en la variable
        
        //Se almacena en la variable el resultado del método altaUsuario
        $usuario=Usuario::altaUsuario($codUsuario, $password, $descripcion, "usuario");
        
        //Si el usuario guardado como resultado es NULL
        if(is_null($usuario)){
            $_SESSION["pagina"]="registro"; //Se guarda en la variable de sesión la ventana de registro
            require_once $vistas["layout"]; //Se carga la vista correspondiente
        }
        //Si el usuario guardado como resultado es un objeto de la clase Usuario
        else{
            $usuario->registrarUltimaConexion($codUsuario); //Se registra el inicio de sesión
            $_SESSION["usuario"]=$usuario; //Se guarda en la variable de sesión el objeto usuario
            $_SESSION["pagina"]="inicio"; //Se guarda en la variable de sesión la ventana correspondiente
            header('Location: index.php'); //Se le redirige al index
            exit;
        }
    }
    //Si NO se ha PULSADO ningún BOTÓN o los DATOS son ERRÓNEOS
    else{
        $_SESSION["pagina"]="registro"; //Se guarda en la variable de sesión la ventana de registro
        require_once $vistas["layout"]; //Se carga la vista correspondiente
    }
    
?>