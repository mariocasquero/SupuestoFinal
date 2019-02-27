<?php
    
    /**
     * @author Mario Casquero Jáñez
     */
    $entradaOK=true; //Se declara e inicializa la variable
    
    //Se declara e inicializa el array con los mensajes de error
    $aErrores=[
        "nombre"=>NULL,
        "apellidos"=>NULL,
        "descripcion"=>NULL
    ];
    //Si el usuario PULSA REGISTRARSE
    if(isset($_REQUEST["volver"])){
        $_SESSION["pagina"]="login"; //Se guarda en la variable de sesión la ventana de login
        header('Location: index.php'); //Se le redirige al index
        require_once $vistas["layout"]; //Se carga la vista correspondiente
        exit;
    }
    
    if(isset($_REQUEST["enviar"])){
        $aErrores["nombre"]=validacionFormularios::comprobarAlfabetico($_REQUEST["nombre"], MAXCODUSUARIO, MINCODDESCUSUARIO, OBLIGATORIO); //Se valida el nombre y se almacenan los posibles errores en el array
        $aErrores["apellidos"]=validacionFormularios::comprobarAlfaNumerico($_REQUEST["apellidos"], MAXDESCRIPCION, MINCODDESCUSUARIO, OBLIGATORIO); //Se validan los apellidos y se almacenan los posibles errores en el array
        $aErrores["descripcion"]=validacionFormularios::comprobarAlfaNumerico($_REQUEST["descripcion"], MAXDESCRIPCION, MINCODDESCUSUARIO, OBLIGATORIO); //Se valida la descripcion y se almacenan los posibles errores en el array
        //Se recorre el array en busca de mensajes de error
        foreach($aErrores as $campo=>$error){
            if($error!=null){ //Si alguna posición contiene un mensaje de error
                $entradaOK=false; //Se le cambia el valor a la variable
                $_REQUEST[$campo]=""; //Se limpia el campo erróneo
            }
        }
    }
    //Si el usuario PULSA ACCEDER y NO hay ERRORES
    if(isset($_REQUEST["enviar"]) && $entradaOK){
        $para="mariobte22@gmail.com";
        $nombre=$_REQUEST["nombre"]; //Se almacena el nombre en la variable
        $apellidos=$_REQUEST["apellidos"]; //Se almacenan los apellidos en la variable
        $descripcion=$_REQUEST["descripcion"]; //Se almacena la descripción en la variable
        //Creamos cabecera.
        $headers = 'From'." ".$nombre." ".$apellidos . "\r\n";
        $headers .= "Content-type: text/html; charset=utf-8";

        //Componemos cuerpo correo.
        $mensajeCorreo="Nombre: ".$nombre;
        $mensajeCorreo.="\r\n";
        $mensajeCorreo.="Apellidos: ".$apellidos;
        $mensajeCorreo.="\r\n";
        $mensajeCorreo.="Asunto: " . "correo";
        $mensajeCorreo.="\r\n";
        $mensajeCorreo.="Mensaje: ".$descripcion;
        $mensajeCorreo.="\r\n";
        
        if(mail($para, $subject, $mensajeCorreo, $headers)) {
            $_SESSION["pagina"]="login"; //Se guarda en la variable de sesión la ventana de login
            header('Location: index.php'); //Se le redirige al index
            exit;
        }else{
            $_SESSION["pagina"]="correo"; //Se carga en la variable de sesión la ventana de login
            require_once $vistas["layout"]; //Se carga la vista correspondiente      
        }
 
    }
    //Si NO se ha PULSADO ningún BOTÓN o los DATOS son ERRÓNEOS
    else{
        $_SESSION["pagina"]="correo"; //Se carga en la variable de sesión la ventana de login
        require_once $vistas["layout"]; //Se carga la vista correspondiente
    }