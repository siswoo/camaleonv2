DROP DATABASE IF EXISTS demo_huella;
CREATE DATABASE demo_huella;
CREATE TABLE usuarios(
	id INT AUTO_INCREMENT,
	documento VARCHAR(250) NOT NULL,
	nombre_completo VARCHAR(250) NOT NULL,
	telefono VARCHAR(250) NOT NULL,
	fecha_creacion DATE NOT NULL,
	pc_serial VARCHAR(250) NOT NULL,
	PRIMARY KEY (id)
);

CREATE TABLE huellas(
	id INT AUTO_INCREMENT,
	documento VARCHAR(250) NOT NULL,
	nombre_dedo VARCHAR(250) NOT NULL,
	huella TEXT NOT NULL,
	imgHuella TEXT NOT NULL,
	PRIMARY KEY (id)
);

CREATE TABLE huellas_temporal(
	id INT AUTO_INCREMENT,
	fecha_creacion DATE NOT NULL,
	pc_serial VARCHAR(250) NOT NULL,
	huella TEXT NOT NULL,
	imgHuella TEXT NOT NULL,
	fecha_actualizacion DATE NOT NULL,
	texto VARCHAR(250) NOT NULL,
	status_plantilla VARCHAR(250) NOT NULL,
	documento VARCHAR(250) NOT NULL,
	nombre VARCHAR(250) NOT NULL,
	dedo VARCHAR(250) NOT NULL,
	opc VARCHAR(250) NOT NULL,
	PRIMARY KEY (id)
);