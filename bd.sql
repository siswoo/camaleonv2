DROP DATABASE IF EXISTS sistemav2;
CREATE DATABASE sistemav2;
USE sistemav2;

DROP TABLE IF EXISTS roles;
CREATE TABLE roles (
	id INT AUTO_INCREMENT,
	nombre VARCHAR(250) NOT NULL,
	estatus INT NOT NULL,
	inicio INT NOT NULL,
	responsable INT NOT NULL,
	id_empresa INT NOT NULL,
	fecha_creacion date NOT NULL,
	PRIMARY KEY (id)
); ALTER TABLE roles CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
INSERT INTO roles (nombre,estatus,inicio,responsable,id_empresa,fecha_creacion) VALUES 
('admin',1,1,1,1,'2021-04-18'),
('modelos',1,1,1,1,'2021-04-18'),
('nominas',1,1,1,1,'2021-10-15');

DROP TABLE IF EXISTS modulos;
CREATE TABLE modulos (
	id INT AUTO_INCREMENT,
	nombre VARCHAR(250) NOT NULL,
	orden INT NOT NULL,
	estatus INT NOT NULL,
	responsable INT NOT NULL,
	fecha_creacion date NOT NULL,
	PRIMARY KEY (id)
); ALTER TABLE modulos CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
INSERT INTO modulos (nombre,orden,estatus,responsable,fecha_creacion) VALUES 
('administrativo',1,1,1,'2021-08-11'),
('operacional',2,1,1,'2021-08-11'),
('financiero',3,1,1,'2021-08-11'),
('marketing',4,1,1,'2021-08-11'),
('comercial',5,1,1,'2021-08-11');

DROP TABLE IF EXISTS funciones;
CREATE TABLE funciones (
	id INT AUTO_INCREMENT,
	ver INT NOT NULL,
	crear INT NOT NULL,
	modificar INT NOT NULL,
	eliminar INT NOT NULL,
	responsable INT NOT NULL,
	fecha_creacion date NOT NULL,
	PRIMARY KEY (id)
); ALTER TABLE funciones CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;

DROP TABLE IF EXISTS documento_tipo;
CREATE TABLE documento_tipo (
	id INT AUTO_INCREMENT,
	nombre VARCHAR(250) NOT NULL,
	PRIMARY KEY (id)
); ALTER TABLE documento_tipo CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;

INSERT INTO documento_tipo (nombre) VALUES 
('Cedula de Ciudadania'),
('Cedula de Extranjeria'),
('Pasaporte'),
('PEP');

DROP TABLE IF EXISTS usuarios;
CREATE TABLE usuarios (
	id INT AUTO_INCREMENT,
	nombre1 VARCHAR(250) NOT NULL,
	nombre2 VARCHAR(250) NOT NULL,
	apellido1 VARCHAR(250) NOT NULL,
	apellido2 VARCHAR(250) NOT NULL,
	documento_tipo INT NOT NULL,
	documento_numero VARCHAR(250) NOT NULL,
	correo_personal VARCHAR(250) NOT NULL,
	correo_empresa VARCHAR(250) NOT NULL,
	fecha_nacimiento date NOT NULL,
	clave VARCHAR(250) NOT NULL,
	telefono VARCHAR(250) NOT NULL,
	rol INT NOT NULL,
	estatus_modelo INT DEFAULT 0, 
	estatus_nomina INT DEFAULT 0, 
	estatus_satelite INT DEFAULT 0, 
	estatus_pasantia INT DEFAULT 0, 
	estatus_empresa INT DEFAULT 0, 
	estatus_pasantes INT DEFAULT 0, 
	genero INT NOT NULL,
	direccion VARCHAR(250) NOT NULL,
	responsable INT NOT NULL,
	id_empresa INT NOT NULL,
	id_pais INT NOT NULL,
	fecha_modificacion date NOT NULL,
	fecha_creacion date NOT NULL,
	PRIMARY KEY (id)
); ALTER TABLE usuarios CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;

INSERT INTO usuarios (nombre1,nombre2,apellido1,apellido2,documento_tipo,documento_numero,correo_personal,correo_empresa,clave,telefono,rol,estatus_modelo,estatus_nomina,estatus_satelite,estatus_pasantia,estatus_empresa,estatus_pasantes,genero,direccion,responsable,id_empresa,id_pais,fecha_modificacion,fecha_creacion) VALUES
('Juan','Jose','Maldonado','La Cruz',1,'955948708101993','juanmaldonado.co@gmail.com','programador@camaleonmg.com','e1f2e2d4f6598c43c2a45d2bd3acb7be','3016984868',1,1,1,0,1,1,1,1,'Barrio Olarte',1,1,5,'','2021-04-18');

