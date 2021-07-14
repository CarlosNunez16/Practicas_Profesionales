CREATE DATABASE Sistema_Horarios;

USE Sistema_Horarios;

DROP TABLE IF EXISTS hr_ubicacion;

CREATE TABLE hr_ubicacion (
id_ubicacion INT NOT NULL AUTO_INCREMENT,
ubicacion VARCHAR(200) NOT NULL,
estado INT(1) DEFAULT '1' COMMENT '1=activo 0=inactivo',
PRIMARY KEY (id_ubicacion)
);


DROP TABLE IF EXISTS aula;

CREATE TABLE aula (
id_aula INT NOT NULL AUTO_INCREMENT,
aula VARCHAR(25) NOT NULL,
tipo_aula VARCHAR(30) NOT NULL,
descripcion VARCHAR(30) NOT NULL,
idUbicacion_FK INT NOT NULL,
capacidad_horas INT(2) DEFAULT '12',
estado INT(1) DEFAULT '1',
capacidad_sillas INT(2) DEFAULT '20',
PRIMARY KEY (id_aula),
FOREIGN KEY (idUbicacion_FK) REFERENCES hr_ubicacion (id_ubicacion)
);

DROP TABLE IF EXISTS departamento;

CREATE TABLE departamento (
id_departamento INT NOT NULL AUTO_INCREMENT,
departamento VARCHAR(200) NOT NULL,
PRIMARY KEY (id_departamento)
);


DROP TABLE IF EXISTS carrera;

CREATE TABLE carrera (
id_carrera INT NOT NULL AUTO_INCREMENT,
carrera VARCHAR(200) NOT NULL,
idDepartamento_FK INT NOT NULL,
abrev VARCHAR(60) NOT NULL,
estado_carrera VARCHAR(10) NOT NULL DEFAULT 'A',
PRIMARY KEY (id_carrera),
FOREIGN KEY (idDepartamento_FK) REFERENCES departamento (id_departamento)
);

DROP TABLE IF EXISTS docente;

CREATE TABLE docente (
id_docente INT NOT NULL AUTO_INCREMENT,
carnet VARCHAR(20) NOT NULL,
nombres_us VARCHAR(30) NOT NULL DEFAULT '',
apellidos_us VARCHAR(30) NOT NULL DEFAULT '',
tipo VARCHAR(30) NOT NULL,
tel_casa VARCHAR(9) NOT NULL,
celular VARCHAR(9) NOT NULL,
email VARCHAR(100) NOT NULL,
estado VARCHAR(20) NOT NULL,
clave VARCHAR(50) NOT NULL,
idDepartamento_FK2 INT NOT NULL,
contrato VARCHAR(4) NOT NULL,
fechai DATE NOT NULL,
fechaf DATE NOT NULL,
nhoras INT(4) NOT NULL,
hpagadas INT(4) NOT NULL,
permanente INT(1) DEFAULT '0',
acceso_sistema INT(4) DEFAULT '0',
es_administrador INT(1) DEFAULT '0' COMMENT '1=si 0=no 3=soporte 4=practicaProf 5=administrativo',
es_asesor INT(1) DEFAULT '1' COMMENT '1=si  0=no',
es_jurado INT(1) DEFAULT '1' COMMENT '1=si  0=no',
si_publica INT(1) DEFAULT '0' COMMENT '1=puede publicas 0=no puede',
PRIMARY KEY (id_docente),
FOREIGN KEY (idDepartamento_FK2) REFERENCES departamento (id_departamento)
);

DROP TABLE IF EXISTS grupo;

CREATE TABLE grupo (
id_grupo INT NOT NULL AUTO_INCREMENT,
grupo VARCHAR(20) NOT NULL,
tipo VARCHAR(50) NOT NULL,
idCarrera_FK INT NOT NULL,
YEAR INT(4) NOT NULL,
ciclo VARCHAR(6) NOT NULL,
estado VARCHAR(15) DEFAULT 'Habilitado',
PRIMARY KEY (id_grupo),
FOREIGN KEY (idCarrera_FK) REFERENCES carrera (id_carrera)
);

