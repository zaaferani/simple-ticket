-- MySQL Workbench Synchronization
-- Generated: 2018-12-22 16:00
-- Model: New Model
-- Version: 1.0
-- Project: Name of the project
-- Author: Administrator

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

CREATE SCHEMA IF NOT EXISTS `simple_ticket` DEFAULT CHARACTER SET utf8 ;

CREATE TABLE IF NOT EXISTS `simple_ticket`.`users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(32) NOT NULL,
  `password` VARCHAR(100) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `name` VARCHAR(100) NULL DEFAULT NULL,
  `family` VARCHAR(100) NULL DEFAULT NULL,
  `sex` ENUM('M', 'F', 'U') NOT NULL DEFAULT 'U',
  `type` ENUM('ADMIN', 'EXPERT', 'USER') NOT NULL DEFAULT 'USER',
  `image` VARCHAR(255) NULL DEFAULT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `username_UNIQUE` (`username` ASC),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `simple_ticket`.`tickets` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `title` TEXT NULL DEFAULT NULL,
  `description` MEDIUMTEXT NULL DEFAULT NULL,
  `attachment` VARCHAR(100) NULL DEFAULT NULL,
  `status` ENUM('OPEN', 'CLOSE') NOT NULL DEFAULT 'OPEn',
  `assignee` INT(11) NULL DEFAULT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `fk_tickets_users_idx` (`user_id` ASC),
  INDEX `fk_tickets_users1_idx` (`assignee` ASC),
  CONSTRAINT `fk_tickets_users`
    FOREIGN KEY (`user_id`)
    REFERENCES `simple_ticket`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tickets_users1`
    FOREIGN KEY (`assignee`)
    REFERENCES `simple_ticket`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `simple_ticket`.`ticket_logs` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `ticket_id` INT(11) NULL DEFAULT NULL,
  `act` ENUM('REPLY', 'EVENT') NOT NULL DEFAULT 'REPLY',
  `description` MEDIUMTEXT NULL DEFAULT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `fk_ticket_logs_users1_idx` (`user_id` ASC),
  INDEX `fk_ticket_logs_tickets1_idx` (`ticket_id` ASC),
  CONSTRAINT `fk_ticket_logs_tickets1`
    FOREIGN KEY (`ticket_id`)
    REFERENCES `simple_ticket`.`tickets` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ticket_logs_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `simple_ticket`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

INSERT INTO users (username, password, email, type) VALUES ('admin', 'admin', 'admin@admin.com', 'ADMIN');

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

