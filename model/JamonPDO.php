<?php
/**
 * Archivo JamonPDO.php
 * 
 * Trabaja contra la capa de datos, creando jamones y alterando su estado
 *
 * @package modelo
 */
require_once "DBPDO.php";
/**
 * Class JamonPDO
 * 
 * Clase que crea, borra, modifica y valida jamones
 * 
 * @author Mario Casquero Jáñez
 */
class JamonPDO{
    /**
     * Función buscaJamonPorCodigo
     * 
     * Última revisión 26/02/2019
     * Se extraen todos los datos del jamón correspondiente
     * 
     * @author Mario Casquero Jáñez
     * @param string $codJamon código del jamón
     * @return array $aJamon el jamonón correspondiente al código introducido
     */
    public static function buscaJamonPorCodigo($codJamon){
        $aJamon=[]; //Se declara e inicializa la variable
        
        //Se construye la consulta
        $sql="select * from Jamones where codJamon=:cod";
        //Se almacenan los parámetros
        $parametros=[":cod"=>$codJamon];
        
        $resultado=DBPDO::ejecutaConsulta($sql, $parametros); //Se ejecuta la consulta
        
        if($resultado->rowCount()==1){
            $registros=$resultado->fetchObject();
            $aJamon["codJamon"]=$registros->codJamon;
            $aJamon["descJamon"]=$registros->descJamon;
            $aJamon["precioJamon"]=$registros->precioJamon;
            $aJamon["tipoJamon"]=$registros->tipoJamon;
        }
        
        return $aJamon; //Se devuelve el array de jamones
    }
    
