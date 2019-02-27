<h2 class="cabecera">Registro</h2>

<form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post" id="fRegsitro">
    <fieldset>
        <legend>Registro</legend>
        
        <label>Usuario</label>
        <input type="text" name="usuarioR" id="usuarioR" size="27.5"><br>
        <label class="errores"><?php echo $aErrores["usuarioR"]?></label><br>
        
        <label>Descripción</label>
        <input type="text" name="descripcionR" id="descripcionR" size="27.5"><br>
        <label class="errores"><?php echo $aErrores["descripcionR"]?></label><br>
        
        <label>Password</label>
        <input type="password" name="passwordR" id="passwordR" size="27.5"><br>
        <label class="errores"><?php echo $aErrores["passwordR"]?></label><br>
        
        <input type="submit" name="aceptar" id="aceptar" value="Aceptar">
        <input type="submit" name="volver" id="volver" value="Volver">
    </fieldset>
    
</form>