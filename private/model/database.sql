CREATE DATABASE IF NOT EXISTS `cmsFun` 
DEFAULT CHARACTER SET utf8mb4 
COLLATE utf8mb4_general_ci;
USE `cmsFun`;

CREATE TABLE IF NOT EXISTS `Framework` (
  `id`                int(11)         NOT NULL AUTO_INCREMENT,
  `step`              int(11)         NOT NULL,
  `sequence`          varchar(190)    NOT NULL,
  `pool`              varchar(190)    NOT NULL,
  `method`            varchar(190)    NOT NULL,
  `param`             varchar(190)    NOT NULL,
  `code`              text            NOT NULL,
  `level`             int(11)         NOT NULL,
  `cle`               varchar(190)    NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;



CREATE TABLE IF NOT EXISTS `User` (
  `id`        int(11)         NOT NULL AUTO_INCREMENT,
  `nom`       varchar(200)    NOT NULL,
  `email`     varchar(200)    NOT NULL,
  `password`  varchar(200)    NOT NULL,
  `level`     int(11)         NOT NULL,
  `date`      datetime        NOT NULL,
  `ip`        varchar(200)    NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE `email` (email(190))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `Page` (
  `id`          int(11)         NOT NULL AUTO_INCREMENT,
  `dataType`    varchar(190)    NOT NULL,
  `category`    varchar(190)    NOT NULL,
  `titre`       varchar(190)    NOT NULL,
  `urlPage`     varchar(190),
  `contenu`     text            NOT NULL,
  `urlImage`    varchar(190)    NOT NULL,
  `template`    varchar(190)    NOT NULL,
  `level`       int(11)         NOT NULL,
  `date`        datetime        NOT NULL,
  `priority`       int(11)         NOT NULL,
  `description` varchar(190)    NOT NULL,
  `idUser`      int(11)         NOT NULL,
  `ip`          varchar(190)    NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE `urlPage` (urlPage(190))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `Jointure` (
  `id`                int(11)         NOT NULL AUTO_INCREMENT,
  `nomTable1`         varchar(190)    NOT NULL,
  `nomTable2`         varchar(190)    NOT NULL,
  `idTable1`          int(11)         NOT NULL,
  `idTable2`          int(11)         NOT NULL,
  `level`             int(11)         NOT NULL,
  `cle`               varchar(190)    NOT NULL,
  `valeur`            text            NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;

/*

MySQL 5.4 
LIMIT ON INDEX => 767 octets
utf8mb4 => 4 octets / character => 4 * 190 = 760

*/

CREATE TABLE IF NOT EXISTS `Annonce` (
  `id`            int(11)         NOT NULL AUTO_INCREMENT,
  `categorie`     varchar(200)    NOT NULL,
  `titre`         varchar(200)    NOT NULL,
  `urlAnnonce`    varchar(200)    NOT NULL,
  `description`   text            NOT NULL,
  `urlImage`      varchar(200)    NOT NULL,
  `date`          datetime        NOT NULL,
  `prix`          decimal(10,2)   NOT NULL,
  `idUser`        int(11)         NOT NULL,
  `ip`            varchar(200)    NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE `urlPage` (urlAnnonce(190))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `Visit` (
  `id`          int(11)         NOT NULL AUTO_INCREMENT,
  `urlPage`     varchar(200)    NOT NULL,
  `request`     text            NOT NULL,
  `meta`        text            NOT NULL,
  `date`        datetime        NOT NULL,
  `ip`          varchar(200)    NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `Email` (
  `id`          int(11)         NOT NULL AUTO_INCREMENT,
  `idUser`      int(11)         NOT NULL,
  `categorie`   varchar(200)    NOT NULL,
  `emailFrom`   varchar(200)    NOT NULL,
  `emailTo`     varchar(200)    NOT NULL,
  `message`     text            NOT NULL,
  `date`        datetime        NOT NULL,
  `ip`          varchar(200)    NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `Contact` (
  `id`      int(11)         NOT NULL AUTO_INCREMENT,
  `nom`     varchar(200)    NOT NULL,
  `email`   varchar(200)    NOT NULL,
  `message` text            NOT NULL,
  `date`    datetime        NOT NULL,
  `ip`      varchar(200)    NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `Newsletter` (
  `id`      int(11)         NOT NULL AUTO_INCREMENT,
  `nom`     varchar(200)    NOT NULL,
  `email`   varchar(200)    NOT NULL,
  `date`    datetime        NOT NULL,
  `ip`      varchar(200)    NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;