DROP TABLE IF EXISTS materia;

CREATE TABLE materia (
id_materia INT NOT NULL AUTO_INCREMENT,
materia VARCHAR(200) NOT NULL,
idDepartamento_FK3 INT NOT NULL,
curricula VARCHAR(4) NOT NULL,
idCarrera_FK2 INT NOT NULL,
ciclo VARCHAR(6) NOT NULL,
uv VARCHAR(2) NOT NULL,
ciclo_materia VARCHAR(6) NOT NULL,
codigo_materia VARCHAR(15) NOT NULL,
horas_teoricas INT(4) NOT NULL,
horas_practicas INT(4) NOT NULL,
correlativo INT(4) NOT NULL,
ciclo_numero INT(2) NOT NULL,
estado INT(1) DEFAULT '1' COMMENT 'estado=1 materia activada',
materia_basica INT(1) DEFAULT '1' COMMENT '1=si_es_basica  0=no_es_basica',
PRIMARY KEY (id_materia), 
FOREIGN KEY (idDepartamento_FK3) REFERENCES departamento (id_departamento),
FOREIGN KEY (idCarrera_FK2) REFERENCES carrera (id_carrera)
);

DROP TABLE IF EXISTS detalle;

CREATE TABLE detalle (
id_detalle INT NOT NULL AUTO_INCREMENT,
idDocente_FK INT NOT NULL,
idGrupo_FK INT NOT NULL,
idMateria_FK INT NOT NULL,
idAula_FK INT NOT NULL,
ha TIME NOT NULL,
hf TIME NOT NULL,
ciclo VARCHAR(4) NOT NULL COMMENT 'I',
YEAR INT(4) NOT NULL,
dia VARCHAR(25) NOT NULL,
tipo VARCHAR(4) NOT NULL,
horas INT(2) NOT NULL,
`version` VARCHAR(2) NOT NULL,
fecha_ini DATE NOT NULL,
fecha_fin DATE NOT NULL,
comentario_reserva BLOB,
carnet_usuario VARCHAR(20) NOT NULL,
PRIMARY KEY (id_detalle),
FOREIGN KEY (idDocente_FK) REFERENCES docente (id_docente),
FOREIGN KEY (idGrupo_FK) REFERENCES grupo (id_grupo),
FOREIGN KEY (idMateria_FK) REFERENCES materia (id_materia),
FOREIGN KEY (idAula_FK) REFERENCES aula (id_aula)
); 

DROP TABLE IF EXISTS grupo_docente;

CREATE TABLE grupo_docente (
id_grupo_docente INT NOT NULL AUTO_INCREMENT,
idDocente_FK2 INT NOT NULL,
idGrupo_FK2 INT NOT NULL,
YEAR INT(4) NOT NULL,
ciclo VARCHAR(4) NOT NULL,
estado VARCHAR(4) DEFAULT 'H' COMMENT 'para hacer visible el modulo ante el alumno',
idMateria_FK2 INT NOT NULL,
bloqueado INT(1) DEFAULT '0' COMMENT 'sirve para cuando se le pone clave al grupo',
claveinst VARCHAR(250) NOT NULL,
nombredirectorio VARCHAR(250) NOT NULL,
sizedir INT(10) DEFAULT '50',
cerrado INT(1) DEFAULT '0',
permisomod INT(1) DEFAULT '0',
PRIMARY KEY (id_grupo_docente),
FOREIGN KEY (idDocente_FK2) REFERENCES docente (id_docente),
FOREIGN KEY (idGrupo_FK2) REFERENCES grupo (id_grupo),
FOREIGN KEY (idMateria_FK2) REFERENCES materia (id_materia)
); 

DROP TABLE IF EXISTS grupo_docente_alumno;