DROP TABLE IF EXISTS roles_funciones;
CREATE TABLE roles_funciones (
	id INT AUTO_INCREMENT,
	id_roles INT NOT NULL,
	id_funciones INT NOT NULL,
	ver INT NOT NULL,
	crear INT NOT NULL,
	modificar INT NOT NULL,
	eliminar INT NOT NULL,
	responsable INT NOT NULL,
	id_empresa INT NOT NULL,
	fecha_modificacion date NOT NULL,
	fecha_creacion date NOT NULL,
	PRIMARY KEY (id)
); ALTER TABLE roles_funciones CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;

DROP TABLE IF EXISTS funciones_usuarios;
CREATE TABLE funciones_usuarios (
	id INT AUTO_INCREMENT,
	id_usuarios INT NOT NULL,
	id_modulos INT NOT NULL,
	id_usuario_rol VARCHAR(250) NOT NULL,
	crear INT NOT NULL,
	modificar INT NOT NULL,
	eliminar INT NOT NULL,
	responsable INT NOT NULL,
	id_empresa INT NOT NULL,
	fecha_modificacion date NOT NULL,
	fecha_creacion date NOT NULL,
	PRIMARY KEY (id)
); ALTER TABLE funciones_usuarios CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;

INSERT INTO funciones_usuarios (id_usuarios,id_modulos,id_usuario_rol,crear,modificar,eliminar,responsable,id_empresa,fecha_creacion) VALUES 
(1,1,'Nomina',1,1,1,1,1,'2021-08-11'),
(1,2,'Nomina',1,1,1,1,1,'2021-08-11'),
(1,3,'Nomina',1,1,1,1,1,'2021-08-11'),
(1,4,'Nomina',1,1,1,1,1,'2021-08-11'),
(1,5,'Nomina',1,1,1,1,1,'2021-08-11'),
(1,1,'Modelo',1,1,1,1,1,'2021-09-03');

DROP TABLE IF EXISTS modulos_multiple_usuarios;
CREATE TABLE modulos_multiple_usuarios (
	id INT AUTO_INCREMENT,
	id_usuarios INT NOT NULL,
	id_modulos_multiple INT NOT NULL,
	responsable INT NOT NULL,
	fecha_modificacion date NOT NULL,
	fecha_creacion date NOT NULL,
	PRIMARY KEY (id)
); ALTER TABLE modulos_multiple_usuarios CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;

INSERT INTO modulos_multiple_usuarios (id_usuarios,id_modulos_multiple,responsable,fecha_creacion) VALUES 
(1,1,1,'2021-04-19'),
(1,2,1,'2021-04-22'),
(1,3,1,'2021-04-22'),
(1,4,1,'2021-04-22'),
(1,5,1,'2021-08-05'),
(1,6,1,'2021-08-11'),
(1,7,1,'2021-08-11'),
(1,8,1,'2021-08-11'),
(1,9,1,'2021-08-11'),
(1,10,1,'2021-08-11'),
(1,11,1,'2021-08-11'),
(1,12,1,'2021-08-11'),
(1,13,1,'2021-08-11'),
(1,14,1,'2021-08-11'),
(1,15,1,'2021-08-11'),
(1,16,1,'2021-08-11'),
(1,17,1,'2021-08-11'),
(1,18,1,'2021-08-11'),
(1,19,1,'2021-08-11'),
(1,20,1,'2021-08-11'),
(1,21,1,'2021-08-11'),
(1,22,1,'2021-08-11'),
(1,23,1,'2021-08-11'),
(1,24,1,'2021-08-11'),
(1,25,1,'2021-08-11'),
(1,26,1,'2021-08-11'),
(1,27,1,'2021-08-11'),
(1,28,1,'2021-08-11'),
(1,29,1,'2021-08-11'),
(1,30,1,'2021-08-11'),
(1,31,1,'2021-08-11'),
(1,32,1,'2021-08-11'),
(1,33,1,'2021-08-11'),

(1,36,1,'2021-09-03');

DROP TABLE IF EXISTS usuario_conexion;
CREATE TABLE usuario_conexion (
	id INT AUTO_INCREMENT,
	id_usuarios INT NOT NULL,
	ip VARCHAR(250) NOT NULL,
	dispositivo VARCHAR(250) NOT NULL,
	token VARCHAR(250) NOT NULL,
	profile_photo_path TEXT NOT NULL,
	conexion_desde datetime NOT NULL,
	conexion_hasta datetime NOT NULL,
	conexion_cerrada datetime NOT NULL,
	estatus INT NOT NULL,
	PRIMARY KEY (id)
); ALTER TABLE usuario_conexion CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;

DROP TABLE IF EXISTS empresas;
CREATE TABLE empresas (
	id INT AUTO_INCREMENT,
	nombre VARCHAR(250) NOT NULL,
	direccion VARCHAR(250) NOT NULL,
	ciudad VARCHAR(250) NOT NULL,
	descripcion VARCHAR(250) NOT NULL,
	responsable VARCHAR(250) NOT NULL,
	cedula VARCHAR(250) NOT NULL,
	rut VARCHAR(250) NOT NULL,
	estatus INT NOT NULL,
	PRIMARY KEY (id)
); ALTER TABLE empresas CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;

