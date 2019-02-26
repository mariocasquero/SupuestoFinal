/**
 * Author:  Mario Casquero Jáñez
 * Created: 22-feb-2019
 */

/*Se crea la base de datos*/
CREATE DATABASE IF NOT EXISTS MCJSupuestoFinal;
/*Se usa la base de datos*/
USE MCJSupuestoFinal;
/*Se crea la tabla Usuarios*/
CREATE TABLE IF NOT EXISTS Usuarios(codUsuario VARCHAR(10) PRIMARY KEY, password VARCHAR(255), descUsuario VARCHAR(255), 
numAccesos INT, fechaHoraUltimaConexion INT, perfil ENUM('usuario', 'administrador'));
/*Se crea el usuario propio de la base de datos*/
CREATE USER 'usuarioMCJSupuestoFinal'@'%' IDENTIFIED BY 'P@ssw0rd';
/*Se dan privilegios al usuario*/
GRANT ALL PRIVILEGES ON MCJSupuestoFinal.* TO 'usuarioMCJSupuestoFinal'@'%';
