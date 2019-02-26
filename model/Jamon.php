<?php
/**
 * Archivo Jamon.php
 * 
 * Trabaja con la lógica de negocio creando jamones y alterando su estado
 *
 * @package modelo
 */
require_once "JamonPDO.php";
/**
 * Class Jamon
 * 
 * Clase que crea, borra, modifica y valida jamones
 * 
 * @author Mario Casquero Jáñez
 */
class Jamon{
    /**
     * @var string $codJamon código del jamón
     */
    private $codJamon;
    /**
     * @var string $descJamon descripción del jamón
     */
    private $descJamon;
    /**
     * @var int $precioJamon precio del jamón 
     */
    private $precioJamon;
    /**
     * @var string $tipoJamon tipo de jamón
     */
    private $tipoJamon;
    
    /**
     * Función constructor
     * 
     * Última revisión 26/02/2019
     * Crea el objeto jamón con los parámetros recibidos
     * 
     * @author Mario Casquero Jáñez
     * @param string $codJamon código del jamón
     * @param string $descJamon descripción del jamón
     * @param int $precioJamon precio del jamón
     * @param string $tipoJamon tipo de jamón
     */
    function __construct($codJamon, $descJamon, $precioJamon, $tipoJamon){
        $this->codJamon=$codJamon;
        $this->descJamon=$descJamon;
        $this->precioJamon=$precioJamon;
        $this->tipoJamon=$tipoJamon;
    }
    /**
     * Función getCodJamon
     * 
     * Devuelve el código del jamón
     * 
     * @return string
     */
    function getCodJamon(){
        return $this->codJamon;
    }
    /**
     * Función getDescJamon
     * 
     * Devuelve la descripción del jamón
     * 
     * @return string
     */
    function getDescJamon(){
        return $this->descJamon;
    }
    /**
     * Función getPrecioJamon
     * 
     * Devuelve el precio del jamón
     * 
     * @return int
     */
    function getPrecioJamon(){
        return $this->precioJamon;
    }
    /**
     * Función getTipoJamon
     * 
     * Devuelve el tipo del jamón
     * 
     * @return string
     */
    function getTipoJamon(){
        return $this->tipoJamon;
    }
    /**
     * Función setDescJamon
     * 
     * Modifica la descripción del jamón
     * 
     * @param string $descJamon descripción del jamón
     */
    function setDescJamon($descJamon){
        $this->descJamon=$descJamon;
    }
    /**
     * Función setPrecioJamon
     * 
     * Modifica el precio del jamón
     * 
     * @param int $precioJamon precio del jamón
     */
    function setPrecioJamon($precioJamon){
        $this->precioJamon=$precioJamon;
    }
    /**
     * Función buscaJamonpPorCodigo
     * 
     * Última revisión 26/02/2019
     * Extrae toda la información del jamón en base al código proporcionado
     * 
     * @author Mario Casquero Jáñez
     * @param string $codJamon código del jamón
     * @return \Jmaon $jamon objeto de la clase Jamon con los atributos de éste
     */
    public static function buscaJamonPorCodigo($codJamon){
        $jamon=NULL;
        
        $aJamon=JamonPDO::buscaJamonPorCodigo($codJamon);
        
        if(!empty($aJamon)){
            $jamon=new Departamento($aJamon["codJamon"], $aJamon["descJamon"], $aJamon["precioJamon"], $aJamon["tipoJamon"]);
        }
        
        return $jamon;
    }
    /**
     * Función buscaJamonPorDescripcion
     * 
     * Última revisión 26/02/2019
     * Extrae toda la información de todos los jamones coincidentes
     * 
     * @author Mario Casquero Jáñez
     * @param string $descJamon descripción del jamón
     * @param string $filtro criterio de búsqueda
     * @param int $pagina página actual de la ventana
     * @param int $tamanyoPag número de registros por página
     * @return \Jamon $aJamones array de objetos de la clase Jamon con los atributos de éste
     */
    public static function buscaJamonPorDescripcion($descJamon, $filtro, $pagina, $tamanyoPag){
        $aJamones=[];
        
        $jamones=JamonPDO::buscaJamonPorDescripcion($descJamon, $filtro, $pagina, $tamanyoPag);

        if(!empty($jamones)){
            for($i=0; $i<count($jamones); $i++){
                $aJamones[$i]=new Jamon($jamones[$i]["codJamon"], $jamones[$i]["descJamon"], $jamones[$i]["precioJamon"], $jamones[$i]["tipoJamon"]);
            }
        }
        return $aJamones;
    }
    /**
     * Función contarJamones
     * 
     * Última revisión 26/02/2019
     * Cuenta el número total de jamones
     * 
     * @author Mario Casquero Jáñez
     * @param string $descJamon descripción del jamón
     * @param string $filtro criterio de búsqueda
     * @return int número de jamones totales
     */
    public static function contarJamones($descJamon, $filtro){
        return JamonPDO::contarJamones($descJamon, $filtro);
    }
    /**
     * Función altaJamon
     * 
     * Última revisión 26/02/2019
     * Registra un nuevo jamón en la aplicación
     * 
     * @author Mario Casquero Jáñez
     * @param string $codJamon código del jamón
     * @param string $descJamon descripción del jamón
     * @param int $precioJamon precio del jamón
     * @param string $tipoJamon tipo del jamón
     * @return \Jamon $jamon objeto de la clase Jamon con los atributos de éste
     */
    public static function altaJamon($codJamon, $descJamon, $precioJamon, $tipoJamon){
        $jamon=NULL;
        
        $arrayJamon=JamonPDO::altaJamon($codJamon, $descJamon, $precioJamon, $tipoJamon);
        
        if(!empty($arrayJamon)){
            $jamon=new Jamon($codJamon, $descJamon, $precioJamon, $tipoJamon);
        }
        
        return $jamon;
    }
    /**
     * Función bajaFisicaJamon
     * 
     * Última revisión 26/02/2019
     * Borra un jamón de la aplicación
     * 
     * @author Mario Casquero Jáñez
     * @param string $codJamon código del jamón
     * @return boolean dependiendo de si todo es correcto o no
     */
    public function bajaFisicaJamon($codJamon){
        return JamonPDO::bajaFisicaJamon($codJamon);
    }
    /**
     * Función modificarJamon
     * 
     * Última revisión 26/02/2019
     * Modifica un jamón de la aplicación
     * 
     * @author Mario Casquero Jáñez
     * @param string $descJamon descripción del jamón
     * @param int $precioJamon precio del jamón
     * @return boolean dependiendo de si todo es correcto o no
     */
    public function modificarJamon($descJamon, $precioJamon){
        $this->setDescJamon($descJamon);
        $this->setPrecioJamon($precioJamon);
        return JamonPDO::modificarJamon($this->getCodJamon(), $descJamon, $precioJamon);
    }
    /**
     * Función validaCodNoExiste
     * 
     * Última revisión 26/02/2019
     * @param string $codJamon código del jamón
     * 
     * @author Mario Casquero Jáñez
     * @return boolean dependiendo de si no existe ningún departamento
     */
    public static function validaCodNoExiste($codJamon){
        return JamonPDO::validaCodNoExiste($codJamon);
    }
}