INSERT INTO empresas (nombre,direccion,ciudad,descripcion,responsable,cedula,rut,estatus) VALUES 
('Camaleon Models Group','Direccion','Bogotá D.C','BERNAL GROUP  SAS','Andres Fernando Bernal Correa', '80.774.671', '901.257.204-8', 1),
('Camaleon Models Group Medellin','Carrera 81 #30A 67','Medellin','BERNAL GROUP  SAS','Andres Fernando Bernal Correa', '80.774.671', '901322261-6', 1);
	
DROP TABLE IF EXISTS sedes;
CREATE TABLE sedes (
	id INT AUTO_INCREMENT,
	nombre VARCHAR(250) NOT NULL,
	direccion VARCHAR(250) NOT NULL,
	ciudad VARCHAR(250) NOT NULL,
	cedula VARCHAR(250) NOT NULL,
	id_empresa VARCHAR(250) NOT NULL,
	fecha_creacion DATE NOT NULL,
	fecha_modificacion DATE NOT NULL,
	PRIMARY KEY (id)
); ALTER TABLE sedes CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;

INSERT INTO sedes (nombre,direccion,ciudad,cedula,id_empresa,fecha_creacion,fecha_modificacion) VALUES 
('VIP Occidente','Direccion','Bogotá D.C', '80.774.671',1,'2021-06-20','2021-06-29'),
('Norte','Direccion','Bogotá D.C', '80.774.671',1,'2021-06-20','2021-06-29'),
('Occidente I','Direccion','Bogotá D.C', '80.774.671',1,'2021-06-20','2021-06-29'),
('VIP Suba','Direccion','Bogotá D.C', '80.774.671',1,'2021-06-20','2021-06-29'),
('Medellin','Direccion','Medellin', '80.774.671',2,'2021-06-20','2021-06-29'),
('Soacha','Direccion','Bogotá D.C', '80.774.671',1,'2021-06-20','2021-06-29'),
('Belen','Carrera 81 #30A 67','Medellin', '80.774.671',2,'2021-06-20','2021-06-29'),
('Sur Americana','Calle 48 #66 70','Medellin', '80.774.671',2,'2021-06-20','2021-06-29'),
('Manrique','Carrera 36 #70 41','Medellin', '80.774.671',2,'2021-06-20','2021-06-29');

DROP TABLE IF EXISTS datos_pasantes;
CREATE TABLE datos_pasantes (
	id INT AUTO_INCREMENT,
	id_usuarios INT NOT NULL,
	sede INT NOT NULL,
	estatus INT NOT NULL,
	turno INT DEFAULT 0,
	fecha_modificacion date NOT NULL,
	fecha_creacion date NOT NULL,
	PRIMARY KEY (id)
); ALTER TABLE datos_pasantes CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;

INSERT INTO datos_pasantes (id_usuarios,sede,estatus,turno,fecha_modificacion,fecha_creacion) VALUES 
(1,1,1,1,'','2021-08-19');

DROP TABLE IF EXISTS peticiones;
CREATE TABLE peticiones (
	id INT AUTO_INCREMENT,
	id_usuarios INT NOT NULL,
	opcion INT NOT NULL,
	asunto INT NOT NULL,
	responsable INT NOT NULL,
	fecha_creacion date NOT NULL,
	PRIMARY KEY (id)
); ALTER TABLE peticiones CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;

DROP TABLE IF EXISTS datos_nominas;
CREATE TABLE datos_nominas (
	id INT AUTO_INCREMENT,
	id_usuarios INT NOT NULL,
	sede INT NOT NULL,
	estatus INT NOT NULL,
	turno INT DEFAULT 0,
	cargo INT DEFAULT 0,
	salario INT NOT NULL,
	fecha_expedicion date NOT NULL,
	fecha_ingreso date NOT NULL,
	fecha_retiro date NOT NULL,
	funcion INT NOT NULL,
	contrato INT NOT NULL,
	banco_cedula VARCHAR(250) NOT NULL,
	banco_tipo_documento INT NOT NULL,
	banco_nombre VARCHAR(250) NOT NULL,
	banco_bcpp VARCHAR(250) NOT NULL,
	banco_tipo VARCHAR(250) NOT NULL,
	banco_numero VARCHAR(250) NOT NULL,
	banco_banco VARCHAR(250) NOT NULL,
	emergencia_nombre VARCHAR(250) NOT NULL,
	emergencia_telefono VARCHAR(250) NOT NULL,
	emergencia_parentesco VARCHAR(250) NOT NULL,
	fecha_modificacion date NOT NULL,
	fecha_creacion date NOT NULL,
	PRIMARY KEY (id)
); ALTER TABLE datos_nominas CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;

