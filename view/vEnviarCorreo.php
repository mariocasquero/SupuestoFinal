<form action="../controller/cEnviarCorreo.php" method="post" id="fCorreo">
    <fieldset>
        <legend>Correo</legend>
        
        <label for="nombre">Nombre </label>
        <input type="text" name="nombre" id="nombreCorreo" minlength="3" maxlength="10" size="30"><br>
        <label class="errores"><?php echo $aErrores["nombre"]?></label><br>

        <label for="apellidos">Apellidos </label>
        <input type="text" name="apellidos" id="apellidosCorreo" minlength="3" maxlength="255" size="30"><br>
        <label class="errores"><?php echo $aErrores["apellidos"]?></label><br>

        <label for="apellidos">Descripcion </label>
        <input type="textarea" name="descripcion" id="descripcionCorreo" minlength="3" maxlength="255" size="30"><br>
        <label class="errores"><?php echo $aErrores["apellidos"]?></label><br>

        <input type="submit" name="enviar" id="enviar" value="Enviar">
        <input type="submit" name="volver" id="volver" value="Volver">
    </fieldset>
    
</form>