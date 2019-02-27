<?php
    /**
     * @author Mario Casquero Jáñez
     */   

    $entradaOK=true; //Se declara e inicializa la variable
    
    //Se declara e inicializa el array con los mensajes de error
    $aErrores=[
        "usuario"=>NULL,
        "password"=>NULL
    ];
    
    //Si el usuario PULSA REGISTRARSE
    if(isset($_REQUEST["registrarse"])){
        $_SESSION["pagina"]="registro"; //Se guarda en la variable de sesión la ventana de registro
        header('Location: index.php'); //Se le redirige al index
        require_once $vistas["layout"]; //Se carga la vista correspondiente
        exit;
    }
    
    if(isset($_REQUEST["correo"])){
        $_SESSION["pagina"]="correo"; //Se guarda en la variable de sesión la ventana de registro
        header('Location: index.php'); //Se le redirige al index
        require_once $vistas["layout"]; //Se carga la vista correspondiente
        exit;
    }
    
    //Si el usuario PULSA ACCEDER se pasa a validar la información
    if(isset($_REQUEST["acceder"])){
        $aErrores["usuario"]=validacionFormularios::comprobarAlfabetico($_REQUEST["usuario"], MAXCODUSUARIO, MINCODDESCUSUARIO, OBLIGATORIO); //Se valida el usuario y se almacenan los posibles errores en el array
        $aErrores["password"]=validacionFormularios::comprobarAlfaNumerico($_REQUEST["password"], MAXDESCUSUARIO, MINCODDESCUSUARIO, OBLIGATORIO); //Se valida el password y se almacenan los posibles errores en el array
        
        //Se recorre el array en busca de mensajes de error
        foreach($aErrores as $campo=>$error){
            if($error!=null){ //Si alguna posición contiene un mensaje de error
                $entradaOK=false; //Se le cambia el valor a la variable
                $_REQUEST[$campo]=""; //Se limpia el campo erróneo
            }
        }
    }
    
    //Si el usuario PULSA ACCEDER y NO hay ERRORES
    if(isset($_REQUEST["acceder"]) && $entradaOK){
        $codUsuario=$_REQUEST["usuario"]; //Se almacena el usuario en la variable
        $password=$_REQUEST["password"]; //Se almacena el password en la variable
        
        //Se almacena en una variable el resultado del método de validar usuario
        $usuario=Usuario::validarUsuario($codUsuario, $password);
        
        //Si el usuario guardado como resultado es NULL
        if(is_null($usuario)){
            $_SESSION["pagina"]="login"; //Se guarda en la variable de sesión la ventana de login
            require_once $vistas["layout"]; //Se vuelve a cargar la vista de login
        }
        //Si el usuario guardado como resultado contiene un objeto de la clase Usuario
        else{
            $usuario->registrarUltimaConexion($codUsuario); //Se registra el incio de sesión
            $_SESSION["usuario"]=$usuario; //Se guarda en la variable de sesión el objeto usuario
            $_SESSION["pagina"]="inicio"; //Se guarda en la variable de sesión la ventana de inicio
            header('Location: index.php'); //Se le redirige al index
            exit;
        }
    }
    //Si NO se ha PULSADO ningún BOTÓN o los DATOS son ERRÓNEOS
    else{
        $_SESSION["pagina"]="login"; //Se carga en la variable de sesión la ventana de login
        require_once $vistas["layout"]; //Se carga la vista correspondiente
    }
?>