CREATE TABLE grupo_docente_alumno (
id_grupo_docente_alumno INT NOT NULL AUTO_INCREMENT,
idGrupo_docente_FK INT NOT NULL,
carnet VARCHAR(6) NOT NULL,
YEAR INT(4) NOT NULL,
estado VARCHAR(2) DEFAULT 'H',
asistencia INT(4) DEFAULT '0',
horas INT(4) NOT NULL,
PRIMARY KEY (id_grupo_docente_alumno),
FOREIGN KEY (idGrupo_docente_FK) REFERENCES grupo_docente (id_grupo_docente)
);

DROP TABLE IF EXISTS horario;

CREATE TABLE horario (
id_horario INT NOT NULL AUTO_INCREMENT,
ha TIME NOT NULL,
hf TIME NOT NULL,
PRIMARY KEY (id_horario)
);

DROP TABLE IF EXISTS horas;

CREATE TABLE horas (
id_horas INT NOT NULL AUTO_INCREMENT,
idHorario_FK INT NOT NULL,
ha TIME NOT NULL,
hf TIME NOT NULL,
PRIMARY KEY (id_horas),
FOREIGN KEY (idHorario_FK) REFERENCES horario (id_horario)
);

DROP TABLE IF EXISTS hr_corte;

CREATE TABLE hr_corte (
id_corte INT NOT NULL AUTO_INCREMENT,
fecha_inicio DATE NOT NULL,
fecha_fin DATE NOT NULL,
YEAR INT(4) NOT NULL,
`version` VARCHAR(2) NOT NULL,
estado INT NOT NULL,
PRIMARY KEY (id_corte)
); 

DROP TABLE IF EXISTS hr_curricula;

CREATE TABLE hr_curricula (
id_curricula INT NOT NULL AUTO_INCREMENT,
idCarrera_FK3 INT NOT NULL,
estado VARCHAR(15) DEFAULT 'A',
curricula VARCHAR(15) NOT NULL,
PRIMARY KEY (id_curricula),
FOREIGN KEY (idCarrera_FK3) REFERENCES carrera (id_carrera)
); 

DROP TABLE IF EXISTS hr_horario_disponible;

CREATE TABLE hr_horario_disponible (
id_horario_disp INT NOT NULL AUTO_INCREMENT,
dia VARCHAR(20) NOT NULL COMMENT 'dia correspondiente a la fecha',
hora_disponible VARCHAR(50) NOT NULL,
hora_inicio TIME NOT NULL,
hora_fin TIME NOT NULL,
idCorte_FK INT NOT NULL,
total_horas INT NOT NULL,
estado_horario VARCHAR(50) NOT NULL COMMENT 'habilitado, deshabilitado',
fecha DATE NOT NULL COMMENT 'fecha disponible yyy-mm-dd',
asignaciones INT(11) NOT NULL COMMENT 'aun maximo se 5',
tipo_horario VARCHAR(20) NOT NULL COMMENT 'tutor, consultor',
idDocente_FK3 INT NOT NULL COMMENT 'para saber aque sede pertence el horario',
eliminado BIT(1) NOT NULL COMMENT '1=si, 0=no',
PRIMARY KEY (id_horario_disp),
FOREIGN KEY (idCorte_FK) REFERENCES hr_corte (id_corte),
FOREIGN KEY (idDocente_FK3) REFERENCES docente (id_docente)
); 

DROP TABLE IF EXISTS modulos_itca;

CREATE TABLE modulos_itca (
id_modulo INT NOT NULL AUTO_INCREMENT,
nombre_modulo VARCHAR(200) NOT NULL,
PRIMARY KEY (id_modulo)
); 

DROP TABLE IF EXISTS modulo_docentes;

CREATE TABLE modulo_docentes (
id_modulo_docentes INT NOT NULL AUTO_INCREMENT,
idDocente_FK4 INT NOT NULL,
idModulo_FK INT NOT NULL,
nivel VARCHAR(30) NOT NULL,
carnet_doc VARCHAR(8) NOT NULL,
estado INT(1) DEFAULT '1',
PRIMARY KEY (id_modulo_docentes),
FOREIGN KEY (idDocente_FK4) REFERENCES docente (id_docente),
FOREIGN KEY (idModulo_FK) REFERENCES modulos_itca (id_modulo)
); 

