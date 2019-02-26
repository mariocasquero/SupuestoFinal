<?php
    //Si el usuario ha iniciado sesión se cargará la vista de inicio
    if(isset($_SESSION["usuario"])){
        $vista=$vistas["inicio"]; //Se almacena la vista de inicio en la variable
    }
    //Si no ha iniciado sesión se cargará la vista del login
    else{
        $vista=$vistas["login"]; //Se almacena la vista de login en la variable
    }
    //Si el usuario ha accedido a alguna ventana, se cargará la vista correspondiente
    if(isset($_SESSION["pagina"])){
        $vista=$vistas[$_SESSION["pagina"]]; //Se almacena la vista de la ventana en la variable
    }
?>
<html manifest="doc/manifiesto.manifest">
    <head>
        <title>DWEC Supuesto Final</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="webroot/css/estilos.css">
        <script src="webroot/js/jquery-3.3.1.js"></script>
        <link rel="manifest" href="doc/manifiesto.json">
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    </head>
    
    <body>
        <header>
            <h1>DWEC Supuesto Final</h1>
            <i class="far fa-user"></i>
            <label id="nombre">Acceder</label>
            <form action="<?php ?>" method="post" id="fLogin">
                <label for="usuario">Usuario </label>
                <input type="text" name="usuario" id="usuarioL"><br>
                <label class="errores text-warning"><?php echo $aErrores["usuario"]?></label>
                
                <label for="password">Password </label>
                <input type="password" name="password" id="passwordL"><br>
                <label class="errores text-warning"><?php echo $aErrores["password"]?></label>
                
                <input type="submit" name="acceder" id="acceder" value="Acceder">
                <input type="submit" name="registrarse" id="registrarse" value="Registrarse">
            </form>
        </header>

        <?php
            require_once $vista; //Se carga la vista
        ?>
        <footer>
            <p>
                <a href=""><i class="fab fa-gitlab"></i></a>
                Mario Casquero Jáñez 2019
                <a href=""><img src="webroot/media/phpdoc.png" id="phpdoc"></a>
            </p>
        </footer>
    </body>
    <script>
    $("#fLogin").hide();
    $(".fa-user").click(function(){
        $("#fLogin").toggle();
    });
    </script>
</html>