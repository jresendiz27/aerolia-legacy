DROP DATABASE IF EXISTS aerolia;
CREATE DATABASE aerolia;
USE aerolia;

CREATE TABLE c_tipousuario (
    id_tipousuario   INTEGER      NOT NULL AUTO_INCREMENT PRIMARY KEY,
    desc_tipousuario VARCHAR(255) NOT NULL
);

INSERT INTO c_tipousuario VALUES ('1','Usuario común');

CREATE TABLE c_pais (
    id_pais  CHAR(2)     NOT NULL PRIMARY KEY,
    nom_pais VARCHAR(50) NOT NULL
);
INSERT INTO c_pais VALUES ('AL','Albania'),('DE','Alemania'),('AD','Andorra'),('AO','Angola'),('AI','Anguila'),('AG','Antigua y Barbuda'),('AN','Antillas Holandesas'),('SA','Arabia Saudí'),('DZ','Argelia'),('AR','Argentina'),('AM','Armenia'),('AW','Aruba'),('AU','Australia'),('AT','Austria'),('BS','Bahamas'),('BH','Bahréin'),('BB','Barbados'),('BE','Bélgica'),('BZ','Belice'),('BJ','Benín'),('BM','Bermudas'),('BT','Bhután'),('BO','Bolivia'),('BA','Bosnia y Herzegovina'),('BW','Botsuana'),('BR','Brasil'),('BN','Brunéi'),('BG','Bulgaria'),('BF','Burkina Faso'),('BI','Burundi'),('CV','Cabo Verde'),('KH','Camboya'),('CA','Canadá'),('TD','Chad'),('CL','Chile'),('C2','China'),('CY','Chipre'),('VA','Ciudad del Vaticano'),('CO','Colombia'),('KM','Comoras'),('KR','Corea del Sur'),('CR','Costa Rica'),('HR','Croacia'),('DK','Dinamarca'),('DM','Dominica'),('EC','Ecuador'),('SV','El Salvador'),('AE','Emiratos árabes Unidos'),('ER','Eritrea'),('SK','Eslovaquia'),('SI','Eslovenia'),('ES','España'),('FM','Estados Federados de Micronesia'),('US','Estados Unidos'),('EE','Estonia'),('ET','Etiopía'),('PH','Filipinas'),('FI','Finlandia'),('FJ','Fiyi'),('FR','Francia'),('GM','Gambia'),('GI','Gibraltar'),('GD','Granada'),('GR','Grecia'),('GL','Groenlandia'),('GP','Guadalupe'),('GT','Guatemala'),('GF','Guayana Francesa'),('GN','Guinea'),('GW','Guinea-Bissau'),('GY','Guyana'),('HN','Honduras'),('HK','Hong Kong'),('HU','Hungría'),('IN','India'),('ID','Indonesia'),('IE','Irlanda'),('NF','Isla Norfolk'),('IS','Islandia'),('KY','Islas Caimán'),('CK','Islas Cook'),('FO','Islas Feroe'),('FK','Islas Malvinas'),('MH','Islas Marshall'),('PN','Islas Pitcairn'),('SB','Islas Salomón'),('TC','Islas Turcas y Caicos'),('VG','Islas Vírgenes Brit.'),('IL','Israel'),('IT','Italia'),('JM','Jamaica'),('JP','Japón'),('JO','Jordania'),('KZ','Kazajstán'),('KE','Kenia'),('KG','Kirguistán'),('KI','Kiribati'),('KW','Kuwait'),('LA','Laos'),('LS','Lesotho'),('LV','Letonia'),('LI','Liechtenstein'),('LT','Lituania'),('LU','Luxemburgo'),('MG','Madagascar'),('MY','Malasia'),('MW','Malawi'),('MV','Maldivas'),('ML','Malí'),('MT','Malta'),('MA','Marruecos'),('MQ','Martinica'),('MU','Mauricio'),('MR','Mauritania'),('YT','Mayotte'),('MX','México'),('MN','Mongolia'),('MS','Montserrat'),('MZ','Mozambique'),('NA','Namibia'),('NR','Nauru'),('NP','Nepal'),('NI','Nicaragua'),('NE','Níger'),('NU','Niue'),('NO','Noruega'),('NC','Nueva Caledonia'),('NZ','Nueva Zelanda'),('OM','Omán'),('NL','Países Bajos'),('PW','Palaos'),('PA','Panamá'),('PG','Papúa Nueva Guinea'),('PE','Perú'),('PF','Polinesia Francesa'),('PL','Polonia'),('PT','Portugal'),('QA','Qatar'),('GB','Reino Unido'),('CZ','República Checa'),('GA','República de Gab.'),('CG','República del Congo'),('CD','República Democrática del Congo'),('DO','República Dominicana'),('RE','Reunión'),('RW','Ruanda'),('RO','Rumanía'),('RU','Rusia'),('WS','Samoa'),('KN','San Cristóbal y Nieves'),('SM','San Marino'),('PM','San Pedro y Miquelón'),('VC','San Vicente y las Granadinas'),('SH','Santa Elena'),('LC','Santa Lucía'),('ST','Santo Tomé y Príncipe'),('SN','Senegal'),('SC','Seychelles'),('SL','Sierra Leona'),('SG','Singapur'),('SO','Somalia'),('LK','Sri Lanka'),('SZ','Suazilandia'),('ZA','Sudáfrica'),('SE','Suecia'),('CH','Suiza'),('SR','Surinam'),('SJ','Svalbard y Jan Mayen'),('TH','Tailandia'),('TW','Taiwán'),('TZ','Tanzania'),('TJ','Tayikistán'),('TG','Togo'),('TO','Tonga'),('TT','Trinidad y Tobago'),('TN','Túnez'),('TM','Turkmenistán'),('TR','Turquía'),('TV','Tuvalu'),('UA','Ucrania'),('UG','Uganda'),('UY','Uruguay'),('VU','Vanuatu'),('VE','Venezuela'),('VN','Vietnam'),('WF','Wallis y Futuna'),('YE','Yemen'),('DJ','Yibuti'),('ZM','Zambia');