INSERT INTO datos_nominas (id_usuarios,sede,estatus,fecha_creacion) VALUES 
(1,1,1,'2021-09-13');

DROP TABLE IF EXISTS modulos_sub;
CREATE TABLE modulos_sub (
	id INT AUTO_INCREMENT,
	nombre VARCHAR(250) NOT NULL,
	url VARCHAR(250) NOT NULL,
	id_modulos INT NOT NULL,
	principal INT NOT NULL,
	id_usuario_rol VARCHAR(250) NOT NULL,
	estatus INT NOT NULL,
	responsable INT NOT NULL,
	fecha_creacion date NOT NULL,
	PRIMARY KEY (id)
); ALTER TABLE modulos_sub CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
INSERT INTO modulos_sub (nombre,url,id_modulos,principal,estatus,responsable,id_usuario_rol,fecha_creacion) VALUES 
('RRHH','rrhh.php',1,1,1,1,'Nomina','2021-08-11'),
('PQR','pqr.php',1,0,1,1,'Nomina','2021-08-11'),
('SOPORTE','soporte.php',2,1,1,1,'Nomina','2021-08-11'),
('MONITOR','monitor.php',2,1,1,1,'Nomina','2021-08-11'),
('I+D','imd.php',2,1,1,1,'Nomina','2021-08-11'),
('SOPORTE TECNICO','soportetecnico.php',2,1,1,1,'Nomina','2021-08-11'),
('PQR','pqr.php',2,0,1,1,'Nomina','2021-08-11'),
('CONSULTA DESPRENDIBLES','consultasdesprendibles.php',3,0,1,1,'Nomina','2021-08-11'),
('NOMINA','nomina.php',3,0,1,1,'Nomina','2021-08-11'),
('DESCUENTOS','descuentos.php',3,1,1,1,'Nomina','2021-08-11'),
('BONOS','bonos.php',3,1,1,1,'Nomina','2021-08-11'),
('CARGAR PAGINAS','cargarpaginas.php',3,0,1,1,'Nomina','2021-08-11'),
('DESPRENDIBLES','desprendibles.php',3,1,1,1,'Nomina','2021-08-11'),
('CONVERSOR DE ARCHIVOS','conversordearchivos.php',3,0,1,1,'Nomina','2021-08-11'),
('ESTADISTICAS','estadisticas.php',3,0,1,1,'Nomina','2021-08-11'),
('FACTURAS','facturas.php',3,0,1,1,'Nomina','2021-08-11'),
('PQR','pqr.php',3,0,1,1,'Nomina','2021-08-11'),
('CALL CENTER','callcenter.php',5,0,1,1,'Nomina','2021-08-11'),
('SEX SHOP','callcenter.php',5,0,1,1,'Nomina','2021-08-18'),
('SPA','callcenter.php',5,0,1,1,'Nomina','2021-08-18'),
('BUFFET','callcenter.php',5,0,1,1,'Nomina','2021-08-18'),
('TECNOLOGIA','callcenter.php',5,0,1,1,'Nomina','2021-08-18'),
('VENDING MACHINE','callcenter.php',5,0,1,1,'Nomina','2021-08-18'),
('MONETIZACION','callcenter.php',5,0,1,1,'Nomina','2021-08-18'),
('INGLES ACADEMY','callcenter.php',5,0,1,1,'Nomina','2021-08-18'),
('COOPERATIVA F','callcenter.php',5,0,1,1,'Nomina','2021-08-18'),
('ESTUDIOS ALIADOS','callcenter.php',5,0,1,1,'Nomina','2021-08-18'),
('CAMTOKENS','callcenter.php',5,0,1,1,'Nomina','2021-08-18'),
('S MONITOREO','callcenter.php',5,0,1,1,'Nomina','2021-08-23'),
('S ADMINISTRATIVO','callcenter.php',5,0,1,1,'Nomina','2021-08-23'),
('COMMUNNITY','community.php',4,0,1,1,'Nomina','2021-08-11'),
('COSTUME SERVICE','costumbeservice.php',4,0,1,1,'Nomina','2021-08-11'),
('FOTOGRAFIA','fotografia.php',4,0,1,1,'Nomina','2021-08-11'),
('DISEÑO GRAFICO','disenografico.php',4,0,1,1,'Nomina','2021-08-11'),
('DISEÑO DE CONTENIDO','disenodecontenido.php',4,0,1,1,'Nomina','2021-08-11'),

('MIS DATOS','../welcome/index.php',1,1,1,1,'Modelo','2021-09-03'),

('PROGRAMACION','programacion.php',2,1,1,1,'Nomina','2021-10-06');