    /**
     * Función buscaJamonPorDescripcion
     * 
     * Última revisión 26/02/2019
     * Se extraen todos los jamones correspondientes a la descripción
     * 
     * @author Mario Casquero Jáñez
     * @param string $descJamon descripción del jamón
     * @param string $filtro criterio de búsqueda
     * @param int $pagina página actual de la ventana
     * @param int $tamanyoPag número de registros por página
     * @return array $aJamones array con todos los jamones encontrados
     */
    public static function buscaJamonPorDescripcion($descJamon, $filtro, $pagina, $tamanyoPag){
        $contador=0;
        $estado=NULL;
        $aJamones=[];
        $aJamon=[];
        
        if($pagina>0){
            $inicio=($pagina-1)*$tamanyoPag;
        }
        else{
            $inicio=0;
        }
        
        if($filtro=="blanco"){
            $estado=" AND tipoJamon='blanco' ";
        }
        else{
            if($filtro=="bellota"){
                $estado=" AND tipoJamon='bellota' ";
            }
            else{
                if($filtro=="cebo"){
                    $estado=" AND tipoJamon='cebo' ";
                }
                else{
                    if($filtro=="recebo"){
                        $estado=" AND tipoJamon='recebo' ";
                    }
                    else{
                        $estado="";
                    }
                }
            }
        }
        
        $limite=" LIMIT $inicio, $tamanyoPag";
        
        $sql="select * from Jamones where descJamon like concat('%',?,'%')";
        $parametros=[$descJamon];
        
        $resultado=DBPDO::ejecutaConsulta($sql.$estado.$limite, $parametros);
        
        if($resultado->rowCount()>0){
            while($registros=$resultado->fetchObject()){
                $aJamon["codJamon"]=$registros->codJamon;
                $aJamon["descJamon"]=$registros->descJamon;
                $aJamon["precioJamon"]=$registros->precioJamon;
                $aJamon["tipoJamon"]=$registros->tipoJamon;
                $aJamones[$contador]=$aJamon;
                $contador++;
            }            
        }
        return $aJamones;
    }
    /**
     * Función contarJamones
     * 
     * Última revisión 26/02/2019
     * Cuenta el total de jamones de la aplicación
     * 
     * @author Mario Casquero Jáñez
     * @param string $descJamon descripción del jamón
     * @param string $filtro criterio de búsqueda
     * @return int $registros número de jamones totales
     */
    public static function contarJamones($descJamon, $filtro){
        $sql="select count(*) from Jamones where descJamon like concat('%',?,'%')";
        
        $resultado=DBPDO::ejecutaConsulta($sql.$filtro, [$descJamon]);
        if($resultado->rowCount()>0){
            $registros=$resultado->fetchColumn(0);
        }
        else{
            $registros=0;
        }
        return $registros;
    }
    /**
     * Función altaJamon
     * 
     * Última revisión 26/02/2019
     * Inserta un registro en la DB correspondiente a un nuevo jamón
     * 
     * @author Mario Casquero Jáñez
     * @param string $codJamon código del jamón
     * @param string $descJamon descripción del jamón
     * @param int $precioJamon precio del jamón
     * @param string $tipoJamon tipo del jamón
     * @return array $jamon array con los datos del nuevo jamón
     */
    public static function altaJamon($codJamon, $descJamon, $precioJamon, $tipoJamon){
        $jamon=[];
        
        $sql="insert into Jamones values (:cod, :desc, :precio, :tipo)";
        $parametros=[":cod"=>$codJamon, ":desc"=>$descJamon, ":precio"=>$precioJamon, ":tipo"=>$tipoJamon];
        
        $resultado=DBPDO::ejecutaConsulta($sql, $parametros);
        
        if($resultado->rowCount()==1){
            $jamon["codJamon"]=$codJamon;
            $jamon["descJamon"]=$descJamon;
            $jamon["precioJamon"]=$precioJamon;
            $jamon["tipoJamon"]=$tipoJamon;
        }        
        return $jamon;
    }
    /**
     * Función bajaFisicaJamon
     * 
     * Última revisión 26/02/2019
     * Se borra el registro en la DB borrando a su vez el jamón
     * 
     * @author Mario Casquero Jáñez
     * @param string $codJamon código del jamón
     * @return boolean dependiendo de si todo es correcto o no
     */
    public static function bajaFisicaJamon($codJamon){
        $sql="delete from Jamones where codJamon=:cod";
        $parametros=[":cod"=>$codJamon];
        
        $resultado=DBPDO::ejecutaConsulta($sql, $parametros);
        
        if($resultado->rowCount()==1){
            return true;
        }
        else{
            return false;
        }
    }
    /**
     * Función modificarJamon
     * 
     * Última revisión 26/02/2019
     * Se actualizan los registros en la DB actualizando a su vez los datos del jamón
     * 
     * @author Mario Casquero Jáñez
     * @param string $codJamon código del jamón
     * @param string $descJamon descripción del jamón
     * @param int precio precio del jamón
     * @return boolean dependiendo de si todo es correcto o no
     */
    public static function modificarJamon($codJamon, $descJamon, $precioJamon){
        $sql="update Jamones set descJamon=:desc, precioJamon=:precio where codJamon=:cod";
        $parametros=[":desc"=>$descJamon, ":precio"=>$precioJamon, ":cod"=>$codJamon];
        
        $resultado=DBPDO::ejecutaConsulta($sql, $parametros);
        
        if($resultado->rowCount()==1){
            return true;
        }
        else{
            return false;
        }
    }
    /**
     * Función validaCodNoExiste
     * 
     * Última revisión 26/02/2019
     * Comprueba en la DB si existen los datos para el jamón correspondiente
     * 
     * @author Mario Casquero Jáñez
     * @param string $codJamon código del jamón
     * @return boolean dependiendo de si todo es correcto o no
     */
    public static function validaCodNoExiste($codJamon){
        $sql="select * from Jamones where codJamon=:cod";
        $parametros=[":cod"=>$codJamon];
        
        $resultado=DBPDO::ejecutaConsulta($sql, $parametros);
        
        if($resultado->rowCount()==0){
            return true;
        }
        else{
            return false;
        }
    }
}