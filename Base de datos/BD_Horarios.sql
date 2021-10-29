CREATE DATABASE SistemaHorarios;

USE SistemaHorarios;

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

DROP TABLE IF EXISTS horas_ocupadas;

CREATE TABLE horas_ocupadas (
id_horas INT NOT NULL AUTO_INCREMENT,
idHorario_FK INT NOT NULL,
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

/*Data for the table `departamento` */
INSERT  INTO departamento (id_departamento, departamento) VALUES 
(1,'ComputaciÃ³n'),
(2,'ElÃ©ctrica'),
(3,'Ãrea bÃ¡sica'),
(4,'AdministraciÃ³n'),
(5,'Patrimonio'),
(7,'Servicio Desarrollo prof.');

/*Data for the table `carrera` */
INSERT  INTO carrera (id_carrera, carrera, idDepartamento_FK, abrev, estado_carrera) VALUES 
(2,'TÃ©cnico en Sistemas InformÃ¡ticos',1,NULL,'A'),
(3,'TÃ©cnico en IngenierÃ­a ElÃ©ctrica',2,NULL,'A'),
(4,'TÃ©cnico en Mantenimiento de Computadoras',2,NULL,'A'),
(5,'TÃ©cnico en GestiÃ³n TecnolÃ³gica del Patrimonio Cultural',5,NULL,'A'),
(6,'Cursos libres',7,NULL,'A');

/*Data for the table `materia` */
INSERT INTO materia (id_materia, materia, idDepartamento_FK3, curricula, idCarrera_FK2, ciclo, uv, ciclo_materia, codigo_materia, horas_teoricas, horas_practicas, correlativo, ciclo_numero, estado, materia_basica) VALUES 
(1,'ConfiguraciÃ³n de redes informaticas',1,'6',2,'VII','5','IV','COMP011605',30,70,16,0,1,1),
(2,'AdministraciÃ³n de Transacciones Comerciales por Medios ElectrÃ³nicos',1,'5',2,'VII','4','IV','COMP011904',20,60,19,0,1,1),
(3,'Desarrollo de Programas Multiplataforma ',1,'5',2,'VII','5','IV','COMP012005',30,70,20,0,1,1),
(5,'ConfiguraciÃ³n de Sistemas Operativos',1,'5',2,'VII','5','IV','COMP012105',30,70,21,0,1,1),
(15,'PrevenciÃ³n de Accidentes y Enfermedades Ocupacionales',1,'6',2,'VII','2','IV','COMP012102',20,20,21,0,1,0),
(7,'InglÃ©s Intermedio II',1,'5',2,'VII','3','IV','COMP012203',30,30,22,0,1,0),
(8,'ConfiguraciÃ³n y AdministraciÃ³n de Sistemas Operativos',1,'6',2,'VII','5','IV','COMP011805',30,70,18,0,1,1),
(9,'PrevenciÃ³n de Accidentes y Enfermedades Ocupacionales',1,'5',2,'VII','2','IV','COMP012302',20,20,23,0,1,0),
(10,'AdministraciÃ³n de Herramientas web',1,'6',2,'VII','4','IV','COMP011904',16,64,19,0,1,1),
(11,'Desarrollo de LÃ³gica de ProgramaciÃ³n',1,'5',2,'I','5','I','COMP010105',30,70,1,0,1,1),
(12,'DirecciÃ³n del Comportamiento Humano en el Ambiente Laboral',1,'6',2,'VII','2','IV','COMP012002',20,20,20,0,1,1),
(17,'AnÃ¡lisis y DiseÃ±o de Sistemas',1,'5',2,'I','5','I','COMP010205',30,70,2,0,1,1),
(19,'Desarrollo de Aplicaciones Usando TecnologÃ­as Emergentes',1,'6',2,'VII','5','IV','COMP011705',30,70,17,0,1,1),
(20,'InstalaciÃ³n y ConfiguraciÃ³n Software y Hardware',1,'5',2,'III','4','IV','COMP010403',20,60,3,0,1,1),
(21,'Desarrollo de LÃ³gica de ProgramaciÃ³n',1,'6',2,'I','5','I','COMP010105',30,70,1,0,1,1),
(24,'GestiÃ³n de Proyectos de Desarrollo de Software',1,'6',2,'I','4','I','COMP010204',16,64,2,0,1,0),
(23,'InglÃ©s BÃ¡sico I',1,'5',2,'I','3','I','COMP010403',30,30,4,0,1,0),
(25,'DiseÃ±o de PÃ¡ginas Web',1,'6',2,'I','4','I','COMP010304',16,64,3,0,1,1),
(26,'DiseÃ±o del Plan de Negocio',1,'5',2,'I','3','I','COMP010503',30,30,5,0,1,1),
(27,'Ingles BÃ¡sico 1',1,'6',2,'I','3','I','COMP010403',30,30,4,0,1,0),
(28,'ComunicaciÃ³n Oral y Escrita',1,'5',2,'I','2','I','COMP010602',20,20,6,0,1,0),
(29,'MatemÃ¡tica',1,'6',2,'I','4','I','COMP010604',40,40,4,0,1,0),
(30,'Desarrollo de Aplicaciones Cliente Servidor',1,'5',2,'III','5','II','COMP010705',30,70,7,0,1,1),
(31,'DiseÃ±o de PÃ¡ginas Web',1,'5',2,'III','5','II','COMP010804',20,60,8,0,1,1),
(32,'DiseÃ±o de Base de Datos',1,'5',2,'III','5','II','COMP010905',30,70,9,0,1,1),
(33,'Desarrollo de Aplicaciones de Escritorio',1,'6',2,'III','5','II','COMP010605',30,70,6,0,1,1),
(39,'Ingles BÃ¡sico ll',1,'6',2,'III','3','II','COMP020903',30,30,9,0,1,0),
(36,'Analisis y DiseÃ±o de Sistemas',1,'6',2,'III','5','II','COMP010705',30,70,7,0,1,1),
(38,'DiseÃ±o de Bases de Datos',1,'6',2,'III','5','II','COMP010805',30,70,8,0,1,1),
(40,'FormulaciÃ³n y EvaluaciÃ³n de Planes de Negocios',1,'6',2,'III','4','II','COMP011004',40,40,10,0,1,1),
(41,'InstalaciÃ³n y ConfiguraciÃ³n de Software y Hardware ',1,'6',2,'V','4','III','COMP011104',16,64,11,0,1,1),
(42,'AplicaciÃ³n de Metodologias Agiles y Testeo de Software',1,'6',2,'V','5','III','COMP011205',30,70,12,0,1,1),
(43,'Desarrollo de Aplicaciones Para La Web',1,'6',2,'V','5','III','COMP011306',30,70,13,0,1,1),
(44,'ComunicaciÃ³n Oral y Escrita',1,'6',2,'V','2','III','COMP011402',20,20,14,0,1,0),
(45,'FÃ­sica',1,'6',2,'V','3','III','COMP011503',30,30,15,0,1,0),
(46,'InglÃ©s BÃ¡sico II',1,'5',2,'III','3','II','COMP011003',30,30,10,0,1,0),
(47,'Ejecucion del Plan de Negocio',1,'5',2,'III','3','II','COMO011103',30,30,11,0,1,1),
(48,'MatemÃ¡tica',1,'5',2,'III','4','II','COMP011204',30,30,12,0,1,0),
(49,'Desarrollo de Aplicaciones para la Web',1,'5',2,'V','5','III','COMP011305',30,70,13,0,1,1),
(50,'SelecciÃ³n de TÃ©cnicas de IngenierÃ­a de Software',1,'5',2,'V','5','III','COMP011405',30,70,14,0,1,1),
(51,'DiseÃ±o de Redes InformÃ¡ticas',1,'5',2,'V','5','III','COMP011505',30,70,15,0,1,1),
(52,'InglÃ©s Intermedio I',1,'5',2,'V','3','III','COMP011603',30,30,16,0,1,0),
(53,'DirecciÃ³n del Comportamiento Humano en el Ambiente Laboral',1,'5',2,'V','2','III','COMP011702',20,20,17,0,1,0),
(54,'FÃ­sica',1,'5',2,'V','3','III','COMP011803',30,30,18,0,1,0),
(55,'Mantenimiento Preventivo en Equipos de Computo',2,'7',4,'I','4','I','ELE113',32,48,1,0,1,0),
(56,'PrevenciÃ³n de Accidentes y Enfermedades Ocupacionales',2,'7',4,'V','2','I','BAS166',40,0,2,0,1,0),
(57,'Desarrollo de Procesos AlgÃ©braicos y CÃ¡lculos de Ãreas de PÃ©rimetros y Volumenes   ',2,'7',4,'I','3','I','BAS02',60,0,3,0,1,0),
(58,'InstalaciÃ³n, ConfiguraciÃ³n y ActualizaciÃ³n  de Sistemas Operativos',2,'7',4,'I','4','I','ELE114',24,56,4,0,1,1),
(59,'InstalaciÃ³n de Cable Estructurado',2,'7',4,'I','4','I','ELE115',16,64,5,0,1,1),
(60,'MediciÃ³n de Magnitudes FÃ­sicas',2,'7',4,'I','2','I','BAS17',24,16,6,0,1,0),
(61,'Desarrollo y AnÃ¡lisis de Funciones AlgÃ©braicas y CÃ³nicas',2,'7',4,'I','3','I','BAS17',60,0,7,0,1,0),
(62,'ApropiaciÃ³n de Vocabulario en InglÃ©s para Actividades de Esparimiento',2,'7',4,'I','2','I','BAS94',16,24,8,0,1,0),
(63,'AdquisiciÃ³n de Vocabulario en InglÃ©s Relacionado a Situaciones Sociales ',2,'7',4,'I','2','I','BAS96',16,24,9,0,1,0),
(64,'InstalaciÃ³n y ConfiguraciÃ³n de Redes Punto a Punto',2,'7',4,'III','4','II','ELE116',24,56,10,0,1,1),
(65,'AdministraciÃ³n de Sistemas Operativos',2,'7',4,'III','7','II','ELE118',52,88,11,0,1,1),
(66,'ElaboraciÃ³n de Anteproyectos de InvestigaciÃ³n',2,'7',4,'III','2','II','BAS017',40,0,12,0,1,0),
(67,'Mantenimiento Correctivo y ActualizaciÃ³n de Componentes de Computadoras',2,'7',4,'III','5','II','ELE117',36,64,14,0,1,1),
(120,'ContextualizaciÃ³n histÃ³rica y geogrÃ¡fica del patrimonio cultural',5,'9',5,'I','3','I','PAT010303',60,0,3,0,1,1),
(69,'ConstrucciÃ³n de Expresiones en InglÃ©s sobre Cuestiones Laborales',2,'7',4,'III','2','II','BAS101',16,24,15,0,1,0),
(70,'ConstrucciÃ³n de Frases en InglÃ©s Sobre Temas de InterÃ©s Particular',2,'7',4,'III','2','II','BAS98',16,24,16,0,1,0),
(122,'ElaboraciÃ³n de registros de bienes culturales con aplicaciÃ³n de tecnologÃ­as',5,'9',5,'I','4','I','PAT010604',44,36,6,0,1,1),
(72,'PreparaciÃ³n de Presentaciones Orales y RedacciÃ³n de Informes Escritos',2,'7',4,'III','2','II','BAS212',20,28,18,0,1,0),
(73,'ConstrucciÃ³n de Circuitos de Control ElectrÃ³nico de Potencia',2,'8',3,'I','3','I','01',8,52,1,0,1,1),
(74,'Mantenimiento Correctivo en Monitores de Computadoras',2,'7',4,'V','4','III','ELE119',24,60,19,0,1,1),
(75,'ElaboraciÃ³n de Anteproyectos de InvestigaciÃ³n',2,'8',3,'I','2','I','02',24,16,2,0,1,1),
(76,'ElaboraciÃ³n de Planos para Sistemas Electricos',2,'8',3,'I','3','I','03',8,52,3,0,1,1),
(77,'Instalaciones Electricas Internas',2,'8',3,'I','4','I','04',16,64,4,0,1,1),
(78,'MatemÃ¡tica',2,'8',3,'I','4','I','05',32,48,5,0,1,0),
(80,'TÃ©cnicas de Taller para la ElaboraciÃ³n de Proyectos',2,'8',3,'I','2','I','06',8,32,6,0,1,1),
(81,'FormulaciÃ³n y AdministraciÃ³n de Proyectos de Sistemas Electricos',2,'8',3,'III','4','II','07',16,64,7,0,1,1),
(82,'ConfiguraciÃ³n de Dispositivos de InterconexiÃ³n en Redes de Ãrea Local Basadas En Cobre y TecnologÃ­a InalÃ¡mbrica',2,'7',4,'V','4','III','ELE121',24,56,21,0,1,1),
(83,'FormulaciÃ³n y EvaluaciÃ³n de Planes de Negocios',2,'8',3,'III','4','II','08',32,48,8,0,1,1),
(84,'Mantenimiento Correctivo en Impresoras y UPS',2,'7',4,'V','4','III','ELE122',24,56,22,0,1,1),
(85,'Mantenimiento a Instalaciones Electricas Internas',2,'8',3,'III','3','II','09',8,52,9,0,1,1),
(86,'GestiÃ³n de Redes de Datos en Ãrea Local',2,'7',4,'V','6','III','ELE123',32,88,23,0,1,1),
(87,'Mantenimiento a Motores ElÃ©ctricos',2,'8',3,'III','3','II','10',8,52,10,0,1,1),
(88,'DescripciÃ³n de Situaciones Actuales en InglÃ©s ',2,'7',4,'V','2','III','BAS104',16,24,24,0,1,0),
(89,'PresentaciÃ³n en InglÃ©s de Temas de InterÃ©s Personal',2,'7',4,'V','2','III','BAS102',16,24,25,0,1,0),
(90,'Mantenimiento ElÃ©ctronico a Plantas de Emergencia y a Sistemas de RefrigeraciÃ³n',2,'8',3,'III','2','II','11',8,32,11,0,1,1),
(91,'DirecciÃ³n del Comportamiento Humano en el Ambiente Laboral',2,'7',4,'V','2','III','BAS105',24,24,26,0,1,0),
(92,'Montaje y Mantenimiento de Sistemas de Puestas a Tierra',2,'8',3,'III','2','II','12',8,32,12,0,1,1),
(93,'ImplementaciÃ³n de Servicios en Redes de Ãrea Local',2,'7',4,'VII','6','IV','ELE124',40,80,27,0,1,1),
(94,'AnÃ¡lisis de Eficiencia EnÃ©rgetica en Edificaciones',2,'8',3,'V','3','III','13',8,52,13,0,1,1),
(95,'ImplementaciÃ³n de Estrategias de Seguridad en Redes de Ãrea Local',2,'7',4,'VII','6','IV','ELE125',32,88,28,0,1,1),
(96,'ConstrucciÃ³n y Mantenimiento de Lineas de DistrubuciÃ³n de EnergÃ­a ElÃ©ctrica',2,'8',3,'V','3','III','14',8,52,14,0,1,1),
(97,'FormulaciÃ³n de Planes de Negocio',2,'7',4,'VII','3','IV','BAS145',60,0,29,0,1,0),
(98,'Dimensionamiento, Montaje y Mantenimiento de Sistemas Fotovoltaicos',2,'8',3,'V','3','III','15',8,52,15,0,1,1),
(99,'FÃ­sica',2,'8',3,'V','3','III','16',30,30,16,0,1,1),
(100,'Ingles BÃ¡sico l',2,'8',3,'V','3','III','17',30,30,17,0,1,0),
(101,'AdministraciÃ³n de Proyectos de TecnologÃ­as de la InformaciÃ³n',2,'7',4,'VII','5','IV','ELE126',40,60,30,0,1,1),
(102,'Mantenimiento Preventivo a Sistemas Mecatronicos',2,'8',3,'V','2','III','18',8,32,18,0,1,1),
(103,'Montaje y Mantenimiento de Subestaciones de DistribuciÃ³n',2,'8',3,'V','3','III','19',8,52,19,0,1,1),
(104,'RenovaciÃ³n de Programas InformÃ¡ticos',2,'7',4,'VII','3','IV','ELE127',16,44,31,0,1,1),
(105,'Diagnostico de la Calidad de la EnÃ©rgia en Sistemas ElÃ©ctrico',2,'8',3,'VII','3','IV','20',8,52,20,0,1,1),
(106,'ElaboraciÃ³n de Planes de Negocio',2,'7',4,'VII','3','IV','BAS150',60,0,32,0,1,0),
(107,'DirecciÃ³n del Comportamiento Humano en el Ambiente Laboral',2,'8',3,'VII','2','IV','21',24,16,21,0,1,1),
(108,'ConversaciÃ³n de Temas ComÃºnes en InglÃ©s',2,'7',4,'VII','2','IV','BAS107',16,24,33,0,1,0),
(109,'DiseÃ±o de IluminaciÃ³n de Interiores e InstalaciÃ³n de Sistemas Domoticos',2,'8',3,'VII','3','IV','22',8,52,22,0,1,1),
(110,'NarraciÃ³n de Experiencias Personales en InglÃ©s',2,'7',4,'VII','2','IV','BAS109',16,24,34,0,1,0),
(111,'Ingles BÃ¡sico ll',2,'8',3,'VII','3','IV','23',30,30,23,0,1,1),
(112,'Mantenimiento de Lineas de TransmisiÃ³n de EnÃ©rgia ElÃ©ctrica',2,'8',3,'VII','3','IV','24',8,52,24,0,1,1),
(113,'Montaje de Componentes en Paneles de Control ElÃ©ctrico',2,'8',3,'VII','2','IV','25',8,32,25,0,1,1),
(114,'PrevenciÃ³n de Accidentes y Enfermedades Ocupacionales',2,'8',3,'VII','2','IV','26',24,16,26,0,1,1),
(121,'EdiciÃ³n y RepresentaciÃ³n de bienes culturales con aplicaciones tecnolÃ³gicas',5,NULL,5,'I','4','I','PAT010704',40,40,7,0,1,1),
(116,'PrevenciÃ³n de Accidentes y Enfermedades Ocupacionales',2,'7',4,'I','2','I','BAS166',40,0,2,0,1,0),
(117,'Tratamiento EstÃ¡distico de la InformaciÃ³n',2,'7',4,'III','3','II','BAS10',64,0,13,0,1,0),
(118,'DescripciÃ³n y CuantificaciÃ³n de FenÃ³menos HidrostÃ¡ticos, TÃ©rmicos y ElÃ©ctricos',2,'7',4,'III','2','II','BAS197',24,16,17,0,1,0),
(119,'Mantenimiento Correctivo a Sistemas Operativos',2,'7',4,'V','4','III','ELE120',24,56,20,0,1,1),
(123,'ElaboraciÃ³n y publicaciones de pro. culturales',5,NULL,5,'I','3','I','4000',60,0,9,0,1,0),
(124,'Emprenderurismo colaborativo',5,NULL,5,'I','4','I','PAT010205',80,0,2,0,1,1),
(125,'OrganizaciÃ³n e investigaciÃ³n del Patrimonio Cultural',5,'9',5,'I','4','I','PAT010404',80,0,4,0,1,1),
(126,'OrientaciÃ³n de estudiantes al proceso educativo de primer aÃ±o',5,'9',5,'I','1','I','PAT01010',20,0,1,0,1,1),
(127,'ConservaciÃ³n preventiva de bienes culturales',5,'9',5,'III','7','II','PAT011007',72,72,10,0,1,1),
(128,'ConversaciÃ³n en lengua nahuat',5,'9',5,'IV','4','II','PAT011104',16,64,11,0,1,1),
(129,'DiseÃ±o de estrategias de comunicaciÃ³n para la promociÃ³n y preservaciÃ³n del patrimonio cultural',5,'9',5,'VI','4','III','PAT011704',96,0,17,0,1,1),
(130,'DiseÃ±o de planes de negocio en asociatividad cooperativa',5,'9',5,'III','5','II','PAT010805',100,0,8,0,1,1),
(131,'OrientaciÃ³n de estudiantes al proceso educativo del segundo 2 aÃ±o',5,'9',5,'V','1','III','PAT011301',24,0,13,0,1,1),
(132,'OrganizaciÃ³n y elaboraciÃ³n de inventarios de bienes culturales.',5,'9',5,'III','3','II','PAT010903',0,60,9,0,1,1),
(133,'Puesta en marcha de la microempresa en asosiatividad cooperativa',5,'9',5,'V','8','III','PAT011508',160,0,15,0,1,1),
(134,'RestauraciÃ³n de bienes culturales',5,'9',5,'VI','7','III','PAT011607',144,0,16,0,1,1),
(135,'RealizaciÃ³n de diagnÃ³sticos y proyectos culturales comunitarios',5,'9',5,'IV','4','II','PAT011204',40,40,12,0,1,1),
(136,'ElaboraciÃ³n y publicaciÃ³n de productos culturales',5,'9',5,'II','8','I','PAT010503',30,30,5,0,1,1),
(137,'Desarrollo de lenguaje tÃ©cnico del patrimonio cultural en idioma inglÃ©s',5,'9',5,'V','6','III','PAT011406',120,0,14,0,1,1),
(138,'CreaciÃ³n de empresas culturales de beneficio social',5,'9',5,'VIII','7','IV','PAT012107',144,0,21,0,1,1),
(139,'Desarrollo de estrategias de mercadeo aplicadas al patrimonio cultural',5,'9',5,'VII','6','IV','PAT011806',120,0,18,0,1,1),
(140,'AdministraciÃ³n  de espacios culturales',5,'9',5,'VIII','8','IV','PAT012006',120,0,20,0,1,1),
(141,'ProducciÃ³n de Eventos Culturales',5,'9',5,'VII','7','IV','PAT011907',144,0,19,0,1,1),
(142,'Ingles Basico Entre Semana',7,'1000',6,'I','0','I','IB',20,0,0,0,1,0),
(143,'Ingles Intermedio Entre Semana',7,'10',6,'I','0','I','II',20,0,0,0,1,0),
(144,'Ingles Avanzado Entre Semana',7,'10',6,'I','0','I','IA',20,0,0,0,1,0),
(145,'Ingles Talk Entre Semana',7,'1000',6,'I','0','I','IT',20,0,0,0,1,1);


/*Data for the table `grupo` */
INSERT  INTO grupo(id_grupo,grupo,tipo,idCarrera_FK,`year`,ciclo,estado) VALUES 
(1,'MAN11','U',4,2018,'I','Habilitado'),
(2,'MAN11','A',4,2018,'I','Habilitado'),
(3,'MAN11','B',4,2018,'I','Habilitado'),
(4,'MAN31','U',4,2018,'III','Habilitado'),
(5,'MAN31','A',4,2018,'III','Habilitado'),
(6,'MAN31','B',4,2018,'III','Habilitado'),
(7,'ELEC11','U',3,2018,'I','Habilitado'),
(8,'ELEC11','A',3,2018,'I','Habilitado'),
(9,'ELEC11','B',3,2018,'I','Habilitado'),
(10,'ELEC12','U',3,2018,'I','Habilitado'),
(11,'ELEC12','A',3,2018,'I','Habilitado'),
(12,'ELEC12','B',3,2018,'I','Habilitado'),
(13,'ELEC13','U',3,2018,'I','Habilitado'),
(14,'ELEC13','A',3,2018,'I','Habilitado'),
(15,'ELEC31','U',3,2018,'III','Habilitado'),
(16,'ELEC31','A',3,2018,'III','Habilitado'),
(17,'ELEC31','B',3,2018,'III','Habilitado'),
(18,'ELEC32','U',3,2018,'III','Habilitado'),
(19,'ELEC32','A',3,2018,'III','Habilitado'),
(20,'ELEC32','B',3,2018,'III','Habilitado'),
(21,'ELEC23','U',3,2018,'I','Habilitado'),
(22,'ELEC23','A',3,2018,'I','Habilitado'),
(23,'ELEC43','U',3,2018,'I','Habilitado'),
(24,'ELEC43','A',3,2018,'I','Habilitado'),
(25,'SIS11','U',2,2018,'I','Habilitado'),
(26,'SIS11','A',2,2018,'I','Habilitado'),
(27,'SIS11','B',2,2018,'I','Habilitado'),
(28,'SIS12','U',2,2018,'I','Habilitado'),
(29,'SIS12','A',2,2018,'I','Habilitado'),
(30,'SIS12','B',2,2018,'I','Habilitado'),
(31,'SIS13','U',2,2018,'I','Habilitado'),
(32,'SIS13','A',2,2018,'I','Habilitado'),
(33,'SIS13','B',2,2018,'I','Habilitado'),
(34,'SIS31','U',2,2018,'III','Habilitado'),
(35,'SIS31','A',2,2018,'III','Habilitado'),
(36,'SIS31','B',2,2018,'III','Habilitado'),
(37,'SIS32','U',2,2018,'III','Habilitado'),
(38,'SIS32','A',2,2018,'III','Habilitado'),
(39,'SIS32','B',2,2018,'III','Habilitado'),
(40,'SIS33','U',2,2018,'III','Habilitado'),
(41,'SIS33','A',2,2018,'III','Habilitado'),
(42,'PAT11','U',5,2018,'I','Habilitado'),
(43,'PAT11','A',5,2018,'I','Habilitado'),
(44,'PAT11','B',5,2018,'I','Habilitado'),
(45,'PAT31','U',5,2018,'III','Habilitado'),
(46,'PAT31','A',5,2018,'III','Habilitado'),
(47,'PAT31','B',5,2018,'III','Habilitado'),
(48,'PAT32','U',5,2018,'III','Habilitado'),
(49,'Ingles Basico Entre ','U',6,2018,'I','Habilitado'),
(50,'Ingles Intermedio En','U',6,2018,'I','Habilitado'),
(51,'Ingles Avanzado Entr','U',6,2018,'I','Habilitado'),
(52,'Ingles Talk Entre Se','U',6,2018,'I','Habilitado');

/*Data for the table `hr_ubicacion` */
INSERT  INTO `hr_ubicacion`(`id_ubicacion`,`ubicacion`,`estado`) VALUES 
(1,'Primera Planta',1),
(2,'Segunda Planta',1),
(3,'Zona Parqueo Externo',1),
(4,'Bloque C',1);

/*Data for the table `aula` */
INSERT  INTO aula(id_aula,aula,tipo_aula,descripcion,idUbicacion_FK,capacidad_horas,estado) VALUES 
(1,'101','Aula','Aula:  101','1',12,1),
(12,'CC4','Computo','Computo:  CC4','2',12,1),
(3,'102','Aula','Aula:  102','1',12,1),
(4,'103','Aula','Aula:  103','1',12,1),
(5,'Laboratorio_Pat','Taller','Taller:  Laboratorio Pat','1',12,1),
(6,'PLC','Taller','Taller:  PLC','1',12,1),
(7,'TALLER1','Taller','Taller:  TALLER1','1',12,1),
(8,'SUBEST_A','Taller','Taller:  SUBEST_A','1',12,1),
(9,'CC1','Computo','Computo:  CC1','2',12,1),
(10,'CC2','Computo','Computo:  CC2','2',12,1),
(11,'CC3','Computo','Computo:  CC3','2',12,1),
(13,'CC5','Computo','Computo:  CC5','2',12,1),
(14,'C101','Aula','Aula:  C101','4',12,1),
(15,'C102','Aula','Aula:  C102','4',12,1),
(16,'C103','Aula','Aula:  C103','4',12,1),
(17,'C104','Aula','Aula:  C104','4',12,1),
(18,'C105','Aula','Aula:  C105','4',12,1),
(19,'104','Aula','Aula:  104','3',12,1),
(20,'TALLER2','Taller','Taller:  TALLER2','3',12,1),
(21,'SUBEST_B','Taller','Taller:  SUBEST_B','1',12,1),
(23,'Audi','Aula','Aula:  Audi','1',12,1);

/*Data for the table `horario` */

INSERT  INTO horario(id_horario,ha,hf) VALUES 
(1,'07:00:00','07:50:00'),
(2,'07:50:00','08:40:00'),
(13,'09:00:00','09:50:00'),
(21,'15:30:00','16:20:00'),
(20,'14:40:00','15:30:00'),
(19,'13:50:00','14:40:00'),
(18,'13:00:00','13:50:00'),
(16,'11:30:00','12:20:00'),
(15,'10:40:00','11:30:00'),
(14,'09:50:00','10:40:00'),
(22,'16:20:00','17:10:00'),
(23,'17:10:00','18:00:00');

SELECT hf FROM hora WHERE hf LIKE ''

/*Data for the table `grupo` */

INSERT  INTO grupo(id_grupo,grupo,tipo,idcarrera_FK,`year`,ciclo,estado) VALUES 
(1,'MAN11','U',4,2018,'I','Habilitado'),
(2,'MAN11','A',4,2018,'I','Habilitado'),
(3,'MAN11','B',4,2018,'I','Habilitado'),
(4,'MAN31','U',4,2018,'III','Habilitado'),
(5,'MAN31','A',4,2018,'III','Habilitado'),
(6,'MAN31','B',4,2018,'III','Habilitado'),
(7,'ELEC11','U',3,2018,'I','Habilitado'),
(8,'ELEC11','A',3,2018,'I','Habilitado'),
(9,'ELEC11','B',3,2018,'I','Habilitado'),
(10,'ELEC12','U',3,2018,'I','Habilitado'),
(11,'ELEC12','A',3,2018,'I','Habilitado'),
(12,'ELEC12','B',3,2018,'I','Habilitado'),
(13,'ELEC13','U',3,2018,'I','Habilitado'),
(14,'ELEC13','A',3,2018,'I','Habilitado'),
(15,'ELEC31','U',3,2018,'III','Habilitado'),
(16,'ELEC31','A',3,2018,'III','Habilitado'),
(17,'ELEC31','B',3,2018,'III','Habilitado'),
(18,'ELEC32','U',3,2018,'III','Habilitado'),
(19,'ELEC32','A',3,2018,'III','Habilitado'),
(20,'ELEC32','B',3,2018,'III','Habilitado'),
(21,'ELEC23','U',3,2018,'I','Habilitado'),
(22,'ELEC23','A',3,2018,'I','Habilitado'),
(23,'ELEC43','U',3,2018,'I','Habilitado'),
(24,'ELEC43','A',3,2018,'I','Habilitado'),
(25,'SIS11','U',2,2018,'I','Habilitado'),
(26,'SIS11','A',2,2018,'I','Habilitado'),
(27,'SIS11','B',2,2018,'I','Habilitado'),
(28,'SIS12','U',2,2018,'I','Habilitado'),
(29,'SIS12','A',2,2018,'I','Habilitado'),
(30,'SIS12','B',2,2018,'I','Habilitado'),
(31,'SIS13','U',2,2018,'I','Habilitado'),
(32,'SIS13','A',2,2018,'I','Habilitado'),
(33,'SIS13','B',2,2018,'I','Habilitado'),
(34,'SIS31','U',2,2018,'III','Habilitado'),
(35,'SIS31','A',2,2018,'III','Habilitado'),
(36,'SIS31','B',2,2018,'III','Habilitado'),
(37,'SIS32','U',2,2018,'III','Habilitado'),
(38,'SIS32','A',2,2018,'III','Habilitado'),
(39,'SIS32','B',2,2018,'III','Habilitado'),
(40,'SIS33','U',2,2018,'III','Habilitado'),
(41,'SIS33','A',2,2018,'III','Habilitado'),
(42,'PAT11','U',5,2018,'I','Habilitado'),
(43,'PAT11','A',5,2018,'I','Habilitado'),
(44,'PAT11','B',5,2018,'I','Habilitado'),
(45,'PAT31','U',5,2018,'III','Habilitado'),
(46,'PAT31','A',5,2018,'III','Habilitado'),
(47,'PAT31','B',5,2018,'III','Habilitado'),
(48,'PAT32','U',5,2018,'III','Habilitado'),
(49,'Ingles Basico Entre ','U',6,2018,'I','Habilitado'),
(50,'Ingles Intermedio En','U',6,2018,'I','Habilitado'),
(51,'Ingles Avanzado Entr','U',6,2018,'I','Habilitado'),
(52,'Ingles Talk Entre Se','U',6,2018,'I','Habilitado');

INSERT  INTO docente(id_docente,carnet,nombres_us,apellidos_us,tipo,tel_casa,celular,email, estado, clave, idDepartamento_FK2, contrato, fechai, fechaf, nhoras, hpagadas, permanente, acceso_sistema, es_administrador, es_asesor, es_jurado, si_publica) VALUES 
(1,'1000','Ricardo','Quintanilla','Administrador','16181821','78279172', 'repadila@si', 'si', 'clave', 1, 'si', '17/02/2019', '17/02/2019', 2, 2, 1, 1, 1, 1, 1, 1),
(2,'2000','Henri','Martinez','Administrador','16181821','78279172', 'repadila@si', 'si', 'clave', 2, 'si', '17/02/2019', '17/02/2019', 2, 2, 1, 1, 1, 1, 1, 1),
(3,'3000','Vladimir','Aguilar','Administrador','16181821','78279172', 'repadila@si', 'si', 'clave', 3, 'si', '17/02/2019', '17/02/2019', 2, 2, 1, 1, 1, 1, 1, 1),
(4,'4000','Yaquelin','Méndez','Administrador','16181821','78279172', 'repadila@si', 'si', 'clave', 4, 'si', '17/02/2019', '17/02/2019', 2, 2, 1, 1, 1, 1, 1, 1),
(5,'5000','Jenny','García','Administrador','16181821','78279172', 'repadila@si', 'si', 'clave', 5, 'si', '17/02/2019', '17/02/2019', 2, 2, 1, 1, 1, 1, 1, 1),
(6,'6000','César','Barrera','Administrador','16181821','78279172', 'repadila@si', 'si', 'clave', 7, 'si', '17/02/2019', '17/02/2019', 2, 2, 1, 1, 1, 1, 1, 1);

/*Data for the table `detalle` */
INSERT  INTO detalle(idDocente_FK,idGrupo_FK,idMateria_FK,idAula_FK,ha,hf,ciclo,dia,tipo,`version`,fecha_ini,fecha_fin,comentario_reserva,carnet_usuario) VALUES 
(1,27,11,9,'07:00:00','07:50:00','I', 'Lunes', 'tipo', '1','1000-01-01','1000-01-01','s', '1000');

SELECT materia.materia, materia.codigo_materia, docente.nombres_us AS NombresUS, docente.apellidos_us AS ApellidosUS, grupo.grupo 
FROM detalle INNER JOIN materia ON (detalle.idMateria_FK=materia.id_materia) INNER JOIN docente ON (detalle.idDocente_FK=docente.id_docente) INNER JOIN grupo ON (detalle.idGrupo_FK=grupo.id_grupo) INNER JOIN aula ON (detalle.idAula_FK=aula.id_aula)
WHERE dia = 'Lunes' AND ha = '07:00:00' AND aula.aula = '101'

SELECT ha FROM detalle WHERE dia = 'Lunes' && idAula_FK = 1;
SELECT * FROM detalle WHERE idAula_FK = 1;

DELETE FROM detalle WHERE idAula_FK = 1 && ha = '07:50:00' OR ha = '09:50:00'

SELECT ha FROM detalle WHERE dia = 'Lunes' && idAula_FK = 3 && ha IN (SELECT ha,hf FROM horario WHERE Descuento >= 0.25)

SELECT ha, hf FROM
(
	SELECT ha FROM detalle WHERE dia = 'Lunes' && idAula_FK = 3
	UNION ALL 
	SELECT ha,hf FROM horario WHERE ha != 1
)
SELECT ha FROM detalle WHERE dia = 'Lunes' && idDocente_FK = 1;
SELECT * FROM detalle


SELECT id_grupo, grupo, tipo FROM grupo WHERE ciclo LIKE 'I' && id_docente NOT IN (SELECT idDocente_FK FROM detalle WHERE dia = 'Lunes' && ha = '07:00:00');

SELECT ha, hf FROM horario WHERE ha IN (SELECT ha FROM detalle WHERE dia = 'Lunes' && (idDocente_FK = 1 OR idGrupo_FK = 29));
SELECT ha FROM detalle WHERE dia = 'Miércoles' && (idDocente_FK = 2 OR idGrupo_FK = 28)

SELECT ha, hf FROM horario WHERE ha IN (SELECT ha FROM detalle WHERE dia = 'Lunes' && idDocente_FK = 2);