DROP TABLE IF EXISTS modulos_multiple;
CREATE TABLE modulos_multiple (
	id INT AUTO_INCREMENT,
	nombre VARCHAR(250) NOT NULL,
	url VARCHAR(250) NOT NULL,
	id_sub_modulos INT NOT NULL,
	estatus INT NOT NULL,
	responsable INT NOT NULL,
	fecha_creacion date NOT NULL,
	PRIMARY KEY (id)
); ALTER TABLE modulos_multiple CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
INSERT INTO modulos_multiple (nombre,url,id_sub_modulos,estatus,responsable,fecha_creacion) VALUES 
('PS SUPER','pasantes1.php',1,1,1,'2021-09-01'),
('PS ADMON','pasantes2.php',1,1,1,'2021-09-01'),
('PS VISUAL','pasantes3.php',1,1,1,'2021-09-01'),
('PS VISUAL S','pasantes4.php',1,1,1,'2021-09-01'),
('MO SUPER','modelos1.php',1,1,1,'2021-09-01'),
('MO ADMON','modelos2.php',1,1,1,'2021-09-01'),
('MO VISUAL','modelos3.php',1,1,1,'2021-09-01'),
('MO VISUAL S','modelos4.php',1,1,1,'2021-09-01'),
('NO SUPER','nomina1.php',1,1,1,'2021-09-13'),
('NO ADMON','nomina2.php',1,1,1,'2021-09-13'),
('NO VISUAL','nomina3.php',1,1,1,'2021-09-13'),
('NO VISUAL S','nomina4.php',1,1,1,'2021-09-13'),
('NOVEDADES','novedades.php',1,1,1,'2021-08-11'),
('CUENTAS','cuentas.php',3,1,1,'2021-08-11'),
('REPORTE DE RENDIMIENTO','reportederendimiento.php',3,1,1,'2021-08-11'),
('ASIGNACION DE SOPORTE','asignaciondesoporte.php',3,1,1,'2021-08-11'),
('REPORTE DE INICIO','reportedeinicio.php',4,1,1,'2021-08-11'),
('REPORTE DE CUENTAS','reportedecuentas.php',4,1,1,'2021-08-11'),
('REPORTE DE NUMEROS','reportedenumeros.php',4,1,1,'2021-08-11'),
('REPORTE DE RENDIMIENTOS','reportederendimientos.php',4,1,1,'2021-08-11'),
('CONSULTAS Y DESCARGAS','consultasydescargas.php',5,1,1,'2021-08-11'),
('INVENTARIO','inventario.php',6,1,1,'2021-08-11'),
('MANTENIMIENTO','mantenimiento.php',6,1,1,'2021-08-11'),
('BITACORA','bitacora.php',6,1,1,'2021-08-11'),
('BUFFET','buffet.php',10,1,1,'2021-08-11'),
('SPA','spa.php',10,1,1,'2021-08-11'),
('SEX SHOP','sexshop.php',10,1,1,'2021-08-11'),
('SANCION PAGINAS','sancionpaginas.php',10,1,1,'2021-08-11'),
('ODONTOLOGIA','odontologia.php',10,1,1,'2021-08-11'),
('SEGURIDAD SOCIAL','seguridadsocial.php',10,1,1,'2021-08-11'),
('ALOJAMIENTOS','alojamientos.php',10,1,1,'2021-08-11'),
('BONO CUMPLIMIENTO','bonocumplimiento.php',11,1,1,'2021-08-11'),
('AJUSTE','ajuste.php',11,1,1,'2021-08-11'),
('MODELOS','modelos.php',13,1,1,'2021-08-11'),
('NOMINA','nomina.php',13,1,1,'2021-08-11'),

('D PERSONALES','m_dpersonales.php',36,1,1,'2021-08-11'),
('D CORPORALES','m_dcorporales.php',36,1,1,'2021-08-11'),
('D DOCUMENTOS','m_ddocumentos.php',36,1,1,'2021-08-11'),
('D FOTOS','m_dfotos.php',36,1,1,'2021-08-11'),
('D EMPRESA','m_dempresa.php',36,1,1,'2021-08-11'),
('D BANCARIOS','m_dbancarios.php',36,1,1,'2021-08-11'),
('CUENTAS','m_cuentas.php',36,1,1,'2021-08-11'),

('MODULOS','modulos.php',37,1,1,'2021-10-06');

