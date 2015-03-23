SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `sicmi3a01_Banane` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `sicmi3a01_Banane` ;

-- -----------------------------------------------------
-- Table `sicmi3a01_Banane`.`profil`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sicmi3a01_Banane`.`profil` ;

CREATE TABLE IF NOT EXISTS `sicmi3a01_Banane`.`profil` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(25) NOT NULL,
  `password` VARCHAR(60) NULL,
  `password_temp` VARCHAR(60) NULL,
  `email` VARCHAR(255) NOT NULL,
  `prenom` VARCHAR(45) NULL,
  `nom` VARCHAR(45) NULL,
  `description` TEXT NULL,
  `telephone` VARCHAR(10) NULL,
  `adresse` TEXT NULL,
  `cp` VARCHAR(10) NULL,
  `pays` VARCHAR(45) NULL,
  `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL,
  `fbid` VARCHAR(30) NULL COMMENT 'facebook id',
  `gid` VARCHAR(30) NULL COMMENT 'google id',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `fbid_UNIQUE` (`fbid` ASC),
  UNIQUE INDEX `username_UNIQUE` (`username` ASC),
  UNIQUE INDEX `gid_UNIQUE` (`gid` ASC));


-- -----------------------------------------------------
-- Table `sicmi3a01_Banane`.`projet`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sicmi3a01_Banane`.`projet` ;

CREATE TABLE IF NOT EXISTS `sicmi3a01_Banane`.`projet` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `createur_id` INT UNSIGNED NOT NULL,
  `publier` TINYINT(1) NULL,
  `description` TEXT NULL,
  `titre` VARCHAR(45) NOT NULL,
  `debut` DATE NOT NULL,
  `fin` DATE NOT NULL,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  `deleted_at` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_projet_profil1_idx` (`createur_id` ASC),
  CONSTRAINT `fk_projet_profil1`
    FOREIGN KEY (`createur_id`)
    REFERENCES `sicmi3a01_Banane`.`profil` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sicmi3a01_Banane`.`candidat_projet`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sicmi3a01_Banane`.`candidat_projet` ;

CREATE TABLE IF NOT EXISTS `sicmi3a01_Banane`.`candidat_projet` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `profil_id` INT UNSIGNED NOT NULL,
  `projet_id` INT UNSIGNED NOT NULL,
  `suggereur_id` INT UNSIGNED NULL,
  `etat_candidature` TINYINT(1) NULL,
  `etat_proposition` TINYINT(1) NULL,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  `deleted_at` DATETIME NULL,
  PRIMARY KEY (`id`, `profil_id`, `projet_id`),
  INDEX `fk_profiles_has_projets_projets1_idx` (`projet_id` ASC),
  INDEX `fk_profiles_has_projets_profiles_idx` (`profil_id` ASC),
  INDEX `fk_profils_inscirption_projets_profile1_idx` (`suggereur_id` ASC),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  CONSTRAINT `fk_profiles_has_projets_profiles`
    FOREIGN KEY (`profil_id`)
    REFERENCES `sicmi3a01_Banane`.`profil` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_profiles_has_projets_projets1`
    FOREIGN KEY (`projet_id`)
    REFERENCES `sicmi3a01_Banane`.`projet` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_profils_inscirption_projets_profile1`
    FOREIGN KEY (`suggereur_id`)
    REFERENCES `sicmi3a01_Banane`.`profil` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table `sicmi3a01_Banane`.`profil_favori`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sicmi3a01_Banane`.`profil_favori` ;

CREATE TABLE IF NOT EXISTS `sicmi3a01_Banane`.`profil_favori` (
  `profil_id` INT UNSIGNED NOT NULL,
  `favori_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`profil_id`, `favori_id`),
  INDEX `fk_profiles_has_profiles_profiles2_idx` (`favori_id` ASC),
  INDEX `fk_profiles_has_profiles_profiles1_idx` (`profil_id` ASC),
  CONSTRAINT `fk_profiles_has_profiles_profiles1`
    FOREIGN KEY (`profil_id`)
    REFERENCES `sicmi3a01_Banane`.`profil` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_profiles_has_profiles_profiles2`
    FOREIGN KEY (`favori_id`)
    REFERENCES `sicmi3a01_Banane`.`profil` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table `sicmi3a01_Banane`.`projet_favori`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sicmi3a01_Banane`.`projet_favori` ;