DROP TABLE IF EXISTS alumnos;

CREATE TABLE alumnos (
carnet VARCHAR(6) NOT NULL,
nombre VARCHAR(100) NOT NULL,
idCarrera_FK4 INT NOT NULL DEFAULT '7',
PRIMARY KEY (carnet),
FOREIGN KEY (idCarrera_FK4) REFERENCES carrera (id_carrera)
); 

DROP TABLE IF EXISTS nt_inasistencias_alumno;

CREATE TABLE nt_inasistencias_alumno (
id_inasistencias_alumno INT NOT NULL AUTO_INCREMENT,
fecha_inasistencia DATE NOT NULL,
horas INT(4) NOT NULL,
carnet_alumno VARCHAR(6) NOT NULL,
carnet_docente VARCHAR(20) NOT NULL,
hora_ingreso TIME NOT NULL,
fecha_ingreso DATE NOT NULL,
idGrupoDocenteAlumno_FK INT NOT NULL,
tipo VARCHAR(15) NOT NULL,
PRIMARY KEY (id_inasistencias_alumno),
FOREIGN KEY (idGrupoDocenteAlumno_FK) REFERENCES grupo_docente_alumno (id_grupo_docente_alumno)
);

DROP TABLE IF EXISTS pdoc_asuetos;

CREATE TABLE pdoc_asuetos (
id_asuetos INT NOT NULL AUTO_INCREMENT,
fecha_inicio DATE NOT NULL,
fecha_fin DATE NOT NULL,
razon VARCHAR(50) NOT NULL,
PRIMARY KEY (id_asuetos)
); 

DROP TABLE IF EXISTS pdoc_cortes;

CREATE TABLE pdoc_cortes (
id_corte INT NOT NULL AUTO_INCREMENT,
fecha_inicio DATE NOT NULL,
fecha_fin DATE NOT NULL,
PRIMARY KEY (id_corte)
); 

DROP TABLE IF EXISTS pdoc_dias;

CREATE TABLE pdoc_dias (
fecha DATE NOT NULL,
idCorte_FK INT NOT NULL,
FOREIGN KEY (idCorte_FK) REFERENCES pdoc_cortes (id_corte)
); 

DROP TABLE IF EXISTS pdoc_permisos;

CREATE TABLE pdoc_permisos (
idpermiso INT NOT NULL AUTO_INCREMENT,
fecha_inicio DATE NOT NULL,
fecha_fin DATE NOT NULL,
hora_inicio TIME NOT NULL,
hora_fin TIME NOT NULL,
razon VARCHAR(100) COLLATE utf8_unicode_ci NOT NULL,
idDocente_FK5 INT NOT NULL COMMENT 'foranea de docente',
estado VARCHAR(20) COLLATE utf8_unicode_ci NOT NULL,
PRIMARY KEY (idpermiso),
FOREIGN KEY (idDocente_FK5) REFERENCES docente (id_docente)
);

DROP TABLE IF EXISTS pdoc_phora;

CREATE TABLE pdoc_phora (
id_phora INT NOT NULL AUTO_INCREMENT,
tipo VARCHAR(10) NOT NULL,
monto FLOAT NOT NULL,
PRIMARY KEY (id_phora)
); 

DROP TABLE IF EXISTS pdoc_reprog;

CREATE TABLE pdoc_reprog (
id_reprog INT NOT NULL AUTO_INCREMENT,
fechaOrig DATE NOT NULL,
fechaReprogramada DATE NOT NULL,
hi TIME NOT NULL,
hf TIME NOT NULL,
th INT(11) NOT NULL,
idDetalle_FK INT NOT NULL,
idDocente_FK6 INT NOT NULL,
idAula_FK2 INT NOT NULL,
estado VARCHAR(25) NOT NULL,
PRIMARY KEY (id_reprog),
FOREIGN KEY (idDetalle_FK) REFERENCES detalle (id_detalle),
FOREIGN KEY (idDocente_FK6) REFERENCES docente (id_docente),
FOREIGN KEY (idAula_FK2) REFERENCES aula (id_aula)
); 






























