SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `malha` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `malha` ;

-- -----------------------------------------------------
-- Table `malha`.`teams`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `malha`.`teams` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  `member1` VARCHAR(45) NOT NULL ,
  `member2` VARCHAR(45) NOT NULL ,
  `active` TINYINT NOT NULL DEFAULT '1' ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `name_UNIQUE` (`name` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `malha`.`game`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `malha`.`game` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `team1` INT NOT NULL ,
  `team2` INT NOT NULL ,
  `step` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `team1_idx` (`team1` ASC) ,
  INDEX `team2_idx` (`team2` ASC) ,
  CONSTRAINT `team1`
    FOREIGN KEY (`team1` )
    REFERENCES `malha`.`teams` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `team2`
    FOREIGN KEY (`team2` )
    REFERENCES `malha`.`teams` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `malha`.`game_has_matchs`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `malha`.`game_has_matchs` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `game_id` INT NOT NULL ,
  `score1` INT NOT NULL DEFAULT 0 ,
  `score2` INT NOT NULL DEFAULT 0 ,
  `match` INT NOT NULL DEFAULT 1 ,
  PRIMARY KEY (`id`) ,
  INDEX `game_id_idx` (`game_id` ASC) ,
  CONSTRAINT `game_id`
    FOREIGN KEY (`game_id` )
    REFERENCES `malha`.`game` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

USE `malha` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

