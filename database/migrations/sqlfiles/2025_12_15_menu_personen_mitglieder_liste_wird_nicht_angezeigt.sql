# Foreign Key Constraints deaktivieren
SET FOREIGN_KEY_CHECKS = 0;

ALTER TABLE `mitglieder` DROP `status`;

# Foreign Key Constraints wieder aktivieren
SET FOREIGN_KEY_CHECKS = 1;