DROP TABLE IF EXISTS modulos_sub_usuarios;
CREATE TABLE modulos_sub_usuarios (
	id INT AUTO_INCREMENT,
	id_modulos_sub INT NOT NULL,
	id_usuarios INT NOT NULL,
	estatus INT NOT NULL,
	responsable INT NOT NULL,
	fecha_creacion date NOT NULL,
	PRIMARY KEY (id)
); ALTER TABLE modulos_sub_usuarios CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
INSERT INTO modulos_sub_usuarios (id_modulos_sub,id_usuarios,estatus,responsable,fecha_creacion) VALUES 
(1,1,1,1,'2021-04-22'),
(2,1,1,1,'2021-04-22'),
(3,1,1,1,'2021-04-22'),
(4,1,1,1,'2021-08-06'),
(5,1,1,1,'2021-08-06'),
(6,1,1,1,'2021-08-04'),
(7,1,1,1,'2021-08-06'),
(8,1,1,1,'2021-08-09'),
(9,1,1,1,'2021-08-09'),
(10,1,1,1,'2021-08-09'),
(11,1,1,1,'2021-08-09'),
(12,1,1,1,'2021-08-09'),
(13,1,1,1,'2021-08-09'),
(14,1,1,1,'2021-08-09'),
(15,1,1,1,'2021-08-09'),
(16,1,1,1,'2021-08-09'),
(17,1,1,1,'2021-08-09'),
(18,1,1,1,'2021-08-09'),
(19,1,1,1,'2021-08-09'),
(20,1,1,1,'2021-08-09'),
(21,1,1,1,'2021-08-09'),
(22,1,1,1,'2021-08-09'),
(23,1,1,1,'2021-08-09'),
(24,1,1,1,'2021-08-09'),
(25,1,1,1,'2021-08-09'),
(26,1,1,1,'2021-08-09'),
(27,1,1,1,'2021-08-09'),
(28,1,1,1,'2021-08-09'),
(29,1,1,1,'2021-08-09'),
(30,1,1,1,'2021-08-09'),
(31,1,1,1,'2021-08-09'),
(32,1,1,1,'2021-08-09'),
(33,1,1,1,'2021-08-09'),
(34,1,1,1,'2021-08-09'),
(35,1,1,1,'2021-08-09'),

(36,1,1,1,'2021-09-03'),

(37,1,1,1,'2021-10-09');

DROP TABLE IF EXISTS datos_modelos;
CREATE TABLE datos_modelos (
	id INT AUTO_INCREMENT,
	id_usuarios INT NOT NULL,
	banco_cedula VARCHAR(250) NOT NULL,
	banco_nombre VARCHAR(250) NOT NULL,
	banco_tipo VARCHAR(250) NOT NULL,
	banco_numero VARCHAR(250) NOT NULL,
	banco_banco VARCHAR(250) NOT NULL,
	banco_bcpp VARCHAR(250) NOT NULL,
	banco_tipo_documento INT NOT NULL,
	altura VARCHAR(250) NOT NULL,
	peso VARCHAR(250) NOT NULL,
	tpene VARCHAR(250) NOT NULL,
	tsosten VARCHAR(250) NOT NULL,
	tbusto VARCHAR(250) NOT NULL,
	tcintura VARCHAR(250) NOT NULL,
	tcaderas VARCHAR(250) NOT NULL,
	tipo_cuerpo VARCHAR(250) NOT NULL,
	pvello VARCHAR(250) NOT NULL,
	color_cabello VARCHAR(250) NOT NULL,
	color_ojos VARCHAR(250) NOT NULL,
	ptattu VARCHAR(250) NOT NULL,
	ppiercing VARCHAR(250) NOT NULL,
	emergencia_nombre VARCHAR(250) NOT NULL,
	emergencia_telefono VARCHAR(250) NOT NULL,
	emergencia_parentesco VARCHAR(250) NOT NULL,
	turno INT DEFAULT 0,
	estatus INT NOT NULL,
	sede INT NOT NULL,
	fecha_modificacion date NOT NULL,
	fecha_creacion date NOT NULL,
	PRIMARY KEY (id)
); ALTER TABLE datos_modelos CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
INSERT INTO datos_modelos (id_usuarios,banco_cedula,banco_nombre,banco_tipo,banco_numero,banco_banco,banco_bcpp,banco_tipo_documento,altura,peso,tpene,tsosten,tbusto,tcintura,tcaderas,tipo_cuerpo,pvello,color_cabello,color_ojos,ptattu,ppiercing,turno,estatus,sede,fecha_creacion) VALUES 
(1,"955948708101993","Juan Jose Maldonado la Cruz","Ahorro","545454545454","Bancolombia","propia",1,"1.76","75","25","","","","","Delgado","afeitado","negro","negro","No","No",1,1,1,"2021-04-22");

DROP TABLE IF EXISTS genero;
CREATE TABLE genero (
	id INT AUTO_INCREMENT,
	nombre VARCHAR(250) NOT NULL,
	id_empresa INT NOT NULL,
	fecha_modificacion DATE NOT NULL,
	fecha_creacion DATE NOT NULL,
	PRIMARY KEY (id)
); ALTER TABLE genero CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
INSERT INTO genero (nombre,id_empresa,fecha_creacion) VALUES 
('Hombre',1,'2021-07-28'),
('Mujer',1,'2021-07-28'),
('Transexual',1,'2021-07-28');

