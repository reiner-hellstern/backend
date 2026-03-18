# ************************************************************
# Sequel Ace SQL dump
# Version 20080
# Datenbank: drc11
# ************************************************************

# Foreign Key Constraints deaktivieren
SET FOREIGN_KEY_CHECKS = 0;

# Zuerst Zwischentabellen löschen (haben Foreign Keys)
# ------------------------------------------------------------
DROP TABLE IF EXISTS `model_has_permissions`;
DROP TABLE IF EXISTS `model_has_roles`;
DROP TABLE IF EXISTS `role_has_permissions`;
DROP TABLE IF EXISTS `role_user`;

# Dann Haupttabellen löschen
# ------------------------------------------------------------
DROP TABLE IF EXISTS `permissions`;
DROP TABLE IF EXISTS `roles`;

# Foreign Key Constraints wieder aktivieren
SET FOREIGN_KEY_CHECKS = 1;
