-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema recuperacao
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema recuperacao
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `recuperacao` DEFAULT CHARACTER SET utf8 ;
USE `recuperacao` ;

-- -----------------------------------------------------
-- Table `recuperacao`.`tabuleiro`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `recuperacao`.`tabuleiro` (
  `idtabuleiro` INT NOT NULL AUTO_INCREMENT,
  `lado` INT NULL,
  PRIMARY KEY (`idtabuleiro`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `recuperacao`.`quadrado`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `recuperacao`.`quadrado` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `lado` INT NULL,
  `cor` VARCHAR(45) NULL,
  `idtabuleiro` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_quadrado_tabuleiro_idx` (`idtabuleiro` ASC),
  CONSTRAINT `fk_quadrado_tabuleiro`
    FOREIGN KEY (`idtabuleiro`)
    REFERENCES `recuperacao`.`tabuleiro` (`idtabuleiro`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `recuperacao`.`retangulo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `recuperacao`.`retangulo` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `altura` INT NULL,
  `base` INT NULL,
  `cor` VARCHAR(45) NULL,
  `idtabuleiro` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_ratangulo_tabuleiro_idx` (`idtabuleiro` ASC),
  CONSTRAINT `fk_ratangulo_tabuleiro`
    FOREIGN KEY (`idtabuleiro`)
    REFERENCES `recuperacao`.`tabuleiro` (`idtabuleiro`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `recuperacao`.`triangulo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `recuperacao`.`triangulo` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `lado1` INT NULL,
  `lado2` INT NULL,
  `lado3` INT NULL,
  `cor` VARCHAR(45) NULL,
  `idtabuleiro` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_triangulo_tabuleiro_idx` (`idtabuleiro` ASC),
  CONSTRAINT `fk_triangulo_tabuleiro`
    FOREIGN KEY (`idtabuleiro`)
    REFERENCES `recuperacao`.`tabuleiro` (`idtabuleiro`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `recuperacao`.`circulo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `recuperacao`.`circulo` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `raio` INT NULL,
  `cor` VARCHAR(45) NULL,
  `idtabuleiro` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_circulo_tabuleiro_idx` (`idtabuleiro` ASC),
  CONSTRAINT `fk_circulo_tabuleiro`
    FOREIGN KEY (`idtabuleiro`)
    REFERENCES `recuperacao`.`tabuleiro` (`idtabuleiro`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `recuperacao`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `recuperacao`.`usuario` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(250) NULL,
  `login` VARCHAR(45) NULL,
  `senha` VARCHAR(250) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `recuperacao`.`cubo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `recuperacao`.`cubo` (
  `idcubo` INT NOT NULL AUTO_INCREMENT,
  `cor` VARCHAR(45) NULL,
  `idquadrado` INT NOT NULL,
  PRIMARY KEY (`idcubo`),
  CONSTRAINT `fk_cubo_quadrado`
    FOREIGN KEY (`idquadrado`)
    REFERENCES `recuperacao`.`quadrado` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
