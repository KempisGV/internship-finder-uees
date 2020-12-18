-- TABLA GENERAL DE USUARIOS
CREATE TABLE IF NOT EXISTS TB_USERS (
	user_id int NOT NULL AUTO_INCREMENT UNIQUE,
	name varchar(100) NOT NULL,
	lastname varchar(100) NULL,
	email varchar(100) NOT NULL UNIQUE,
	document varchar(20) NOT NULL UNIQUE,
	city varchar(50) NOT NULL,
	phone varchar(100)NOT NULL,
	birth bigint(20) NULL,
	avatar varchar(250) NULL,
	bio text NULL,
	password_hash varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
	account_type tinyint(1) NOT NULL DEFAULT 1 COMMENT "1: Estudiante, 2: Compania, 3: Universidad, 4: Administrador",
	active tinyint(1) NOT NULL DEFAULT '0',
	deleted tinyint(1) NOT NULL DEFAULT '0',
	remember_me_token varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
	creation_timestamp bigint(20) DEFAULT NULL,
	suspension_timestamp bigint(20) DEFAULT NULL,
	last_login_timestamp bigint(20) DEFAULT NULL,
	failed_logins tinyint(1) NOT NULL DEFAULT '0',
	last_failed_login int(10) DEFAULT NULL,
	activation_hash varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
	password_reset_hash char(40) COLLATE utf8_unicode_ci DEFAULT NULL,
	password_reset_timestamp bigint(20) DEFAULT NULL,
	university tinyint(1) NULL COMMENT 'key value from config',
	PRIMARY KEY (user_id)
);

INSERT INTO TB_USERS (user_id, name, lastname, email, document, city, phone, birth, password_hash, active, account_type, avatar) VALUES
(1, 'Administrador', 'Internship Finder', 'admin@internshipfinder.com', '0999999999', 2, '0999999999', null, '$2y$10$NHfUAchqoyLouHZT8lwPveSP1l64yT16eVsnp9BxoMJQpPdHcSWh2', 1, 4, 'admin.png');

-- TABLA DE ESTUDIOS DEL ESTUDIANTE
CREATE TABLE IF NOT EXISTS TB_STUDIES (
	study_id int NOT NULL AUTO_INCREMENT UNIQUE,
	student_id int NOT NULL,
	school_name int NOT NULL,
	start_date int NOT NULL,
	end_date int NOT NULL,
	career int NOT NULL,
	credits int NOT NULL,
	description text NOT NULL,
	PRIMARY KEY (study_id)
);

-- -- TABLA DE HABILIDADES DEL ESTUDIANTE
CREATE TABLE IF NOT EXISTS TB_SKILLS (
	skill_id int NOT NULL AUTO_INCREMENT UNIQUE,
	student_id int NOT NULL,
	name varchar(200) NOT NULL,
	rating int NOT NULL,
	PRIMARY KEY (skill_id)
);

-- TABLA DE CONVENIOS ENTRE LA UNIVERSIDAD Y COMPANIAS
CREATE TABLE IF NOT EXISTS TB_DEALS (
	deal_id int NOT NULL AUTO_INCREMENT UNIQUE,
	university_id int NOT NULL,
	company_id int NOT NULL,
	deal_type int NOT NULL COMMENT '1: PP, 2: PV',
	start_date int NOT NULL,
	duration int NOT NULL,
	contact_person varchar(100) NOT NULL,
	contact_mail varchar(100) NOT NULL,
	university_person varchar(100) NOT NULL,
	university_mail varchar(100) NOT NULL,
	deal_extent int NOT NULL COMMENT '1: marco, 2: especifico',
	deal_autorenewable tinyint(1) NOT NULL ,
	file_name varchar(200) NULL,
	PRIMARY KEY (deal_id)
);

-- TABLA DE SOLICITUDES DE REGISTRO DE UNIVERSIDADES Y COMPANIAS
CREATE TABLE IF NOT EXISTS TB_REQUESTS (
	request_id int NOT NULL AUTO_INCREMENT UNIQUE,
	request_type int NOT NULL COMMENT '1: COMPANIA 2: UNIVERSIDAD',
	institution_name varchar(100) NOT NULL,
	name varchar(100) NOT NULL,
	lastname varchar(100) NOT NULL,
	email varchar(100) NOT NULL UNIQUE,
	document varchar(20) NOT NULL UNIQUE,
	city varchar(50) NOT NULL,
	phone varchar(100)NOT NULL,
	university tinyint(1) NULL COMMENT 'key value from config',
	PRIMARY KEY (request_id)
);

-- TABLA DE OFERTAS PP Y PV
CREATE TABLE IF NOT EXISTS TB_OFFERS (
	offer_id varchar(200) NOT NULL UNIQUE,
	offer_type tinyint(1) NOT NULL COMMENT '1: PP, 2: PV',
	user_id int NOT NULL,
	title varchar(200) NOT NULL,
	city varchar(200) NOT NULL,
	end_date bigint(20) NOT NULL,
	description text NOT NULL,
	publication_date bigint(20) NULL,
	close_date bigint(20) NULL,
	PRIMARY KEY (offer_id)
);

-- TABLA CARRERAS DE CADA OFERTA
CREATE TABLE IF NOT EXISTS TB_CAREERS (
	offer_id varchar(200) NOT NULL,
	career int NOT NULL,
	PRIMARY KEY(offer_id, career)
);

-- TABLA AREAS DE TRABAJO DE CADA OFERTA
CREATE TABLE IF NOT EXISTS TB_WORKAREAS (
	offer_id varchar(200) NOT NULL,
	workarea int NOT NULL,
	PRIMARY KEY(offer_id, workarea)
);

-- TABLA BENEFICIOS DE CADA OFERTA
CREATE TABLE IF NOT EXISTS TB_BENEFITS (
	offer_id varchar(200) NOT NULL,
	benefit int NOT NULL,
	PRIMARY KEY(offer_id, benefit)
);

-- TABLA DE ESTUDIANTES POSTULADOS A UNA OFERTA
CREATE TABLE IF NOT EXISTS TB_APPLICATIONS (
	offer_id varchar(200) NOT NULL,
	student_id int NOT NULL,
	selected tinyint(1) NULL COMMENT '1: no seleccionado, 2: seleccionado',
	application_date bigint(20) NOT NULL,
	PRIMARY KEY (offer_id, student_id)
);

-- TABLA DE ESTUDIANTES ACTIVOS DE UNA UNIVERSIDAD
CREATE TABLE IF NOT EXISTS TB_STUDENTS (
	university_id int NOT NULL,
	student varchar(200) NOT NULL,
	PRIMARY KEY (university_id, student)
);