DROP TABLE IF EXISTS enterado;
CREATE TABLE enterado (
	id INT AUTO_INCREMENT,
	nombre VARCHAR(250) NOT NULL,
	PRIMARY KEY (id)
); ALTER TABLE enterado CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
INSERT INTO enterado (nombre) VALUES 
('Facebook'),
('Twitter'),
('Instagram'),
('Pagina Web'),
('Conocido');

DROP TABLE IF EXISTS datos_pasantias;
CREATE TABLE datos_pasantias (
	id INT AUTO_INCREMENT,
	id_usuarios INT NOT NULL,
	sede INT NOT NULL,
	fecha_creacion date NOT NULL,
	hora_creacion time NOT NULL,
	PRIMARY KEY (id)
); ALTER TABLE datos_pasantias CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
INSERT INTO datos_pasantias (id_usuarios,sede,fecha_creacion,hora_creacion) VALUES 
(1,1,"2021-04-22","14:10:25");

DROP TABLE IF EXISTS apiwhatsapp;
CREATE TABLE apiwhatsapp (
	id INT AUTO_INCREMENT,
	token VARCHAR(250) NOT NULL,
	url VARCHAR(250) NOT NULL,
	fecha_creacion date NOT NULL,
	hora_creacion time NOT NULL,
	PRIMARY KEY (id)
); ALTER TABLE apiwhatsapp CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
INSERT INTO apiwhatsapp (token,url,fecha_creacion,hora_creacion) VALUES 
('hyg1a0vao95bq3ij',"instance261035","2021-06-30","03:39:25");

DROP TABLE IF EXISTS paises;
CREATE TABLE paises (
	id INT AUTO_INCREMENT,
	nombre VARCHAR(250) NOT NULL,
	codigo VARCHAR(250) NOT NULL,
	PRIMARY KEY (id)
); ALTER TABLE paises CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;

INSERT INTO paises (codigo,nombre) VALUES 
('54','Argentina'),
('591','Bolivia'),
('55','Brasil'),
('56','Chile'),
('57','Colombia'),
('506','Costa Rica'),
('53','Cuba'),
('593','Ecuador'),
('503','El Salvador'),
('594','Guayana Francesa'),
('1_granada','Granada'),
('502','Guatemala'),
('592','Guayana'),
('509','Haití'),
('504','Honduras'),
('1_jamaica','Jamaica'),
('52','México'),
('505','Nicaragua'),
('595','Paraguay'),
('507','Panamá'),
('51','Perú'),
('1_puerto_rico','Puerto Rico'),
('1_republica_dominicana','República Dominicana'),
('597','Surinam'),
('598','Uruguay'),
('58','Venezuela');

DROP TABLE IF EXISTS modulos_empresas;
CREATE TABLE modulos_empresas (
	id INT AUTO_INCREMENT,
	id_empresas INT NOT NULL,
	id_modulos INT NOT NULL,
	estatus INT NOT NULL,
	fecha_modificacion date NOT NULL,
	fecha_creacion date NOT NULL,
	PRIMARY KEY (id)
); ALTER TABLE modulos_empresas CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
INSERT INTO modulos_empresas (id_modulos,id_empresas,estatus,fecha_creacion) VALUES 
(1,1,1,"2021-08-11"),
(2,1,1,"2021-08-11"),
(3,1,1,"2021-08-11"),
(4,1,1,"2021-08-11"),
(5,1,1,"2021-08-11");

DROP TABLE IF EXISTS turnos;
CREATE TABLE turnos (
	id INT AUTO_INCREMENT,
	nombre VARCHAR(250) NOT NULL,
	responsable INT NOT NULL,
	fecha_modificacion date NOT NULL,
	fecha_creacion date NOT NULL,
	PRIMARY KEY (id)
); ALTER TABLE turnos CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;

INSERT INTO turnos (nombre,fecha_creacion) VALUES 
('Mañana','2021-07-30'),
('Tarde','2021-07-30'),
('Noche','2021-07-30');

DROP TABLE IF EXISTS modelos_solicitar;
CREATE TABLE modelos_solicitar (
	id INT AUTO_INCREMENT,
	nombre VARCHAR(250) NOT NULL,
	id_empresas INT NOT NULL,
	fecha_creacion date NOT NULL,
	PRIMARY KEY (id)
); ALTER TABLE modelos_solicitar CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;

INSERT INTO modelos_solicitar (nombre,id_empresas,fecha_creacion) VALUES 
('Nombre',1,'2021-08-04'),
('Género',1,'2021-08-04'),
('Correo',1,'2021-08-04'),
('Teléfono',1,'2021-08-04'),
('Estatus',1,'2021-08-04'),
('Sede',1,'2021-08-04'),
('Número Documento',1,'2021-08-04'),
('Tipo Documento',1,'2021-08-04');

