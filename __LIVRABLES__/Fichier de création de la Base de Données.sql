-- DATABASE CREATION --
CREATE DATABASE IF NOT EXISTS evaluation_back_end_application_web CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- TABLES CREATION --
DROP TABLE IF EXISTS agent;
DROP TABLE IF EXISTS contact;
DROP TABLE IF EXISTS hideout;
DROP TABLE IF EXISTS mission;
DROP TABLE IF EXISTS specialty;
DROP TABLE IF EXISTS target;
DROP TABLE IF EXISTS user;

CREATE TABLE agent (
  id int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  last_name varchar(255) NOT NULL,
  first_name varchar(255) NOT NULL,
  date_of_birth datetime NOT NULL,
  identification_code int(11) NOT NULL UNIQUE,
  nationality varchar(255) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE contact (
  id int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  last_name varchar(255) NOT NULL,
  first_name varchar(255) NOT NULL,
  date_of_birth datetime NOT NULL,
  code_name varchar(255) NOT NULL UNIQUE,
  nationality varchar(255) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE hideout (
  id int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  code int(11) NOT NULL UNIQUE,
  address varchar(255) NOT NULL,
  country varchar(255) NOT NULL,
  type varchar(255) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE specialty (
  id int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  title varchar(255) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE target (
  id int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  last_name varchar(255) NOT NULL,
  first_name varchar(255) NOT NULL,
  date_of_birth datetime NOT NULL,
  code_name varchar(255) NOT NULL UNIQUE,
  nationality varchar(255) NOT NULL,
) ENGINE=InnoDB;

CREATE TABLE mission (
  id int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  required_specialty_id int(11) NOT NULL,
  title varchar(255) NOT NULL,
  description longtext NOT NULL,
  code_name varchar(255) NOT NULL UNIQUE,
  country varchar(255) NOT NULL,
  start_date datetime NOT NULL,
  end_date datetime NOT NULL,
  status varchar(255) NOT NULL,
  type varchar(255) NOT NULL,
  CONSTRAINT has_required_speciality
    FOREIGN KEY (required_specialty_id)
    REFERENCES specialty(id)
) ENGINE=InnoDB;

CREATE TABLE user (
  id int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  last_name varchar(255) NOT NULL,
  first_name varchar(255) NOT NULL,
  email varchar(180) NOT NULL UNIQUE,
  password varchar(255) NOT NULL,
  created_at datetime NOT NULL,
  roles longtext NOT NULL COMMENT '(DC2Type:json)'
) ENGINE=InnoDB;

-- ASSOCIATION TABLES CREATION --
DROP TABLE IF EXISTS agent_specialty;
DROP TABLE IF EXISTS mission_agent;
DROP TABLE IF EXISTS mission_contact;
DROP TABLE IF EXISTS mission_hideout;
DROP TABLE IF EXISTS mission_target;

CREATE TABLE agent_specialty (
  agent_id int(11) NOT NULL,
  specialty_id int(11) NOT NULL,
  PRIMARY KEY (agent_id,specialty_id),
  CONSTRAINT is_agent
    FOREIGN KEY (agent_id)
    REFERENCES agent (id)
    ON DELETE CASCADE,
  CONSTRAINT has_specialty
    FOREIGN KEY (specialty_id)
    REFERENCES specialty (id)
    ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE mission_agent (
  mission_id int(11) NOT NULL,
  agent_id int(11) NOT NULL,
  PRIMARY KEY (mission_id,agent_id),
  CONSTRAINT is_mission_agent
    FOREIGN KEY (agent_id)
    REFERENCES agent (id)
    ON DELETE CASCADE,
  CONSTRAINT is_agent_mission
    FOREIGN KEY (mission_id)
    REFERENCES mission (id)
    ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE mission_contact (
  mission_id int(11) NOT NULL,
  contact_id int(11) NOT NULL,
  PRIMARY KEY (mission_id,contact_id),
  CONSTRAINT is_contact_mission
    FOREIGN KEY (mission_id)
    REFERENCES mission (id)
    ON DELETE CASCADE,
  CONSTRAINT is_mission_contact
    FOREIGN KEY (contact_id)
    REFERENCES contact (id)
    ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE mission_hideout (
  mission_id int(11) NOT NULL,
  hideout_id int(11) NOT NULL,
  PRIMARY KEY (mission_id,hideout_id),
  CONSTRAINT is_hideout_mission
    FOREIGN KEY (mission_id)
    REFERENCES mission (id)
    ON DELETE CASCADE,
  CONSTRAINT is_mission_hideout
    FOREIGN KEY (hideout_id)
    REFERENCES hideout (id)
    ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE mission_target (
  mission_id int(11) NOT NULL,
  target_id int(11) NOT NULL,
  PRIMARY KEY (mission_id,target_id),
  CONSTRAINT is_target_mission
    FOREIGN KEY (mission_id)
    REFERENCES mission (id)
    ON DELETE CASCADE,
  CONSTRAINT is_mission_target
    FOREIGN KEY (target_id)
    REFERENCES target (id)
    ON DELETE CASCADE
) ENGINE=InnoDB;

-- PRIVILEGES MANAGEMENT --
GRANT ALL PRIVILEGES ON evaluation_back_end_application_web.* TO 'admin'@'%';
FLUSH PRIVILEGES;

-- TABLES FILLING FUNCTIONS --
INSERT INTO agent VALUES (1,'Setine','Ieveni','1976-01-15 00:00:00',101,'Russie'),(2,'Gardenborough','Nigel','1983-07-08 00:00:00',102,'Royaume Uni'),(3,'Pelletier','Raymond','1989-09-04 00:00:00',103,'Belgique'),(4,'Moeller','Gerhard','1985-02-28 00:00:00',104,'Allemagne'),(5,'El Akmar Betouche','Larmina','1974-12-05 00:00:00',105,'Egypte'),(6,'Plantieux','Gilbert','1972-03-18 00:00:00',106,'France'),(7,'Lesignac','Armand','1986-04-12 00:00:00',107,'France'),(8,'Koulechov','Dolorès','1989-12-13 00:00:00',108,'Israël'),(9,'Trumendous','William','1971-10-16 00:00:00',109,'Etats Unis'),(10,'Von Zimmel','Friedrich','1984-02-11 00:00:00',110,'Allemagne'),(11,'Frieda','Carlotta','1980-09-06 00:00:00',111,'Brésil'),(12,'Bamba','Zéphyrine','1979-01-15 00:00:00',112,'Kenya'),(13,'Pierson','Micheline','1975-02-20 00:00:00',113,'France'),(14,'Lépervier','Roland','1978-12-02 00:00:00',114,'France'),(15,'Ledentu','Josie','1972-11-01 00:00:00',115,'France'),(16,'Jacquard','Jacky','1975-04-15 00:00:00',116,'France'),(17,'Bonisseur de la Bath','Hubert','1979-04-22 00:00:00',117,'France'),(18,'Jefferson','Jack','1976-03-05 00:00:00',118,'France'),(19,'Calot','Jean-René','1986-04-08 00:00:00',119,'France'),(20,'Moulinier','Roger','1975-08-11 00:00:00',120,'France');
INSERT INTO contact VALUES (1,'Vanichev','Mervin','1955-05-30 00:00:00','Merlin','France'),(2,'Beadle','Abbye','1971-03-06 00:00:00','Perceval','France'),(3,'MacNalley','Etta','1968-01-26 00:00:00','Yvain','Hongrie'),(4,'Vowells','Nani','1976-07-22 00:00:00','Galahad','Hongrie'),(5,'Newiss','Letty','1962-03-10 00:00:00','Arthur','Corée Du Nord'),(6,'Plaschke','Jessy','1965-11-19 00:00:00','Guenièvre','Corée Du Nord'),(7,'MacNalley','Waylen','1975-10-02 00:00:00','Bohort','Turquie'),(8,'Diggins','Marcella','1954-10-09 00:00:00','Morgause','Turquie'),(9,'Ownsworth','Hastie','1972-04-13 00:00:00','Caelia','Côte d''Ivoire'),(10,'Delyth','Cookie','1961-07-01 00:00:00','Brangien','Côte d''Ivoire'),(11,'Warratt','Ericka','1976-06-21 00:00:00','Viviane','Etats Unis'),(12,'Roll','Tod','1973-03-03 00:00:00','Loth','Etats Unis'),(13,'Scandred','Claudine','1972-03-09 00:00:00','Elaine','Royaume Uni'),(14,'Cecchi','Ediva','1956-09-23 00:00:00','Laudine','Royaume Uni'),(15,'Gummory','Keefe','1958-09-07 00:00:00','Léodagan','Russie'),(16,'Walster','Jessie','1960-10-27 00:00:00','Gauvain','Russie'),(17,'Heasly','Tani','1961-01-24 00:00:00','Uther','Pakistan'),(18,'Ferie','Curry','1969-10-17 00:00:00','Mordred','Pakistan'),(19,'Huggens','Mirabelle','1956-12-25 00:00:00','Pellinore','Italie'),(20,'Gouny','Daphene','1961-11-26 00:00:00','Bédivère','Italie'),(21,'Garken','Frederico','1975-10-22 00:00:00','Méléagant','Cuba'),(22,'Strangwood','Alene','1958-03-10 00:00:00','Calogrenant','Cuba'),(23,'Charge','Brew','1973-04-18 00:00:00','Gareth','Japon'),(24,'Heinlein','Dame','1974-08-10 00:00:00','Klingsor','Japon'),(25,'Cattrall','Doloritas','1962-12-14 00:00:00','Gorlois','Inde'),(26,'Kahn','Ivan','1973-11-15 00:00:00','Caradoc','Inde'),(27,'Geaveny','Micheal','1964-02-08 00:00:00','Gallessin','Egypte'),(28,'Ible','Carl','1974-10-08 00:00:00','Lancelot','Egypte'),(29,'Attac','Arlina','1979-11-03 00:00:00','Hector','Colombie'),(30,'Marden','Theo','1977-11-19 00:00:00','Accolon','Colombie');
INSERT INTO hideout VALUES (1,4959,'La Frange, 5 rue Cochin, Paris','France','Souterrain'),(2,7723,'Arcadia, Madach Imre Ter 4, Budapest','Hongrie','Hôtel'),(3,1958,'Chang Gwang San, Chollima Street, Pyongyang','Corée Du Nord','Hôtel'),(4,6344,'Korkutreis, Strazburg Cd, Ankara','Turquie','Appartement'),(5,8828,'Pullman, rue Abdoulaye Fadiga, Abidjan','Côte d''Ivoire','Hôtel'),(6,4863,'Flatiron, 175 5th Avenue, New York','Etats Unis','Appartement'),(7,7531,'Anthropology Library, Great Russel Street, Londres','Royaume Uni','Souterrain'),(8,1597,'Shabolovka, Ulitsa Shukhova 5, Moscou','Russie','Hôtel'),(9,6548,'Khyber Inn, 740 Street 64, Islamabad','Pakistan','Auberge'),(10,4562,'La Casa di Antonella, Via delle Terme 72, Sienne','Italie','Appartement'),(11,3297,'Tulipan, Lombillo y Tulipam, La Havane','Cuba','Auberge'),(12,1237,'Imperial Hotel, 1 Chome Uchisaiwaicho, Tokyo','Japon','Hôtel'),(13,9173,'Bhoj Restaurant, Khanna Market Road, New Delhi','Inde','Souterrain'),(14,3791,'Inter Continental Cairo, Kamal El Din Hussein Street, Le Caire','Egypte','Hôtel'),(15,5972,'Palacio Real, Calle 72 74 A, Bogota','Colombie','Hôtel');
INSERT INTO specialty VALUES (1,'Tireur d''élite'),(2,'Polyglotte'),(3,'Diplomate'),(4,'Corps à corps'),(5,'Infiltration'),(6,'Surveillance élèctronique'),(7,'Cryptographe'),(8,'Analyste géopolitique');
INSERT INTO target VALUES (1,'Rehm','Winne','1973-08-15 00:00:00','Joker','Autriche'),(2,'Heine','Benton','1972-05-20 00:00:00','Magnéto','Serbie'),(3,'Witnall','Arabele','1980-01-10 00:00:00','Fatalis','Serbie'),(4,'Benfell','Esra','1979-04-24 00:00:00','Luthor','Tunisie'),(5,'O''Neal','Jacob','1987-08-31 00:00:00','Galactus','Canada'),(6,'Udey','Myrna','1985-01-07 00:00:00','Darkseid','Estonie'),(7,'Morcomb','Mack','1980-06-05 00:00:00','Ras al Ghul','Croatie'),(8,'Breawood','Diannne','1979-08-23 00:00:00','Loki','Etats Unis'),(9,'Sieve','Karlan','1977-10-16 00:00:00','Phoenix','Etats Unis'),(10,'Johnke','Demetre','1990-04-02 00:00:00','Osborn','Algerie'),(11,'Collingwood','Kory','1979-01-25 00:00:00','Sinestro','Irlande'),(12,'Betke','Lilith','1983-01-25 00:00:00','Adam','Irlande'),(13,'Renbold','Leta','1979-12-30 00:00:00','Brainiac','Bulgarie'),(14,'Cassel','Auberta','1989-03-07 00:00:00','Mystique','Afrique Du Sud'),(15,'Borrington','Dorry','1989-05-29 00:00:00','Bullseye','Ecosse'),(16,'Clearie','Westbrooke','1988-05-21 00:00:00','Venom','Royaume Uni'),(17,'Kores','Jillian','1979-11-27 00:00:00','Ultron','Royaume Uni'),(18,'Neads','Der','1988-04-26 00:00:00','Bizarro','Turquie'),(19,'Gallandre','Kelby','1973-11-09 00:00:00','Octopus','Biélorussie'),(20,'Easseby','Halley','1987-11-20 00:00:00','Shredder','Danemark');
INSERT INTO mission VALUES (1,1,'Alerte Rouge','Eliminer les representants de la mafia Serbe','MS-FRA-001','France','2022-06-20 00:00:00','2022-06-23 00:00:00','En préparation','Assassinat'),(2,6,'Baby Sitter','Mettre sur écoute le Joker','MS-HON-002','Hongrie','2022-01-13 06:00:00','2022-02-13 06:00:00','Terminé','Surveillance'),(3,3,'Bouclier','Empêcher les agents de la CIA de s''infiltrer dans le palais présidentiel','MS-COR-003','Corée Du Nord','2022-02-01 00:00:00','2022-02-11 00:00:00','Echec','Contre Espionnage'),(4,5,'Loup dans la bergerie','Infiltrer un agent dans les services secrêts turcs','MS-TUR-004','Turquie','2022-01-20 06:00:00','2022-06-01 06:00:00','En cours','Infiltration'),(5,1,'Abidjan ne répond plus','Eliminer la résponsable des exactions sur les civils','MS-COT-005','Côte D''Ivoire','2022-07-01 00:00:00','2022-07-07 00:00:00','En préparation','Assassinat'),(6,5,'Home Alone','Libérer l''agent Français aux mains d''Octopus','MS-ETA-006','Etats Unis','2021-08-01 06:00:00','2021-09-10 06:00:00','Terminé','Assistance'),(7,1,'Strike for Peace','Eliminer les terroristes Irlandais','MS-ROY-007','Royaume Uni','2022-04-15 06:00:00','2022-05-15 06:00:00','En cours','Assassinat'),(8,5,'Piège à taupe','Connaître les intentions des forces Russes','MS-RUS-008','Russie','2022-03-20 06:00:00','2022-06-20 06:00:00','En cours','Infiltration'),(9,6,'Champignon sauté','Se renseigner sur les capacités de frappes longues portée du pays','MS-PAK-009','Pakistan','2022-06-21 06:00:00','2022-06-30 06:00:00','En préparation','Surveillance'),(10,1,'Bat Smasher','Eliminer le terroriste Ras al Ghul','MS-ITA-010','Italie','2021-12-10 06:00:00','2022-01-10 06:00:00','Echec','Assassinat'),(11,6,'Nez propre','Découvrir la tête du réseau d''importation de cigares en Europe','MS-CUB-011','Cuba','2022-09-01 06:00:00','2022-09-15 06:00:00','En préparation','Surveillance'),(12,5,'Lighting Scott','Empêcher le terrorriste Ecossais Bullseye de s''emparer des dechets radioactifs issus de l''accident nucléaire de Fukushima','MS-JAP-012','Japon','2022-03-20 06:00:00','2022-03-30 06:00:00','Terminé','Infiltration'),(13,8,'Peace Advisor','Rapporter les mouvements de troupes à la frontière Pakistanaise','MS-IND-013','Inde','2022-01-17 06:00:00','2022-06-17 06:00:00','En cours','Surveillance'),(14,1,'Baby Sitter','Eliminer le terroriste Luthor','MS-EGY-014','Egypte','2021-12-24 06:00:00','2021-12-30 06:00:00','Terminé','Assassinat'),(15,3,'Nez propre','Découvrir la tête du réseau d''importation de cocaïne en Europe','MS-COL-015','Colombie','2022-02-01 00:00:00','1902-11-30 00:00:00','Terminé','Surveillance');
INSERT INTO user VALUES (1,'Bond','James','admin@admin.com','$2y$13$81NshZj4QTOdwWm7N.j7Put9FeW9hzp4JCuHpJNhdtoiEOLVJDOma','2022-04-11 20:59:29','[\"ROLE_ADMIN\"]');

-- ASSOCIATION TABLES FILLING FUNCTIONS --
INSERT INTO agent_specialty VALUES (1,5),(1,7),(2,2),(2,6),(3,1),(3,8),(4,2),(4,5),(5,2),(5,5),(6,3),(7,1),(7,8),(8,5),(8,6),(9,3),(9,8),(10,2),(11,3),(11,4),(12,1),(12,7),(13,3),(14,1),(14,8),(15,6),(16,8),(17,1),(17,2),(17,3),(17,4),(17,5),(17,6),(17,7),(17,8),(18,1),(18,8),(19,6),(20,8);
INSERT INTO mission_agent VALUES (1,3),(2,8),(3,6),(4,4),(5,12),(6,1),(7,14),(8,17),(9,15),(10,18),(11,2),(12,5),(13,16),(14,7),(15,9);
INSERT INTO mission_contact VALUES (1,1),(1,2),(2,3),(2,4),(3,5),(3,6),(4,7),(4,8),(5,9),(5,10),(6,11),(6,12),(7,13),(7,14),(8,15),(8,16),(9,17),(9,18),(10,19),(10,20),(11,21),(11,22),(12,23),(12,24),(13,25),(13,26),(14,27),(14,28),(15,29),(15,30);
INSERT INTO mission_hideout VALUES (1,1),(2,2),(3,3),(4,4),(5,5),(6,6),(7,7),(8,8),(9,9),(10,10),(11,11),(12,12),(13,13),(14,14),(15,15);
INSERT INTO mission_target VALUES (1,2),(1,3),(2,1),(3,8),(3,9),(4,10),(5,14),(6,19),(7,11),(7,12),(8,6),(9,16),(9,17),(10,7),(11,5),(11,20),(12,15),(13,13),(14,4),(15,18);
