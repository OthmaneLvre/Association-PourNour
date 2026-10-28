-- Association Pour Nour
-- Migration 002 : email facultatif pour le second adherent
-- MariaDB 10.4
-- A executer apres la migration 001.
-- Ne pas utiliser le compte applicatif.

USE association_pour_nour;

ALTER TABLE members
    MODIFY COLUMN email VARCHAR(254) NULL;