DROP TABLE IF EXISTS solicitudes;
CREATE TABLE solicitudes (
	id INT AUTO_INCREMENT,
	texto TEXT NOT NULL,
	id_modulos INT NOT NULL,
	id_cambiar INT NOT NULL,
	id_sedes INT NOT NULL,
	id_usuarios INT NOT NULL,
	id_empresas INT NOT NULL,
	responsable INT NOT NULL,
	estatus INT NOT NULL,
	id_usuarios_contestado INT NOT NULL,
	fecha_contestado date NOT NULL,
	fecha_creacion date NOT NULL,
	PRIMARY KEY (id)
); ALTER TABLE solicitudes CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;

DROP TABLE IF EXISTS usuarios_documentos;
CREATE TABLE usuarios_documentos (
	id INT AUTO_INCREMENT,
	id_documentos INT NOT NULL,
	id_usuarios INT NOT NULL,
	tipo VARCHAR(250) NOT NULL,
	responsable INT NOT NULL,
	fecha_creacion date NOT NULL,
	PRIMARY KEY (id)
); ALTER TABLE usuarios_documentos CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;

DROP TABLE IF EXISTS documentos;
CREATE TABLE documentos (
	id INT AUTO_INCREMENT,
	nombre VARCHAR(250) NOT NULL,
	ruta VARCHAR(250) NOT NULL,
	fecha_creacion date NOT NULL,
	PRIMARY KEY (id)
); ALTER TABLE documentos CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;

INSERT INTO documentos (nombre,ruta,fecha_creacion) VALUES 
('Firma de Contrato','firma_digital','2020-09-15'),
('Documento de Identidad','documento_de_identidad','2020-09-28'),
('Pasaporte','pasaporte','2020-09-28'),
('RUT','rut','2020-09-28'),
('Certificación Bancaria','certificacion_bancaria','2020-09-28'),
('EPS','eps','2020-09-28'),
('Antecedentes Disciplinarios','antecedentes_disciplinarios','2020-09-28'),
('Foto Cédula con Cara','foto_cedula_con_cara','2020-09-28'),
('Foto Cédula Parte Frontal Cara','foto_cedula_parte_frontal_cara','2020-09-28'),
('Foto Cédula Parte Respaldo','foto_cedula_parte_respaldo','2020-09-28'),
('Antecedentes Penales','antecedentes_penales','2020-09-28'),
('Extras','extras_','2020-10-02'),
('Sensuales','sensuales_','2020-10-06'),
('Permiso Bancario','acta_cuenta_prestada','2021-04-15'),

('Firma Nomina','firma_nomina','2021-04-15'),
('Hoja de Vida','hoja_de_vida','2021-04-15'),
('Certificación Bancaria Nomina','acta_cuenta_prestada','2021-04-15'),
('Planilla Seguridad Social','planilla_seguridad_social','2021-04-15');

DROP TABLE IF EXISTS modelos_cuentas;
CREATE TABLE modelos_cuentas (
	id INT AUTO_INCREMENT,
	id_usuarios INT NOT NULL,
	id_paginas INT NOT NULL,
	usuario VARCHAR(250) NOT NULL,
	clave VARCHAR(250) NOT NULL,
	correo VARCHAR(250) NOT NULL,
	link VARCHAR(250) NOT NULL,
	nickname_xlove VARCHAR(250) NOT NULL,
	usuario_bonga VARCHAR(250) NOT NULL,
	estatus VARCHAR(250) NOT NULL,
	responsable INT NOT NULL,
	fecha_modificacion date NOT NULL,
	fecha_creacion date NOT NULL,
	PRIMARY KEY (id)
); ALTER TABLE modelos_cuentas CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;


DROP TABLE IF EXISTS paginas;
CREATE TABLE paginas (
	id INT AUTO_INCREMENT,
	nombre VARCHAR(250) NOT NULL,
	tasa FLOAT (11,2) NOT NULL,
	url VARCHAR(250) NOT NULL,
	moneda VARCHAR(250) NOT NULL,
	PRIMARY KEY (id)
); ALTER TABLE paginas CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;

INSERT INTO paginas (nombre,tasa,url,moneda) VALUES 
('Chaturbate', 0.05, 'https://chaturbate.com/','Dolar'),
('Myfreecams', 0.05, 'https://www.myfreecams.com/','Dolar'),
('Camsoda', 0.05, 'https://www.camsoda.com/','Dolar'),
('BongaCams', 0.02, 'https://es.bongacams.com/','Dolar'),
('Stripchat', 0.05, 'https://stripchat.com/trans','Dolar'),
('Cam4', 0.1, 'https://www.cam4.com/','Dolar'),
('Streamatemodels', 1, 'https://www.streamatemodels.com/','Dolar'),
('Flirt4free', 0.02, 'https://www.flirt4free.com/','Dolar'),
('Livejasmin', 1, 'https://www.livejasmin.com/','Dolar'),
('Imlive', 1, 'https://imlive.com/','Dolar'),
('Xlovecam', 1.18, 'https://www.xlovecam.com/','Dolar');