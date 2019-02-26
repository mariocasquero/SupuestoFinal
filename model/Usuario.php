<?php
/**
 * Archivo Usuario.php
 *
 * Trabaja con la lógica de negocio creando usuarios y alterando su estado
 * 
 * @package modelo
 */
require_once "UsuarioPDO.php";
/**
 * Class Usuario
 * 
 * Clase que crea, borra, modifica y valida usuarios
 * 
 * @author Mario Casquero Jáñez
 */
class Usuario{
    /**
     * @var string $codUsuario código del usuario 
     */
    private $codUsuario;
    /**
     * @var string $password contraseña propia del usuario
     */
    private $password;
    /**
     * @var string $descUsuario descripción del usuario 
     */
    private $descUsuario;
    /**
     * @var integer $numAccesos número de veces que se ha iniciado sesión
     */
    private $numAccesos;
    /**
     * @var integer $fechaHoraUltimaConexion registro del último inicio de sesión
     */
    private $fechaHoraUltimaConexion;
    /**
     * @var string $perfil tipo de usuario 
     */
    private $perfil;
    
    /**
     * Función constructor
     * 
     * Última revisión 22/02/2019
     * Crea el objeto usuario con los parámetros recibidos
     * 
     * @author Mario Casquero Jáñez
     * @param string $codUsuario código del usuario
     * @param string $password contraseña propia del usuario
     * @param string $descUsuario descripción del usuario
     * @param integer $numAccesos número de veces que se ha iniciado sesión
     * @param integer $fechaHoraUltimaConexion registro del último inicio de sesión
     * @param string $perfil tipo de usuario
     */
    public function __construct($codUsuario, $password, $descUsuario, $numAccesos, $fechaHoraUltimaConexion, $perfil){
        $this->codUsuario=$codUsuario;
        $this->password=$password;
        $this->descUsuario=$descUsuario;
        $this->numAccesos=$numAccesos;
        $this->fechaHoraUltimaConexion=$fechaHoraUltimaConexion;
        $this->perfil=$perfil;
    }
    /**
     * Función getCodUsuario
     * 
     * Devuelve el código de usuario
     * 
     * @return string
     */
    public function getCodUsuario(){
        return $this->codUsuario;
    }
    /**
     * Función getPassword
     * 
     * Devuelve el password del usuario
     * 
     * @return string
     */
    public function getPassword(){
        return $this->password;
    }
    /**
     * Función getDescUsuario
     * 
     * Devuelve la descripción del usuario
     * 
     * @return string
     */
    public function getDescUsuario(){
        return $this->descUsuario;
    }
    /**
     * Función getNumAccesos
     * 
     * Devuelve el número de veces que ha iniciado sesión
     * 
     * @return integer
     */
    public function getNumAccesos(){
        return $this->numAccesos;
    }
    /**
     * Función getFechaHoraUltimaConexion
     * 
     * Devuelve la última vez que se ha iniciado sesión
     * 
     * @return integer
     */
    public function getFechaHoraUltimaConexion(){
        return $this->fechaHoraUltimaConexion;
    }
    /**
     * Función getPerfil
     * 
     * Devuelve el tipo de usuario
     * 
     * @return string
     */
    public function getPerfil(){
        return $this->perfil;
    }
    /**
     * Función setCodUsuario
     * 
     * Modifica el código de usuario
     * 
     * @param string $codUsuario código del usuario
     */
    public function setCodUsuario($codUsuario){
        $this->codUsuario=$codUsuario;
    }
    /**
     * Función setPassword
     * 
     * Modifica la contraseña del usuario
     * 
     * @param string $password contraseña propia del usuario
     */
    public function setPassword($password){
        $this->password=$password;
    }
    /**
     * Función setDescUsuario
     * 
     * Modifica la descripción del usuario
     * 
     * @param string $descUsuario descripción del usuario
     */
    public function setDescUsuario($descUsuario){
        $this->descUsuario=$descUsuario;
    }
    /**
     * Función setNumAccesos
     * 
     * Modifica el número de veces que se ha iniciado sesión
     * 
     * @param integer $numAccesos número de veces que se ha iniciado sesión
     */
    public function setNumAccesos($numAccesos){
        $this->numAccesos=$numAccesos;
    }
    /**
     * Función setFechaHoraUltimaConexion
     * 
     * Modifica el registro del último inicio de sesión
     * 
     * @param int $fechaHoraUltimaConexion registro del último inicio de sesión
     */
    public function setFechaHoraUltimaConexion($fechaHoraUltimaConexion){
        $this->fechaHoraUltimaConexion=$fechaHoraUltimaConexion;
    }
    /**
     * Función setPerfil
     * 
     * Modifica el tipo de usuario
     * 
     * @param string $perfil tipo de usuario
     */
    public function setPerfil($perfil){
        $this->perfil=$perfil;
    }
    /**
     * Función buscarUsuarioPorCodigo
     * 
     * Última revisión 22/02/2019
     * Extrae toda la información del usuario en base al código proporcionado
     * 
     * @author Mario Casquero Jáñez
     * @param string $codUsuario código del usuario
     * @return \Usuario $usuario objeto de la clase Usuario con los atributos de éste
     */
    public static function buscarUsuarioPorCodigo($codUsuario){
        $usuario=NULL;
        
        $aUsuario=UsuarioPDO::buscarUsuarioPorCodigo($codUsuario);
        
        if(!empty($aUsuario)){
            $usuario=new Usuario($aUsuario["codUsuario"], $aUsuario["password"], $aUsuario["descUsuario"], $aUsuario["numAccesos"], $aUsuario["fechaHoraUltimaConexion"], $aUsuario["perfil"]);
        }
        return $usuario;
    }

