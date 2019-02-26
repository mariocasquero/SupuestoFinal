<?php
/**
 * Archivo DBPDO.php
 * 
 * Clase que ejecuta las consultas con la base de datos utilizando PDO
 * 
 * @package modelo
 */

/**
 * Class DBPDO
 */

class DBPDO{
    /**
     * EjecutaConsulta
     * 
     * Última revisión 22/02/2019
     * Método estático que establece la conexión con la base de datos y ejecuta las consultas con los parámetros proporcionados
     * 
     * @author Mario Casquero Jáñez
     * @param string $sql sentencia sql
     * @param string $parametros parámetros recibidos para ejecución
     * @return $consulta resultado de la consulta a la base de datos
     */
    
    public static function ejecutaConsulta($sql, $parametros){
        try{
            $miDataBase=new PDO(DSN, USUARIO, PASSWORD); //Se conecta con la base de datos
            $miDataBase->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //Se establecen los atributos de la conexión
            $consulta=$miDataBase->prepare($sql); //Se prepara la consulta
            $consulta->execute($parametros); //Se ejecuta la consulta
        }catch(PDOException $pdoe){
            $consulta=NULL;
            echo "Mensaje de error: ".$pdoe->getMessage()."<br>";
            echo "Código de error: ".$pdoe->getCode()."<br>";
            echo "Línea de error: ".$pdoe->getLine();
            unset($miDataBase); //Se destruye la conexión a la base de datos
        }
        return $consulta; //Se devuelve la consulta
    }    
}
?>