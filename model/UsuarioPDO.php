<?php
/**
 * Archivo UsuarioPDO.php
 *
 * Trabaja contra la capa de datos, creando usuarios y alterando su estado
 * 
 * @package modelo
 */
require_once "DBPDO.php";
/**
 * Class UsuarioPDO
 * 
 * Clase que crea, borra, modifica y valida usuarios
 * 
 * @author Mario Casquero Jáñez
 */
class UsuarioPDO{
    /**
     * Función buscaUsuarioPorCodigo
     * 
     * Última revisión 22/02/2019
     * Se extraen todos los datos del usuario correspondiente
     * 
     * @author Mario Casquero Jáñez
     * @param string $codUsuario código del usuario
     * @return array $aUsuario el usuario correspondiente al código introducido
     */
    public static function buscarUsuarioPorCodigo($codUsuario){
        $aUsuario=[];
        
        $sql="select * from Usuarios where codUsuario=:cod";
        $parametros=[":cod"=>$codUsuario];
        
        $resultado=DBPDO::ejecutaConsulta($sql, $parametros);
        
        if($resultado->rowCount()==1){
            $registros=$resultado->fetchObject();
            $aUsuario["codUsuario"]=$registros->codUsuario;
            $aUsuario["password"]=$registros->password;
            $aUsuario["descUsuario"]=$registros->descUsuario;
            $aUsuario["numAccesos"]=$registros->numAccesos;
            $aUsuario["fechaHoraUltimaConexion"]=$registros->fechaHoraUltimaConexion;
            $aUsuario["perfil"]=$registros->perfil;
        }
        
        return $aUsuario;
    }
    /**
     * Función buscaUsuarioPorDescripcion
     * 
     * Última revisión 22/02/2019
     * Se extraen todos los usuarios correspondientes a la descripción
     * 
     * @author Mario Casquero Jáñez
     * @param string $descUsuario descripción del usuario
     * @param int $pagina página actual
     * @param int $tamanyoPag número de registros por página
     * @return array $aUsuarios array con todos los usuarios encontrados
     */
    public static function buscarUsuarioPorDescripcion($descUsuario, $pagina, $tamanyoPag){
        $contador=0;
        $aUsuario=[];
        $aUsuarios=[];
        
        if($pagina>0){
            $inicio=($pagina-1)*$tamanyoPag;
        }
        else{
            $inicio=0;
        }
        
        $limite=" LIMIT $inicio, $tamanyoPag";
        
        $sql="select * from Usuarios where descUsuario like concat('%',?,'%')";
        $parametros=[$descUsuario];
        
        $resultado= DBPDO::ejecutaConsulta($sql.$limite, $parametros);
        
        if($resultado->rowCount()>0){
            while($registros=$resultado->fetchObject()){
                $aUsuario["codUsuario"]=$registros->codUsuario;
                $aUsuario["password"]=$registros->password;
                $aUsuario["descUsuario"]=$registros->descUsuario;
                $aUsuario["numAccesos"]=$registros->numAccesos;
                $aUsuario["fechaHoraUltimaConexion"]=$registros->fechaHoraUltimaConexion;
                $aUsuario["perfil"]=$registros->perfil;
                $aUsuarios[$contador]=$aUsuario;
                $contador++;
            }
        }
        
        return $aUsuarios;
    }
    /**
     * Función contarUsuarios
     * 
     * Última revisión 22/02/2019
     * Cuenta el total de usuarios de la aplicación
     * 
     * @author Mario Casquero Jáñez
     * @param string $descUsuario descripción del usuario
     * @return int $registros número de usuarios totales
     */
    public static function contarUsuarios($descUsuario){
        $sql="select count(*) from Usuarios where descUsuario like concat('%',?,'%')";
        
        $resultado=DBPDO::ejecutaConsulta($sql, [$descUsuario]);
        if($resultado->rowCount()>0){
            $registros=$resultado->fetchColumn(0);
        }
        else{
            $registros=0;
        }
        return $registros;
    }
    /**
     * Función validarUsuario
     * 
     * Última revisión 22/02/2019
     * Se busca el usuario y password en la DB para validar su existencia
     * 
     * @author Mario Casquero Jáñez
     * @param string $codUsuario código del usuario
     * @param string $password contraseña propia del usuario
     * @return array $aUsuario array que incluye los datos del usuario
     */
    public static function validarUsuario($codUsuario, $password){
        $aUsuario=[]; //Se declara e inicializa la variable
        
        //Se construye la consulta
        $sql="select * from Usuarios where codUsuario=:cod and password=SHA2(:pass, 256)";
        //Se almacenan los parámetros
        $parametros=[":cod"=>$codUsuario, ":pass"=>$password];
        
        $resultado=DBPDO::ejecutaConsulta($sql, $parametros); //Se ejecuta la consulta
        
        if($resultado->rowCount()==1){
            $registros=$resultado->fetchObject();
            $aUsuario["codUsuario"]=$registros->codUsuario;
            $aUsuario["password"]=$registros->password;
            $aUsuario["descUsuario"]=$registros->descUsuario;
            $aUsuario["numAccesos"]=$registros->numAccesos;
            $aUsuario["fechaHoraUltimaConexion"]=$registros->fechaHoraUltimaConexion;
            $aUsuario["perfil"]=$registros->perfil;
        }
        
        return $aUsuario; //Se devuelve el array con los datos
    }
    /**
     * Función altaUsuario
     * 
     * Última revisión 22/02/2019
     * Se inserta un registro en la DB correspondiente a un nuevo usuario
     * 
     * @author Mario Casquero Jáñez
     * @param string $codUsuario código del usuario
     * @param string $password contraseña propia del usuario
     * @param string $descUsuario descripción del usuario
     * @return array $aUsuario array que incluye los datos del nuevo usuario
     */
    public static function altaUsuario($codUsuario, $password, $descUsuario){
        $aUsuario=[]; //Se declara e inicializa la variable
        $fechaHora=new DateTime(); //Se declara e inicializa un objeto DateTime
        
        //Se construye la consulta
        $sql="insert into Usuarios values (:cod, sha2(:pass, 256), :desc, :numAcc, :fechaH, :perf)";
        //Se almacenan los parámetros
        $parametros=[":cod"=>$codUsuario, ":pass"=>$password, ":desc"=>$descUsuario, ":numAcc"=>0, ":fechaH"=>$fechaHora->getTimestamp(), ":perf"=>"usuario"];
        
        $resultado=DBPDO::ejecutaConsulta($sql, $parametros); //Se ejecuta la consulta
        
        if($resultado->rowCount()==1){
            $aUsuario["codUsuario"]=$codUsuario;
            $aUsuario["password"]=$password;
            $aUsuario["descUsuario"]=$descUsuario;
            $aUsuario["numAccesos"]=0;
            $aUsuario["fechaHoraUltimaConexion"]=$fechaHora->getTimestamp();
            $aUsuario["perfil"]="usuario";
        }
        return $aUsuario; //Se devuelve el array con los datos
    }
    /**
     * Función modificarUsuario
     * 
     * Última revisión 22/02/2019
     * Se actualizan los registros en la DB actualizando a su vez los datos del usuario
     * 
     * @author Mario Casquero Jáñez
     * @param string $codUsuario código de usuario
     * @param string $descUsuario descripción del usuario
     * @return boolean dependiendo si todo es correcto o no
     */
    public static function modificarUsuario($codUsuario, $descUsuario){
        //Se construye la consulta
        $sql="update Usuarios set descUsuario=:desc where codUsuario=:cod";
        //Se almacenan los parámetros
        $parametros=[":desc"=>$descUsuario, ":cod"=>$codUsuario];
        
        $resultado=DBPDO::ejecutaConsulta($sql, $parametros); //Se ejecuta la consulta
        
        if($resultado->rowCount()==1){
            return true;
        }
        else{
            return false;
        }
    }
    /**
     * Función cambiarPassword
     * 
     * Última revisión 22/02/2019
     * Se actualiza el campo password en la DB actualizando a su vez la contraseña del usuario
     * 
     * @author Mario Casquero Jáñez
     * @param string $codUsuario código del usuario
     * @param string $password contraseña propia del usuario
     * @return boolean dependiendo de si todo es correcto o no
     */
    public static function cambiarPassword($codUsuario, $password){
        $sql="update Usuarios set password=sha2(:pass, 256) where codUsuario=:cod";
        $parametros=[":pass"=>$password, ":cod"=>$codUsuario];
        
        $resultado=DBPDO::ejecutaConsulta($sql, $parametros);
        
        if($resultado->rowCount()==1){
            return true;
        }
        else{
            return false;
        }
    }
    /**
     * Función borrarUsuario
     * 
     * Última revisión 22/02/2019
     * Se borra el registro en la DB borrando a su vez el usuario
     * 
     * @author Mario Casquero Jáñez
     * @param string $codUsuario código del usuario
     * @return boolean dependiendo de si todo es correcto o no
     */
    public static function borrarUsuario($codUsuario){
        $sql="delete from Usuarios where codUsuario=:cod";
        $parametros=[":cod"=>$codUsuario];
        
        $resultado=DBPDO::ejecutaConsulta($sql, $parametros);
        
        if($resultado->rowCount()==1){
            return true;
        }
        else{
            return false;
        }
        
    }
    /**
     * Función registrarUltimaConexion
     * 
     * Última revisión 22/02/2019
     * Actualiza en la DB el número de accesos y la fecha y hora del último login
     * 
     * @author Mario Casquero Jáñez
     * @param string $codUsuario código del usuario
     * @return boolean dependiendo de si todo es correcto o no
     */
    public static function registrarultimaConexion($codUsuario){
        $fechaHora=new DateTime();
        
        $sql="update Usuarios set numAccesos=numAccesos+1, fechaHoraUltimaConexion=:fechaH where codUsuario=:cod";
        $parametros=[":fechaH"=>$fechaHora->getTimestamp(),":cod"=>$codUsuario];
        $resultado=DBPDO::ejecutaConsulta($sql, $parametros);
        
        if($resultado->rowCount()==1){
                return true;
        }
        else{
            return false;
        }        
    }
    /**
     * Función validarCodNoExiste
     * 
     * Última revisión 22/02/2019
     * Comprueba en la DB si existen registros para el código de usuario correspondiente
     * 
     * @author Mario Casquero Jáñez
     * @param string $codUsuario código del usuario
     * @return boolean dependiendo de si todo es correcto o no
     */
    public static function validarCodNoExiste($codUsuario){
        $sql="select * from Usuarios where codUsuario=:cod";
        $parametros=[":cod"=>$codUsuario];
        
        $resultado=DBPDO::ejecutaConsulta($sql, $parametros);
        
        if($resultado->rowCount()==0){
            return true;
        }
        else{
            return false;
        }
    }
}