    /**
     * Función buscaUsuarioPorDescripcion
     * 
     * Última revisión 22/02/2019
     * Extrae toda la información de todos los usuarios coincidentes
     * 
     * @author Mario Casquero Jáñez
     * @param string $descUsuario descripción del usuario
     * @param int $pagina página actual de la ventana
     * @param int $tamanyoPag número de registros por página
     * @return \Usuario $aUsuarios array de objetos de la clase Usuario con los atributos de éste
     */
    public static function buscaUsuarioPorDescripcion($descUsuario, $pagina, $tamanyoPag){
        $aUsuarios=[];
        $usuarios=[];
        
        $usuarios=UsuarioPDO::buscarUsuarioPorDescripcion($descUsuario, $pagina, $tamanyoPag);
        
        if(!empty($usuarios)){
            for($i=0; $i<count($usuarios); $i++){
                $aUsuarios[$i]=new Usuario($usuarios[$i]["codUsuario"], $usuarios[$i]["password"], $usuarios[$i]["descUsuario"], $usuarios[$i]["numAccesos"], $usuarios[$i]["fechaHoraUltimaConexion"], $usuarios[$i]["perfil"]);
            }
        }
        return $aUsuarios;
    }
    /**
     * Función contarUsuarios
     * 
     * Última revisión 22/02/2019
     * Cuenta el número total de usuarios
     * 
     * @author Mario Casquero Jáñez
     * @param string $descUsuario descripción del usuario
     * @return int número de usuarios totales
     */
    public static function contarUsuarios($descUsuario){
        return UsuarioPDO::contarUsuarios($descUsuario);
    }
    /**
     * Función validarUsuario
     * 
     * Última revisión 22/02/2019
     * Valida las credenciales del usuario
     * 
     * @author Mario Casquero Jáñez
     * @param string $codUsuario código del usuario
     * @param string $password contraseña propia del usuario
     * @return \Usuario $usuario objeto de la clase Usuario con los atributos de éste
     */    
    public static function validarUsuario($codUsuario, $password){
        $usuario=NULL; //Se declara e inicializa la variable
            $aUsuario=UsuarioPDO::validarUsuario($codUsuario, $password);
            
            //Se comprueba si el array no está vacío
            if(!empty($aUsuario)){
                $usuario=new Usuario($codUsuario, $password, $aUsuario["descUsuario"], $aUsuario["numAccesos"], $aUsuario["fechaHoraUltimaConexion"], $aUsuario["perfil"]);
            }
        return $usuario; //Se devuelve el usuario
    }
    /**
     * Función altaUsuario
     * 
     * Última revisión 22/02/2019
     * Registra un nuevo usuario en la aplicación
     * 
     * @author Mario Casquero Jáñez
     * @param string $codUsuario código del usuario
     * @param string $password contraseña propia del usuario
     * @param string $descUsuario descripción del usuario
     * @return \Usuario $usuario objeto de la clase Usuario con los atributos de éste
     */
    public static function altaUsuario($codUsuario, $password, $descUsuario){
        $arrayUsuario=[]; //Se declara e inicializa la variable
        $usuario=NULL; //Se declara e inicializa la variable
              
        $arrayUsuario=UsuarioPDO::altaUsuario($codUsuario, $password, $descUsuario);  
        
        //Se comprueba si el array no está vacío
        if(!empty($arrayUsuario)){            
            $usuario=new Usuario($codUsuario, $password, $descUsuario, $arrayUsuario["numAccesos"], $arrayUsuario["fechaHoraUltimaConexion"], $arrayUsuario["perfil"]);
        }
        return $usuario; //Se devuelve el objeto
    }
    /**
     * Función modificarUsuario
     * 
     * Última revisión 22/02/2019
     * Módifica el usuario de la aplicación
     * 
     * @author Mario Casquero Jáñez
     * @param string $descUsuario descripción del usuario
     * @return boolean dependiendo de si todo es correcto o no
     */
    public function modificarUsuario($descUsuario){
        $this->setDescUsuario($descUsuario);
        return UsuarioPDO::modificarUsuario($this->getCodUsuario(), $descUsuario);
    }
    /**
     * Función cambiarPassword
     * 
     * Última revisión 22/02/2019
     * Modifica la contraseña de un usuario de la aplicación
     * 
     * @author Mario Casquero Jáñez
     * @param string $password contraseña propia del usuario
     * @return boolean dependiendo de si todo es correcto o no
     */
    public function cambiarPassword($password){
        $this->setPassword($password);
        return UsuarioPDO::cambiarPassword($this->getCodUsuario(), $password);
    }
    /**
     * Función borrarUsuario
     * 
     * Última revisión 22/02/2019
     * Borra un usuario de la aplicación
     * 
     * @param string $codUsuario código del usuario
     * @return boolean dependiendo de si todo es correcto o no
     */
    public function borrarUsuario($codUsuario){
        return UsuarioPDO::borrarUsuario($codUsuario);
    }
    /**
     * Función registrarUltimaConexion
     * 
     * Última revisión 22/02/2019
     * Registra la marca de tiempo del último inicio de sesión del usuario
     * 
     * @author Mario Casquero Jáñez
     * @param string $codUsuario código del usuario
     * @return boolean dependiendo de si todo es correcto o no
     */
    public function registrarUltimaConexion($codUsuario){
        return UsuarioPDO::registrarultimaConexion($codUsuario);
    }
    /**
     * Función validarCodNoExiste
     * 
     * Última revisión 22/02/2019
     * Comprueba si existe algún usuario con el código recibido
     * 
     * @author Mario Casquero Jáñez
     * @param string $codUsuario código del usuario
     * @return boolean dependiendo de si no existe ningún usuario
     */
    public static function validarCodNoExiste($codUsuario){
        return UsuarioPDO::validarCodNoExiste($codUsuario);
    }
}
