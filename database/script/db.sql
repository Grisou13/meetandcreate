SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

DROP SCHEMA IF EXISTS `projet_stage` ;
CREATE SCHEMA IF NOT EXISTS `projet_stage` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `projet_stage` ;

-- -----------------------------------------------------
-- Table `projet_stage`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `projet_stage`.`users` ;

CREATE TABLE IF NOT EXISTS `projet_stage`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT 'increment ID for the user',
  `git_id` VARCHAR(60) NULL COMMENT 'Id retrieved from github authentification',
  `fb_id` VARCHAR(60) NULL COMMENT 'Id retrieved from FaceBook authentification',
  `g_id` VARCHAR(60) NULL COMMENT 'Id retrieved from google+ authentification',
  `username` VARCHAR(45) NOT NULL,
  `password` VARCHAR(60) NOT NULL,
  `password_temp` VARCHAR(60) NULL COMMENT 'password temporary field, utilisied for password recovery',
  `email` VARCHAR(255) NULL,
  `email_verified` TINYINT(1) NULL,
  `email_code` VARCHAR(60) NULL,
  `remember_token` VARCHAR(255) NULL,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  `deleted_at` DATETIME NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `projet_stage`.`profils`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `projet_stage`.`profils` ;

CREATE TABLE IF NOT EXISTS `projet_stage`.`profils` (
  `id` INT NOT NULL,
  `users_id` INT NOT NULL,
  `descirption` TEXT NULL,
  `displayname` VARCHAR(45) NULL,
  `summary` TEXT NULL,
  `private` TINYINT(1) NULL COMMENT 'defines if the user wants his information viewed by others',
  `email` VARCHAR(255) NULL,
  `created_at` DATETIME NULL,
  `deleted_at` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_profils_users1_idx` (`users_id` ASC),
  CONSTRAINT `fk_profils_users1`
    FOREIGN KEY (`users_id`)
    REFERENCES `projet_stage`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `projet_stage`.`projects`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `projet_stage`.`projects` ;

CREATE TABLE IF NOT EXISTS `projet_stage`.`projects` (
  `id` INT NOT NULL,
  `title` VARCHAR(45) NULL,
  `description` VARCHAR(45) NULL,
  `end_date` VARCHAR(45) NULL,
  `start_date` VARCHAR(45) NULL,
  `version` VARCHAR(45) NULL,
  `website` VARCHAR(45) NULL,
  `slug` VARCHAR(45) NULL,
  `progress` VARCHAR(45) NULL,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  `deleted_at` DATETIME NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `projet_stage`.`project_members`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `projet_stage`.`project_members` ;

CREATE TABLE IF NOT EXISTS `projet_stage`.`project_members` (
  `id` INT NOT NULL,
  `suggestion_id` INT NOT NULL COMMENT 'Id de la personne qui suggère la personne dans le projet',
  `profils_id` INT NOT NULL,
  `projects_id` INT NOT NULL,
  `is_accepted_by_project_admin` TINYINT(1) NULL,
  `is_accepted_by_user` TINYINT(1) NULL,
  `reason` TEXT NULL,
  `created_at` DATETIME NULL,
  `deleted_at` DATETIME NULL,
  PRIMARY KEY (`id`, `profils_id`, `projects_id`),
  INDEX `fk_project_members_profils1_idx` (`profils_id` ASC),
  INDEX `fk_project_members_projects1_idx` (`projects_id` ASC),
  INDEX `fk_project_members_profils2_idx` (`suggestion_id` ASC),
  CONSTRAINT `fk_project_members_profils1`
    FOREIGN KEY (`profils_id`)
    REFERENCES `projet_stage`.`profils` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_project_members_projects1`
    FOREIGN KEY (`projects_id`)
    REFERENCES `projet_stage`.`projects` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_project_members_profils2`
    FOREIGN KEY (`suggestion_id`)
    REFERENCES `projet_stage`.`profils` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `projet_stage`.`permissions`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `projet_stage`.`permissions` ;

CREATE TABLE IF NOT EXISTS `projet_stage`.`permissions` (
  `id` INT NOT NULL,
  `name` VARCHAR(255) NULL,
  `description` TEXT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `projet_stage`.`roles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `projet_stage`.`roles` ;

CREATE TABLE IF NOT EXISTS `projet_stage`.`roles` (
  `id` INT NOT NULL,
  `name` VARCHAR(45) NULL,
  `onwer_type` VARCHAR(45) NOT NULL,
  `owner_id` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_roles_profils1_idx` (`owner_id` ASC),
  CONSTRAINT `fk_roles_profils1`
    FOREIGN KEY (`owner_id`)
    REFERENCES `projet_stage`.`profils` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_roles_project_members1`
    FOREIGN KEY (`id`)
    REFERENCES `projet_stage`.`project_members` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `projet_stage`.`role_permissions`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `projet_stage`.`role_permissions` ;

CREATE TABLE IF NOT EXISTS `projet_stage`.`role_permissions` (
  `permissions_id` INT NOT NULL,
  `roles_id` INT NOT NULL,
  PRIMARY KEY (`permissions_id`, `roles_id`),
  INDEX `fk_permissions_has_roles_roles1_idx` (`roles_id` ASC),
  INDEX `fk_permissions_has_roles_permissions_idx` (`permissions_id` ASC),
  CONSTRAINT `fk_permissions_has_roles_permissions`
    FOREIGN KEY (`permissions_id`)
    REFERENCES `projet_stage`.`permissions` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_permissions_has_roles_roles1`
    FOREIGN KEY (`roles_id`)
    REFERENCES `projet_stage`.`roles` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `projet_stage`.`files`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `projet_stage`.`files` ;

CREATE TABLE IF NOT EXISTS `projet_stage`.`files` (
  `id` INT NOT NULL,
  `filename` VARCHAR(255) NULL COMMENT 'name fo the uploaded file',
  `path` TEXT NULL COMMENT 'Complete path to the file',
  `owner_type` VARCHAR(255) NOT NULL COMMENT 'Type of the owner used by polymorphic relations in Eloquent',
  `owner_id` INT NOT NULL,
  `mime` VARCHAR(255) NULL,
  `extension` VARCHAR(45) NULL,
  `size` VARCHAR(255) NULL,
  `created_at` DATETIME NULL,
  `profils_id` INT NOT NULL,
  PRIMARY KEY (`id`, `owner_id`),
  INDEX `fk_files_profils1_idx` (`owner_id` ASC),
  INDEX `fk_files_profils2_idx` (`profils_id` ASC),
  CONSTRAINT `fk_files_profils1`
    FOREIGN KEY (`owner_id`)
    REFERENCES `projet_stage`.`profils` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_files_projects1`
    FOREIGN KEY (`owner_id`)
    REFERENCES `projet_stage`.`projects` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_files_profils2`
    FOREIGN KEY (`profils_id`)
    REFERENCES `projet_stage`.`profils` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `projet_stage`.`messages`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `projet_stage`.`messages` ;

CREATE TABLE IF NOT EXISTS `projet_stage`.`messages` (
  `title` VARCHAR(45) NULL,
  `body` VARCHAR(45) NULL,
  `status` VARCHAR(45) NULL,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  `profils_id` INT NOT NULL,
  `destination_id` INT NOT NULL,
  INDEX `fk_messages_profils1_idx` (`profils_id` ASC),
  INDEX `fk_messages_profils2_idx` (`destination_id` ASC),
  CONSTRAINT `fk_messages_profils1`
    FOREIGN KEY (`profils_id`)
    REFERENCES `projet_stage`.`profils` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_messages_profils2`
    FOREIGN KEY (`destination_id`)
    REFERENCES `projet_stage`.`profils` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `projet_stage`.`chat_log`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `projet_stage`.`chat_log` ;

CREATE TABLE IF NOT EXISTS `projet_stage`.`chat_log` (
  `id` INT NOT NULL,
  `log` VARCHAR(45) NULL,
  `created_at` DATETIME NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `projet_stage`.`notification_types`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `projet_stage`.`notification_types` ;

CREATE TABLE IF NOT EXISTS `projet_stage`.`notification_types` (
  `id` INT NOT NULL,
  `body` TEXT NULL,
  `title` VARCHAR(255) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `projet_stage`.`notifications`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `projet_stage`.`notifications` ;

CREATE TABLE IF NOT EXISTS `projet_stage`.`notifications` (
  `id` INT NOT NULL,
  `text` TEXT NULL,
  `notification_types_id` INT NOT NULL,
  `profils_id` INT NOT NULL,
  `created_at` DATETIME NULL,
  `update_at` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_notifications_notification_type1_idx` (`notification_types_id` ASC),
  INDEX `fk_notifications_profils1_idx` (`profils_id` ASC),
  CONSTRAINT `fk_notifications_notification_type1`
    FOREIGN KEY (`notification_types_id`)
    REFERENCES `projet_stage`.`notification_types` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_notifications_profils1`
    FOREIGN KEY (`profils_id`)
    REFERENCES `projet_stage`.`profils` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `projet_stage`.`user_friends`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `projet_stage`.`user_friends` ;

CREATE TABLE IF NOT EXISTS `projet_stage`.`user_friends` (
  `status` VARCHAR(45) NULL COMMENT 'Define the status, if it\'s pending, refused or accepted',
  `friend_id` INT NOT NULL,
  `profils_id` INT NOT NULL,
  INDEX `fk_user_friends_profils1_idx` (`profils_id` ASC),
  INDEX `fk_user_friends_profils2_idx` (`friend_id` ASC),
  CONSTRAINT `fk_user_friends_profils1`
    FOREIGN KEY (`profils_id`)
    REFERENCES `projet_stage`.`profils` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_friends_profils2`
    FOREIGN KEY (`friend_id`)
    REFERENCES `projet_stage`.`profils` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `projet_stage`.`tags`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `projet_stage`.`tags` ;

CREATE TABLE IF NOT EXISTS `projet_stage`.`tags` (
  `id` INT NOT NULL,
  `name` VARCHAR(255) NULL,
  `description` TEXT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `projet_stage`.`project_tags`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `projet_stage`.`project_tags` ;

CREATE TABLE IF NOT EXISTS `projet_stage`.`project_tags` (
  `projects_id` INT NOT NULL,
  `tags_id` INT NOT NULL,
  PRIMARY KEY (`projects_id`, `tags_id`),
  INDEX `fk_projects_has_tags_tags1_idx` (`tags_id` ASC),
  INDEX `fk_projects_has_tags_projects1_idx` (`projects_id` ASC),
  CONSTRAINT `fk_projects_has_tags_projects1`
    FOREIGN KEY (`projects_id`)
    REFERENCES `projet_stage`.`projects` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_projects_has_tags_tags1`
    FOREIGN KEY (`tags_id`)
    REFERENCES `projet_stage`.`tags` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `projet_stage`.`skills`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `projet_stage`.`skills` ;

CREATE TABLE IF NOT EXISTS `projet_stage`.`skills` (
  `id` INT NOT NULL,
  `name` VARCHAR(45) NULL,
  `level` VARCHAR(1) NULL,
  `owner_type` VARCHAR(255) NULL,
  `onwer_id` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_skills_profils1_idx` (`onwer_id` ASC),
  CONSTRAINT `fk_skills_profils1`
    FOREIGN KEY (`onwer_id`)
    REFERENCES `projet_stage`.`profils` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_skills_projects1`
    FOREIGN KEY (`onwer_id`)
    REFERENCES `projet_stage`.`projects` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `projet_stage`.`password_resets`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `projet_stage`.`password_resets` ;

CREATE TABLE IF NOT EXISTS `projet_stage`.`password_resets` (
  `email` VARCHAR(45) NULL,
  `token` VARCHAR(45) NULL,
  `created_at` DATETIME NULL,
  `users_id` INT NOT NULL,
  INDEX `fk_password_resets_users1_idx` (`users_id` ASC),
  CONSTRAINT `fk_password_resets_users1`
    FOREIGN KEY (`users_id`)
    REFERENCES `projet_stage`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `projet_stage`.`status`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `projet_stage`.`status` ;

CREATE TABLE IF NOT EXISTS `projet_stage`.`status` (
  `id` INT NOT NULL,
  `name` VARCHAR(255) NULL COMMENT 'visual name of the status',
  `description` TEXT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `projet_stage`.`project_status`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `projet_stage`.`project_status` ;

CREATE TABLE IF NOT EXISTS `projet_stage`.`project_status` (
  `projects_id` INT NOT NULL,
  `status_id` INT NOT NULL,
  `pourcent_progress` VARCHAR(2) NULL,
  `date` DATE NULL,
  PRIMARY KEY (`projects_id`, `status_id`),
  INDEX `fk_projects_has_status_status1_idx` (`status_id` ASC),
  INDEX `fk_projects_has_status_projects1_idx` (`projects_id` ASC),
  CONSTRAINT `fk_projects_has_status_projects1`
    FOREIGN KEY (`projects_id`)
    REFERENCES `projet_stage`.`projects` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_projects_has_status_status1`
    FOREIGN KEY (`status_id`)
    REFERENCES `projet_stage`.`status` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `projet_stage`.`rattings`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `projet_stage`.`rattings` ;

CREATE TABLE IF NOT EXISTS `projet_stage`.`rattings` (
  `id` INT NOT NULL,
  `rattable_type` VARCHAR(255) NULL,
  `rattable_id` INT NULL,
  `rate` VARCHAR(2) NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_rattings_profils1_idx` (`rattable_id` ASC),
  CONSTRAINT `fk_rattings_profils1`
    FOREIGN KEY (`rattable_id`)
    REFERENCES `projet_stage`.`profils` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_rattings_project_members1`
    FOREIGN KEY (`rattable_id`)
    REFERENCES `projet_stage`.`project_members` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_rattings_projects1`
    FOREIGN KEY (`rattable_id`)
    REFERENCES `projet_stage`.`projects` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