CREATE TABLE IF NOT EXISTS `sicmi3a01_Banane`.`projet_favori` (
  `projet_id` INT UNSIGNED NOT NULL,
  `profile_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`projet_id`, `profile_id`),
  INDEX `fk_projet_has_profile_profile1_idx` (`profile_id` ASC),
  INDEX `fk_projet_has_profile_projet1_idx` (`projet_id` ASC),
  CONSTRAINT `fk_projet_has_profile_projet1`
    FOREIGN KEY (`projet_id`)
    REFERENCES `sicmi3a01_Banane`.`projet` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_projet_has_profile_profile1`
    FOREIGN KEY (`profile_id`)
    REFERENCES `sicmi3a01_Banane`.`profil` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sicmi3a01_Banane`.`tag`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sicmi3a01_Banane`.`tag` ;

CREATE TABLE IF NOT EXISTS `sicmi3a01_Banane`.`tag` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(15) NULL,
  `description` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sicmi3a01_Banane`.`competence`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sicmi3a01_Banane`.`competence` ;

CREATE TABLE IF NOT EXISTS `sicmi3a01_Banane`.`competence` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `competence` VARCHAR(15) NULL,
  `description` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sicmi3a01_Banane`.`tag_projet`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sicmi3a01_Banane`.`tag_projet` ;

CREATE TABLE IF NOT EXISTS `sicmi3a01_Banane`.`tag_projet` (
  `tag_id` INT UNSIGNED NOT NULL,
  `projet_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`tag_id`, `projet_id`),
  INDEX `fk_tag_has_projet_projet1_idx` (`projet_id` ASC),
  INDEX `fk_tag_has_projet_tag1_idx` (`tag_id` ASC),
  CONSTRAINT `fk_tag_has_projet_tag1`
    FOREIGN KEY (`tag_id`)
    REFERENCES `sicmi3a01_Banane`.`tag` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tag_has_projet_projet1`
    FOREIGN KEY (`projet_id`)
    REFERENCES `sicmi3a01_Banane`.`projet` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sicmi3a01_Banane`.`profil_competence`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sicmi3a01_Banane`.`profil_competence` ;

CREATE TABLE IF NOT EXISTS `sicmi3a01_Banane`.`profil_competence` (
  `profil_id` INT UNSIGNED NOT NULL,
  `competence_id` INT UNSIGNED NOT NULL,
  `niveau` INT NULL,
  PRIMARY KEY (`profil_id`, `competence_id`),
  INDEX `fk_profil_has_competence_competence1_idx` (`competence_id` ASC),
  INDEX `fk_profil_has_competence_profil1_idx` (`profil_id` ASC),
  CONSTRAINT `fk_profil_has_competence_profil1`
    FOREIGN KEY (`profil_id`)
    REFERENCES `sicmi3a01_Banane`.`profil` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_profil_has_competence_competence1`
    FOREIGN KEY (`competence_id`)
    REFERENCES `sicmi3a01_Banane`.`competence` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table `sicmi3a01_Banane`.`recherche_historique`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sicmi3a01_Banane`.`recherche_historique` ;

CREATE TABLE IF NOT EXISTS `sicmi3a01_Banane`.`recherche_historique` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `date` DATETIME NULL,
  `query` MEDIUMTEXT NULL,
  `profil_id` INT UNSIGNED NULL,
  `tags` MEDIUMTEXT NULL,
  `competences` MEDIUMTEXT NULL,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_recherche_profil1_idx` (`profil_id` ASC),
  CONSTRAINT `fk_recherche_profil1`
    FOREIGN KEY (`profil_id`)
    REFERENCES `sicmi3a01_Banane`.`profil` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sicmi3a01_Banane`.`message`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sicmi3a01_Banane`.`message` ;

CREATE TABLE IF NOT EXISTS `sicmi3a01_Banane`.`message` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `text` MEDIUMTEXT NULL,
  `titre` LONGTEXT NULL,
  `profil_dest` INT UNSIGNED NOT NULL,
  `profil_source` INT UNSIGNED NOT NULL,
  `vue` TINYINT(1) NULL,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_message_profil1_idx` (`profil_dest` ASC),
  INDEX `fk_message_profil2_idx` (`profil_source` ASC),
  CONSTRAINT `fk_message_profil1`
    FOREIGN KEY (`profil_dest`)
    REFERENCES `sicmi3a01_Banane`.`profil` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_message_profil2`
    FOREIGN KEY (`profil_source`)
    REFERENCES `sicmi3a01_Banane`.`profil` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sicmi3a01_Banane`.`note_profil`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sicmi3a01_Banane`.`note_profil` ;

CREATE TABLE IF NOT EXISTS `sicmi3a01_Banane`.`note_profil` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `note` TINYINT(1) NULL,
  `evalueur_id` INT UNSIGNED NOT NULL,
  `profil_id` INT UNSIGNED NOT NULL,
  `projet_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_note_profil_profil1_idx` (`evalueur_id` ASC),
  INDEX `fk_note_profil_profil2_idx` (`profil_id` ASC),
  INDEX `fk_note_profil_projet1_idx` (`projet_id` ASC),
  CONSTRAINT `fk_note_profil_profil1`
    FOREIGN KEY (`evalueur_id`)
    REFERENCES `sicmi3a01_Banane`.`profil` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_note_profil_profil2`
    FOREIGN KEY (`profil_id`)
    REFERENCES `sicmi3a01_Banane`.`profil` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_note_profil_projet1`
    FOREIGN KEY (`projet_id`)
    REFERENCES `sicmi3a01_Banane`.`projet` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `sicmi3a01_Banane`.`profil`
-- -----------------------------------------------------
START TRANSACTION;
USE `sicmi3a01_Banane`;
INSERT INTO `sicmi3a01_Banane`.`profil` (`id`, `username`, `password`, `password_temp`, `email`, `prenom`, `nom`, `description`, `telephone`, `adresse`, `cp`, `pays`, `created_at`, `updated_at`, `fbid`, `gid`) VALUES (1, 'root', 'toor', NULL, 'root@sicmi3a01.cpnv-es.ch', 'root', 'root', 'super utilisateur', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `sicmi3a01_Banane`.`profil` (`id`, `username`, `password`, `password_temp`, `email`, `prenom`, `nom`, `description`, `telephone`, `adresse`, `cp`, `pays`, `created_at`, `updated_at`, `fbid`, `gid`) VALUES (2, 'thomas', 'thomas', NULL, 'thomas.ricci@cpnv.ch', 'thomas', 'ricci', 'Un des chef du projet Meet and Create/Banane', '0218454401', 'rue de l\'arcadie 47, Le sentier', '1347', 'suisse', NULL, NULL, NULL, NULL);
INSERT INTO `sicmi3a01_Banane`.`profil` (`id`, `username`, `password`, `password_temp`, `email`, `prenom`, `nom`, `description`, `telephone`, `adresse`, `cp`, `pays`, `created_at`, `updated_at`, `fbid`, `gid`) VALUES (3, 'eric', 'eric1234', NULL, 'eric.bousbaa@cpnv.ch', 'eric', 'bousbaa', 'Un des chef du projet Meet and Create/Banane', NULL, NULL, NULL, 'suisse', NULL, NULL, NULL, NULL);
INSERT INTO `sicmi3a01_Banane`.`profil` (`id`, `username`, `password`, `password_temp`, `email`, `prenom`, `nom`, `description`, `telephone`, `adresse`, `cp`, `pays`, `created_at`, `updated_at`, `fbid`, `gid`) VALUES (4, 'guillaume', 'guigui', NULL, 'guillaume.laubscher@cpnv.ch', 'guillaume', 'laubscher', 'Un des chef du projet Meet and Create/Banane', NULL, NULL, NULL, 'suisse', NULL, NULL, NULL, NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `sicmi3a01_Banane`.`projet`
-- -----------------------------------------------------
START TRANSACTION;
USE `sicmi3a01_Banane`;
INSERT INTO `sicmi3a01_Banane`.`projet` (`id`, `createur_id`, `publier`, `description`, `titre`, `debut`, `fin`, `created_at`, `updated_at`, `deleted_at`) VALUES (1, 2, 0, 'Projet du site complet. Celui-ci permet de s\'inscrire, avoir des projet, et un moteur de recherche simple pour trouver simplement les projet et profiles des personnes que vous voulez.', 'Meet and Create', 'CURDATE()', 'DATE_ADD(CURDATE(),INTERVAL \'1\' MONTH)', NULL, NULL, NULL);
INSERT INTO `sicmi3a01_Banane`.`projet` (`id`, `createur_id`, `publier`, `description`, `titre`, `debut`, `fin`, `created_at`, `updated_at`, `deleted_at`) VALUES (2, 2, 0, 'Un projet quelquonc', 'Projet 2', 'CURDATE()', 'DATE_ADD(CURDATE(),INTERVAL \'1\' MONTH)', NULL, NULL, NULL);
INSERT INTO `sicmi3a01_Banane`.`projet` (`id`, `createur_id`, `publier`, `description`, `titre`, `debut`, `fin`, `created_at`, `updated_at`, `deleted_at`) VALUES (3, 2, 0, 'Un projet quelquonc', 'Projet 3', 'CURDATE()', 'DATE_ADD(CURDATE(),INTERVAL \'1\' MONTH)', NULL, NULL, NULL);
INSERT INTO `sicmi3a01_Banane`.`projet` (`id`, `createur_id`, `publier`, `description`, `titre`, `debut`, `fin`, `created_at`, `updated_at`, `deleted_at`) VALUES (4, 2, 0, 'Un projet quelquonc', 'Projet 4', 'CURDATE()', 'DATE_ADD(CURDATE(),INTERVAL \'1\' MONTH)', NULL, NULL, NULL);
INSERT INTO `sicmi3a01_Banane`.`projet` (`id`, `createur_id`, `publier`, `description`, `titre`, `debut`, `fin`, `created_at`, `updated_at`, `deleted_at`) VALUES (5, 2, 0, 'Un projet quelquonc', 'Projet 5', 'CURDATE()', 'DATE_ADD(CURDATE(),INTERVAL \'1\' MONTH)', NULL, NULL, NULL);
INSERT INTO `sicmi3a01_Banane`.`projet` (`id`, `createur_id`, `publier`, `description`, `titre`, `debut`, `fin`, `created_at`, `updated_at`, `deleted_at`) VALUES (6, 2, 0, 'Un projet quelquonc', 'Projet 6', 'CURDATE()', 'DATE_ADD(CURDATE(),INTERVAL \'1\' MONTH)', NULL, NULL, NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `sicmi3a01_Banane`.`candidat_projet`
-- -----------------------------------------------------
START TRANSACTION;
USE `sicmi3a01_Banane`;
INSERT INTO `sicmi3a01_Banane`.`candidat_projet` (`id`, `profil_id`, `projet_id`, `suggereur_id`, `etat_candidature`, `etat_proposition`, `created_at`, `updated_at`, `deleted_at`) VALUES (1, 1, 1, NULL, 1, 1, 'NOW()', 'NOW()', NULL);
INSERT INTO `sicmi3a01_Banane`.`candidat_projet` (`id`, `profil_id`, `projet_id`, `suggereur_id`, `etat_candidature`, `etat_proposition`, `created_at`, `updated_at`, `deleted_at`) VALUES (2, 1, 2, NULL, NULL, 1, 'NOW()', 'NOW()', NULL);
INSERT INTO `sicmi3a01_Banane`.`candidat_projet` (`id`, `profil_id`, `projet_id`, `suggereur_id`, `etat_candidature`, `etat_proposition`, `created_at`, `updated_at`, `deleted_at`) VALUES (3, 1, 3, 2, 1, NULL, 'NOW()', 'NOW()', NULL);
INSERT INTO `sicmi3a01_Banane`.`candidat_projet` (`id`, `profil_id`, `projet_id`, `suggereur_id`, `etat_candidature`, `etat_proposition`, `created_at`, `updated_at`, `deleted_at`) VALUES (4, 1, 4, 3, NULL, NULL, 'NOW()', 'NOW()', NULL);
INSERT INTO `sicmi3a01_Banane`.`candidat_projet` (`id`, `profil_id`, `projet_id`, `suggereur_id`, `etat_candidature`, `etat_proposition`, `created_at`, `updated_at`, `deleted_at`) VALUES (5, 1, 5, 1, 1, NULL, 'NOW()', 'NOW()', NULL);
INSERT INTO `sicmi3a01_Banane`.`candidat_projet` (`id`, `profil_id`, `projet_id`, `suggereur_id`, `etat_candidature`, `etat_proposition`, `created_at`, `updated_at`, `deleted_at`) VALUES (6, 1, 6, NULL, 1, 1, 'NOW()', 'NOW()', NULL);
INSERT INTO `sicmi3a01_Banane`.`candidat_projet` (`id`, `profil_id`, `projet_id`, `suggereur_id`, `etat_candidature`, `etat_proposition`, `created_at`, `updated_at`, `deleted_at`) VALUES (NULL, 2, 1, 1, 1, 1, NULL, NULL, NULL);
INSERT INTO `sicmi3a01_Banane`.`candidat_projet` (`id`, `profil_id`, `projet_id`, `suggereur_id`, `etat_candidature`, `etat_proposition`, `created_at`, `updated_at`, `deleted_at`) VALUES (NULL, 2, 2, 1, 1, 1, NULL, NULL, NULL);
INSERT INTO `sicmi3a01_Banane`.`candidat_projet` (`id`, `profil_id`, `projet_id`, `suggereur_id`, `etat_candidature`, `etat_proposition`, `created_at`, `updated_at`, `deleted_at`) VALUES (NULL, 2, 3, NULL, 1, 1, NULL, NULL, NULL);
INSERT INTO `sicmi3a01_Banane`.`candidat_projet` (`id`, `profil_id`, `projet_id`, `suggereur_id`, `etat_candidature`, `etat_proposition`, `created_at`, `updated_at`, `deleted_at`) VALUES (NULL, 2, 4, 1, 1, 1, NULL, NULL, NULL);
INSERT INTO `sicmi3a01_Banane`.`candidat_projet` (`id`, `profil_id`, `projet_id`, `suggereur_id`, `etat_candidature`, `etat_proposition`, `created_at`, `updated_at`, `deleted_at`) VALUES (NULL, 2, 5, 1, 1, 1, NULL, NULL, NULL);
INSERT INTO `sicmi3a01_Banane`.`candidat_projet` (`id`, `profil_id`, `projet_id`, `suggereur_id`, `etat_candidature`, `etat_proposition`, `created_at`, `updated_at`, `deleted_at`) VALUES (NULL, 2, 6, NULL, 1, NULL, NULL, NULL, NULL);
INSERT INTO `sicmi3a01_Banane`.`candidat_projet` (`id`, `profil_id`, `projet_id`, `suggereur_id`, `etat_candidature`, `etat_proposition`, `created_at`, `updated_at`, `deleted_at`) VALUES (NULL, 3, 1, NULL, 1, 1, NULL, NULL, NULL);
INSERT INTO `sicmi3a01_Banane`.`candidat_projet` (`id`, `profil_id`, `projet_id`, `suggereur_id`, `etat_candidature`, `etat_proposition`, `created_at`, `updated_at`, `deleted_at`) VALUES (NULL, 4, 1, NULL, 1, 1, NULL, NULL, NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `sicmi3a01_Banane`.`profil_favori`
-- -----------------------------------------------------
START TRANSACTION;
USE `sicmi3a01_Banane`;
INSERT INTO `sicmi3a01_Banane`.`profil_favori` (`profil_id`, `favori_id`) VALUES (1, 2);

COMMIT;


-- -----------------------------------------------------
-- Data for table `sicmi3a01_Banane`.`projet_favori`
-- -----------------------------------------------------
START TRANSACTION;
USE `sicmi3a01_Banane`;
INSERT INTO `sicmi3a01_Banane`.`projet_favori` (`projet_id`, `profile_id`) VALUES (1, 1);

COMMIT;


-- -----------------------------------------------------
-- Data for table `sicmi3a01_Banane`.`tag`
-- -----------------------------------------------------
START TRANSACTION;
USE `sicmi3a01_Banane`;
INSERT INTO `sicmi3a01_Banane`.`tag` (`id`, `nom`, `description`) VALUES (NULL, 'design', 'orienté dans les textures');
INSERT INTO `sicmi3a01_Banane`.`tag` (`id`, `nom`, `description`) VALUES (NULL, 'web', 'orienté web');
INSERT INTO `sicmi3a01_Banane`.`tag` (`id`, `nom`, `description`) VALUES (NULL, 'application', 'orianté application');
INSERT INTO `sicmi3a01_Banane`.`tag` (`id`, `nom`, `description`) VALUES (NULL, 'artisanat', 'artisanant');

COMMIT;


-- -----------------------------------------------------
-- Data for table `sicmi3a01_Banane`.`competence`
-- -----------------------------------------------------
START TRANSACTION;
USE `sicmi3a01_Banane`;
INSERT INTO `sicmi3a01_Banane`.`competence` (`id`, `competence`, `description`) VALUES (NULL, 'php', 'language descript. Orienté Web/Script');
INSERT INTO `sicmi3a01_Banane`.`competence` (`id`, `competence`, `description`) VALUES (NULL, 'python', 'language de script. Orienté Web/Script');
INSERT INTO `sicmi3a01_Banane`.`competence` (`id`, `competence`, `description`) VALUES (NULL, 'javascript', 'language de script. Orienté Web/Script');
INSERT INTO `sicmi3a01_Banane`.`competence` (`id`, `competence`, `description`) VALUES (NULL, 'c++', 'language de bas niveau. Lnaguage orienté objet');
INSERT INTO `sicmi3a01_Banane`.`competence` (`id`, `competence`, `description`) VALUES (NULL, 'c', 'language de base. Utilisé presque partout');
INSERT INTO `sicmi3a01_Banane`.`competence` (`id`, `competence`, `description`) VALUES (NULL, 'java', 'language d eprogrammation orienté application');
INSERT INTO `sicmi3a01_Banane`.`competence` (`id`, `competence`, `description`) VALUES (NULL, 'mysql', 'language de gestion e base de données');

COMMIT;


-- -----------------------------------------------------
-- Data for table `sicmi3a01_Banane`.`tag_projet`
-- -----------------------------------------------------
START TRANSACTION;
USE `sicmi3a01_Banane`;
INSERT INTO `sicmi3a01_Banane`.`tag_projet` (`tag_id`, `projet_id`) VALUES (2, 1);

COMMIT;


-- -----------------------------------------------------
-- Data for table `sicmi3a01_Banane`.`profil_competence`
-- -----------------------------------------------------
START TRANSACTION;
USE `sicmi3a01_Banane`;
INSERT INTO `sicmi3a01_Banane`.`profil_competence` (`profil_id`, `competence_id`, `niveau`) VALUES (1, 1, 2);
INSERT INTO `sicmi3a01_Banane`.`profil_competence` (`profil_id`, `competence_id`, `niveau`) VALUES (1, 2, 2);
INSERT INTO `sicmi3a01_Banane`.`profil_competence` (`profil_id`, `competence_id`, `niveau`) VALUES (1, 3, 3);
INSERT INTO `sicmi3a01_Banane`.`profil_competence` (`profil_id`, `competence_id`, `niveau`) VALUES (1, 4, 2);

COMMIT;