CREATE TABLE m_usuario (
    id_usuario     INTEGER      NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_tipousuario INTEGER      NOT NULL DEFAULT 1,
    id_pais        CHAR(2)      NOT NULL,
    nom_usuario    VARCHAR(255) NOT NULL,
    email_usuario  VARCHAR(255) NOT NULL,
    pass_usuario   CHAR(64)     NOT NULL,
    val_usuario    BOOLEAN      NOT NULL DEFAULT FALSE,
    FOREIGN KEY (id_tipousuario) REFERENCES c_tipousuario(id_tipousuario),
    FOREIGN KEY (id_pais)        REFERENCES c_pais(id_pais)
);

CREATE TABLE m_aero (
    id_aero    INTEGER      NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_usuario INTEGER      NOT NULL,
    ns_aero    VARCHAR(255) NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES m_usuario(id_usuario)
);

CREATE TABLE c_evento (
    id_evento   INTEGER      NOT NULL AUTO_INCREMENT PRIMARY KEY,
    desc_evento VARCHAR(255) NOT NULL
);
INSERT INTO c_evento(id_evento, desc_evento) VALUES (1,'Estado normal'),(2,'Batería baja'),(3,'Batería agotada'),(4,'Exceso de velocidad de aspas: aspas detenidas'),(5,'Falla en la batería'),(6,'Falla de suministro de energía');

CREATE TABLE m_historial (
    id_historial    INTEGER  NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_aero         INTEGER  NOT NULL,
    id_evento       INTEGER  NOT NULL,
    fecha_historial DATETIME NOT NULL,
    FOREIGN KEY (id_aero)   REFERENCES m_aero(id_aero),
    FOREIGN KEY (id_evento) REFERENCES c_evento(id_evento)
);

CREATE TABLE c_tipodato (
    id_tipodato     INTEGER      NOT NULL AUTO_INCREMENT PRIMARY KEY,
    desc_tipodato   VARCHAR(255) NOT NULL,
    unidad_tipodato VARCHAR(10)
);
INSERT INTO c_tipodato(desc_tipodato, unidad_tipodato) VALUES ('Velocidad del viento','m/s'),('Presión atmosférica','atm'),('Velocidad de las aspas','RPM'),('Carga de la batería','%'),('Estado de la batería',''),('Estado del aerogenerador','');

CREATE TABLE m_dato (
    id_dato     INTEGER  NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_aero     INTEGER  NOT NULL,
    id_tipodato INTEGER  NOT NULL,
    val_dato    REAL,
    fec_dato    DATETIME NOT NULL,
    FOREIGN KEY (id_aero)     REFERENCES m_aero(id_aero),
    FOREIGN KEY (id_tipodato) REFERENCES m_tipodato(id_tipodato)
);

CREATE TABLE e_reporte (
    id_reporte   INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_aero      INTEGER NOT NULL,
    year_reporte INTEGER NOT NULL,
    sem_reporte  INTEGER NOT NULL,
    FOREIGN KEY (id_aero) REFERENCES m_aero(id_aero)
);

CREATE TABLE d_reporte (
    id_d_reporte    INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_reporte      INTEGER NOT NULL,
    id_tipodato     INTEGER NOT NULL,
    media_reporte   REAL    NOT NULL,
    mediana_reporte REAL    NOT NULL,
    arm_reporte     REAL    NOT NULL,
    q1_reporte      REAL    NOT NULL,
    q3_reporte      REAL    NOT NULL,
    FOREIGN KEY (id_reporte)  REFERENCES e_reporte(id_reporte),
    FOREIGN KEY (id_tipodato) REFERENCES c_tipodato(id_tipodato)
);