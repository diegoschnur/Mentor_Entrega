-- MySQL Script generated by MySQL Workbench
-- 06/12/17 22:58:58
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema db_mentor
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema db_mentor
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `db_mentor` DEFAULT CHARACTER SET utf8 ;
USE `db_mentor` ;

-- -----------------------------------------------------
-- Table `db_mentor`.`tbl_perfis`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_mentor`.`tbl_perfis` (
  `id_pf` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome_pf` VARCHAR(50) CHARACTER SET 'utf8' NOT NULL,
  `permissao_relator_us` INT(11) NULL DEFAULT NULL,
  `permissao_Grelator_us` INT(11) NULL DEFAULT NULL,
  `permissao_desenvolvedor_us` INT(11) NULL DEFAULT NULL,
  `permissao_Gdesenvolvedor_us` INT(11) NULL DEFAULT NULL,
  `permissao_secretario_us` INT(11) NULL DEFAULT NULL,
  `permissao_visualizador_us` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id_pf`),
  UNIQUE INDEX `nome_pf_UNIQUE` (`nome_pf` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 8
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin;


-- -----------------------------------------------------
-- Table `db_mentor`.`tbl_usuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_mentor`.`tbl_usuarios` (
  `id_us` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome_us` VARCHAR(45) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `email_us` VARCHAR(60) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `login_us` VARCHAR(15) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `senha_us` VARCHAR(45) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `status_us` VARCHAR(10) CHARACTER SET 'utf8' NULL DEFAULT 'Inativo',
  `perfil_us` INT(10) UNSIGNED NULL DEFAULT '6',
  PRIMARY KEY (`id_us`),
  INDEX `fk_usuarioPerfil_idx` (`perfil_us` ASC),
  CONSTRAINT `fk_usuarioPerfil`
    FOREIGN KEY (`perfil_us`)
    REFERENCES `db_mentor`.`tbl_perfis` (`id_pf`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 10
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin;


-- -----------------------------------------------------
-- Table `db_mentor`.`tbl_projetos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_mentor`.`tbl_projetos` (
  `id_prj` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome_prj` VARCHAR(70) CHARACTER SET 'utf8' NOT NULL,
  `descricao_prj` VARCHAR(200) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `status_prj` VARCHAR(10) CHARACTER SET 'utf8' NOT NULL DEFAULT 'Inativo',
  `id_usuario_prj` INT(10) UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`id_prj`),
  UNIQUE INDEX `nome_projeto_UNIQUE` (`nome_prj` ASC),
  INDEX `fk_usuario_projeto_idx` (`id_usuario_prj` ASC),
  CONSTRAINT `fk_usuario_projeto`
    FOREIGN KEY (`id_usuario_prj`)
    REFERENCES `db_mentor`.`tbl_usuarios` (`id_us`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 94
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin;


-- -----------------------------------------------------
-- Table `db_mentor`.`tbl_solicitacoes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_mentor`.`tbl_solicitacoes` (
  `id_sol` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome_sol` VARCHAR(50) CHARACTER SET 'utf8' NOT NULL,
  `dataAbertura_sol` DATE NOT NULL,
  `dataNecessidade_sol` DATE NULL DEFAULT NULL,
  `tempoTeste_sol` INT(11) NULL DEFAULT NULL,
  `unidadeMedida_sol` CHAR(2) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `componentesTestar_sol` MEDIUMTEXT CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `metodologia_sol` MEDIUMTEXT CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `observacoes_sol` MEDIUMTEXT CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `visibilidade_sol` VARCHAR(10) CHARACTER SET 'utf8' NULL DEFAULT 'Privado',
  `status_sol` VARCHAR(15) CHARACTER SET 'utf8' NULL DEFAULT 'Nova',
  `idProjeto_sol` INT(10) UNSIGNED NOT NULL,
  `idUsuario_sol` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_sol`),
  UNIQUE INDEX `nome_sol_UNIQUE` (`nome_sol` ASC),
  INDEX `fk_idprojeto_idx` (`idProjeto_sol` ASC),
  INDEX `fk_idusuario_usuario_idx` (`idUsuario_sol` ASC),
  CONSTRAINT `fk_solicitacao_projeto`
    FOREIGN KEY (`idProjeto_sol`)
    REFERENCES `db_mentor`.`tbl_projetos` (`id_prj`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_solicitacao_usuario`
    FOREIGN KEY (`idUsuario_sol`)
    REFERENCES `db_mentor`.`tbl_usuarios` (`id_us`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 25
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin;


-- -----------------------------------------------------
-- Table `db_mentor`.`tbl_fichastecnicas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_mentor`.`tbl_fichastecnicas` (
  `id_ft` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome_ft` VARCHAR(50) NOT NULL,
  `dataInicial_ft` DATE NULL DEFAULT NULL,
  `dataFinal_ft` DATE NULL DEFAULT NULL,
  `tempoTeste_ft` INT(11) NULL DEFAULT NULL,
  `localTeste_ft` VARCHAR(50) NULL DEFAULT NULL,
  `cliente_ft` VARCHAR(50) NULL DEFAULT NULL,
  `acompanhamento_ft` VARCHAR(50) NULL DEFAULT NULL,
  `componentes_ft` MEDIUMTEXT NULL DEFAULT NULL,
  `metodologia_ft` MEDIUMTEXT NULL DEFAULT NULL,
  `comportamento_ft` LONGTEXT NULL DEFAULT NULL,
  `observacoes_ft` MEDIUMTEXT NULL DEFAULT NULL,
  `visibilidade_ft` VARCHAR(10) NULL DEFAULT 'Privado',
  `destaque_ft` ENUM('S', 'N') NULL DEFAULT 'N',
  `status_ft` VARCHAR(10) NULL DEFAULT 'Nova',
  `id_solicitacao_ft` INT(10) UNSIGNED NULL DEFAULT NULL,
  `id_usuario_ft` INT(10) UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`id_ft`),
  INDEX `nome_ft_UNIQUE` (`nome_ft` ASC),
  INDEX `fk_idSolicitacao_sol_idx` (`id_solicitacao_ft` ASC),
  INDEX `fk_usuario_fichatecnica_idx` (`id_usuario_ft` ASC),
  CONSTRAINT `fk_solicitacao_fichatecnica`
    FOREIGN KEY (`id_solicitacao_ft`)
    REFERENCES `db_mentor`.`tbl_solicitacoes` (`id_sol`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_fichatecnica`
    FOREIGN KEY (`id_usuario_ft`)
    REFERENCES `db_mentor`.`tbl_usuarios` (`id_us`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 19
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `db_mentor`.`tbl_relatorios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_mentor`.`tbl_relatorios` (
  `id_rl` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_solicitacao_rl` INT(10) UNSIGNED NULL DEFAULT NULL,
  `obsRelator_rl` VARCHAR(200) NULL DEFAULT NULL,
  `obsDesenvolvedor_rl` VARCHAR(200) NULL DEFAULT NULL,
  `statusRelator_rl` VARCHAR(15) NULL DEFAULT NULL,
  `statusDesenvolvedor_rl` VARCHAR(15) NULL DEFAULT NULL,
  `id_usuario_rel` INT(10) UNSIGNED NULL DEFAULT NULL,
  `id_usuario_sol` INT(10) UNSIGNED NULL DEFAULT NULL,
  `dataEncerramento_rl` DATE NULL DEFAULT NULL,
  PRIMARY KEY (`id_rl`),
  INDEX `fk_idSolicitacao_rel_idx` (`id_solicitacao_rl` ASC),
  CONSTRAINT `fk_solicitacao_relatorio`
    FOREIGN KEY (`id_solicitacao_rl`)
    REFERENCES `db_mentor`.`tbl_solicitacoes` (`id_sol`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 52
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
