# ************************************************************
# Sequel Ace SQL dump
# Version 20080
# Datenbank: drc11
# ************************************************************

# Foreign Key Constraints deaktivieren
SET FOREIGN_KEY_CHECKS = 0;

ALTER TABLE `users` ADD `lastlogin_at` TIMESTAMP  NULL  DEFAULT NULL;
ALTER TABLE `users` ADD `deactivated_at` TIMESTAMP  NULL  DEFAULT NULL;
ALTER TABLE `users` ADD `aktiv` TINYINT  NULL  DEFAULT NULL;

# Foreign Key Constraints wieder aktivieren
SET FOREIGN_KEY_CHECKS = 1;
