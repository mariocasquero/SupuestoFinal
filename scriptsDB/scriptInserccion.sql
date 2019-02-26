/**
 * Author:  Mario Casquero Jáñez
 * Created: 22-feb-2019
 */

/*Se usa la base de datos*/
USE MCJSupuestoFinal;
/*Se insertan los registros iniciales de los usuarios*/
INSERT INTO Usuarios VALUES 
('mario', sha2('paso', 256), 'Mario Casquero', 0, 0, 'usuario'),
('baldo', sha2('paso', 256), 'Baldomero Sánchez', 0, 0, 'usuario'),
('admin', sha2('paso', 256), 'Administrador', 0, 0, 'administrador'),
('heraclio', sha2('paso', 256), 'Heraclio Borbujo', 0, 0, 'usuario'),
('israel', sha2('paso', 256), 'Israel García', 0, 0, 'usuario'),
('christian', sha2('paso', 256), 'Christian Muñiz', 0, 0, 'usuario'),
('david', sha2('paso', 256), 'David García', 0, 0, 'usuario'),
('adrian', sha2('paso', 256), 'Adrián Cando', 0, 0, 'usuario'),
('tania', sha2('paso', 256), 'Tania Mateos', 0, 0, 'usuario'),
('alejandro', sha2('paso', 256), 'Alejandro Hernández', 0, 0, 'usuario'),
('victor', sha2('paso', 256), 'Víctor Mielgo', 0, 0, 'usuario'),
('maria', sha2('paso', 256), 'Maria Criado', 0, 0, 'usuario'),
('amor', sha2('paso', 256), 'Amor Rodríguez', 0, 0, 'usuario'),
('tere', sha2('paso', 256), 'Teresa Rodríguez', 0, 0, 'usuario');