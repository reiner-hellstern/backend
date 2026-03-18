-- Gebührenordnung 2024 Import
-- Stand: 31.10.2024, Gültig ab: 01.04.2024

-- 1. Gebührenordnung erstellen
INSERT INTO gebuehrenordnungen (id, name, stand, gueltig_ab, gueltig_bis, aktiv, created_at, updated_at) VALUES
(1, 'Gebühren- und Spesenordnung 2024', '2024-10-31', '2024-04-01', NULL, 1, NOW(), NOW());

-- 2. Gebührengruppen erstellen
INSERT INTO gebuehrengruppen (id, name, name_kurz, val, typ, wert, `order`, created_at, updated_at) VALUES
(1, 'Mitgliedschaft', 'MITGL', 'M', 'mitgliedschaft', 1, 1, NOW(), NOW()),
(2, 'Ausstellungen', 'AUSST', 'A', 'ausstellung', 2, 2, NOW(), NOW()),
(3, 'Prüfungen Jagdlich', 'JAGD', 'J', 'pruefung_jagd', 3, 3, NOW(), NOW()),
(4, 'Prüfungen Dummy/Working', 'DUMMY', 'D', 'pruefung_dummy', 4, 4, NOW(), NOW()),
(5, 'Prüfungen Sonstige', 'SONST', 'S', 'pruefung_sonstige', 5, 5, NOW(), NOW()),
(6, 'Zucht', 'ZUCHT', 'Z', 'zucht', 6, 6, NOW(), NOW()),
(7, 'Gesundheit/Gutachten', 'GESUND', 'G', 'gesundheit', 7, 7, NOW(), NOW()),
(8, 'Registrierung', 'REG', 'R', 'registrierung', 8, 8, NOW(), NOW()),
(9, 'Verwaltung', 'VERW', 'V', 'verwaltung', 9, 9, NOW(), NOW());

-- 3. Gebührenkatalog erstellen
INSERT INTO gebuehrenkatalog (id, gebuehrengruppe_id, name, beschreibung, created_at, updated_at) VALUES
-- Mitgliedschaft
(1, 1, 'DRC-Mitgliedsbeitrag Vollmitglied', 'Jahresbeitrag für Vollmitglieder', NOW(), NOW()),
(2, 1, 'DRC-Mitgliedsbeitrag Vollmitglied (nach 1. Juli)', 'Reduzierter Beitrag bei Eintritt nach 1. Juli', NOW(), NOW()),
(3, 1, 'DRC-Mitgliedsbeitrag Vollmitglied Ausland', 'Jahresbeitrag für Vollmitglieder mit Wohnsitz außerhalb Deutschlands', NOW(), NOW()),
(4, 1, 'DRC-Mitgliedsbeitrag Vollmitglied Ausland (nach 1. Juli)', 'Reduzierter Beitrag Ausland bei Eintritt nach 1. Juli', NOW(), NOW()),
(5, 1, 'DRC-Mitgliedsbeitrag Familienmitglied', 'Jahresbeitrag für Familienmitglieder', NOW(), NOW()),
(6, 1, 'DRC-Mitgliedsbeitrag Familienmitglied (nach 1. Juli)', 'Reduzierter Beitrag Familienmitglied nach 1. Juli', NOW(), NOW()),
(7, 1, 'Aufnahmegebühr', 'Einmalige Aufnahmegebühr bei Eintritt', NOW(), NOW()),
(8, 1, 'Mahngebühr 2. Mahnung', '2. Mahnung bei Zahlungsverzug', NOW(), NOW()),
(9, 1, 'Säumniszuschlag', 'Säumniszuschlag gem. § 13(2) DRC Satzung', NOW(), NOW()),
(10, 1, 'Bearbeitungsgebühr Rücklastschrift', 'Bearbeitungsgebühr für Rücklastschriften', NOW(), NOW()),

-- Ausstellungen
(11, 2, 'DRC Zuchtschau 1. Hund (1. Meldeschluss)', '1. Hund bei Meldung 8 Wochen vor Ausstellungstag', NOW(), NOW()),
(12, 2, 'DRC Zuchtschau weitere Hunde (1. Meldeschluss)', 'Weitere Hunde des meldenden Eigentümers (1. Meldeschluss)', NOW(), NOW()),
(13, 2, 'DRC Zuchtschau Baby/Jüngsten/Veteranen (1. Meldeschluss)', 'Baby-, Jüngsten-, Veteranenklasse (1. Meldeschluss)', NOW(), NOW()),
(14, 2, 'DRC Zuchtschau 1. Hund (2. Meldeschluss)', '1. Hund bei Meldung 4 Wochen vor Ausstellungstag', NOW(), NOW()),
(15, 2, 'DRC Zuchtschau weitere Hunde (2. Meldeschluss)', 'Weitere Hunde des meldenden Eigentümers (2. Meldeschluss)', NOW(), NOW()),
(16, 2, 'DRC Zuchtschau Baby/Jüngsten/Veteranen (2. Meldeschluss)', 'Baby-, Jüngsten-, Veteranenklasse (2. Meldeschluss)', NOW(), NOW()),
(17, 2, 'DRC Zuchtschau 1. Hund (3. Meldeschluss)', '1. Hund bei Meldung 2 Wochen vor Ausstellungstag', NOW(), NOW()),
(18, 2, 'DRC Zuchtschau weitere Hunde (3. Meldeschluss)', 'Weitere Hunde des meldenden Eigentümers (3. Meldeschluss)', NOW(), NOW()),
(19, 2, 'DRC Zuchtschau Baby/Jüngsten/Veteranen (3. Meldeschluss)', 'Baby-, Jüngsten-, Veteranenklasse (3. Meldeschluss)', NOW(), NOW()),
(20, 2, 'Formwertbeurteilung', 'Einzelne Formwertbeurteilung', NOW(), NOW()),

-- Prüfungen Jagdlich
(21, 3, 'Jagdliche Anlagensichtung (JAS)', 'JAS-Prüfung', NOW(), NOW()),
(22, 3, 'Tollingprüfung NSDT bronze (TP)', 'TP/Toller - bronze', NOW(), NOW()),
(23, 3, 'Tollingprüfung NSDT silber (TP)', 'TP/Toller - silber', NOW(), NOW()),
(24, 3, 'Bringleistungsprüfung (BLP) ohne Zusatzfächer', 'BLP ohne Zusatzfächer', NOW(), NOW()),
(25, 3, 'Bringleistungsprüfung (BLP) mit Zusatzfächern', 'BLP mit Zusatzfächern', NOW(), NOW()),
(26, 3, 'Retrievergebrauchsprüfung (RGP)', 'RGP (zuzügl. Gebühr für lebende Ente)', NOW(), NOW()),
(27, 3, 'Dr.Heraeus-Gedächtnis-Prüfung (HP/R)', 'HP/R-Prüfung', NOW(), NOW()),
(28, 3, 'St.-John\'s-Retrieverprüfung (SRP)', 'SRP-Prüfung', NOW(), NOW()),
(29, 3, 'Prüfung nach dem Schuss (PnS)', 'PnS-Prüfung', NOW(), NOW()),
(30, 3, 'Vereins-Schweißprüfung (RSw/P)', 'RSw/P-Prüfung', NOW(), NOW()),
(31, 3, 'Schweißprüfung ohne Richterbegleitung (SwP/o.Rb)', 'SwP/o.Rb-Prüfung', NOW(), NOW()),

-- Prüfungen Dummy/Working
(32, 4, 'Arbeitsprüfungen mit Dummies (APD) pro Klasse', 'APD pro Klasse', NOW(), NOW()),
(33, 4, 'Workingtest pro Klasse', 'WT pro Klasse', NOW(), NOW()),
(34, 4, 'Workingtest Schnupperer- & Veteranenklasse', 'WT Schnupperer & Veteranen', NOW(), NOW()),
(35, 4, 'Mocktrial', 'Mocktrial-Prüfung', NOW(), NOW()),
(36, 4, 'German Cup pro Team', 'German Cup Teilnahme pro Team', NOW(), NOW()),
(37, 4, 'Newcomer Trophy', 'Newcomer Trophy Teilnahme', NOW(), NOW()),
(38, 4, 'Veteranen Cup', 'Veteranen Cup Teilnahme', NOW(), NOW()),
(39, 4, 'Workingtest-Finale', 'WT-Finale Teilnahme', NOW(), NOW()),

-- Prüfungen Sonstige
(40, 5, 'Nachweis der Schussfestigkeit', 'Schussfestigkeitsnachweis', NOW(), NOW()),
(41, 5, 'Wesenstest', 'Wesenstest', NOW(), NOW()),
(42, 5, 'Begleithundeprüfung', 'BH-Prüfung', NOW(), NOW()),
(43, 5, 'Team-Day', 'Team-Day Veranstaltung', NOW(), NOW()),

-- Zucht
(44, 6, 'Erteilung Zwingerschutz', 'Zwingerschutz beantragen', NOW(), NOW()),
(45, 6, 'Ablehnung/Änderung/Erweiterung Zwingerschutz', 'Zwingerschutz Bearbeitung', NOW(), NOW()),
(46, 6, 'Zuchtzulassung je Hund', 'Zuchtzulassung pro Hund', NOW(), NOW()),
(47, 6, 'Wurfeintragung DRC-Zuchtbuch je Welpe', 'Reguläre Wurfeintragung', NOW(), NOW()),
(48, 6, 'Wurfeintragung DRC-Zuchtbuch je Welpe (verspätet)', 'Verspätete Wurfmeldung (nach 8 Tagen)', NOW(), NOW()),
(49, 6, 'Wurfeintragung DRC-Zuchtbuch je Welpe (ohne Zuchtzulassung)', 'Wurfeintragung ohne gültige Zuchtzulassung', NOW(), NOW()),
(50, 6, 'Übernahme ins DRC-Zuchtbuch', 'Übernahme (Erfassung v. Ahnen bis 3. Generation)', NOW(), NOW()),
(51, 6, 'Ahnentafelzweitschrift je Hund', 'Zweitschrift der Ahnentafel', NOW(), NOW()),
(52, 6, 'Ahnentafelkorrektur je Hund', 'Korrektur der Ahnentafel', NOW(), NOW()),
(53, 6, 'Leistungsheft Nicht-DRC-Hunde', 'Leistungsheft für Nicht-DRC-Hunde', NOW(), NOW()),

-- Gesundheit/Gutachten
(54, 7, 'HD-ED-Gutachten (Nicht-DRC-Hunde)', 'HD-ED-Gutachten für nicht eingetragene Hunde', NOW(), NOW()),
(55, 7, 'HD-Obergutachten', 'HD-Obergutachten', NOW(), NOW()),
(56, 7, 'ED-Obergutachten', 'ED-Obergutachten', NOW(), NOW()),

-- Registrierung
(57, 8, 'Bearbeitungsgebühr Registrierung', 'Bearbeitungsgebühr für Registrierung', NOW(), NOW()),
(58, 8, 'Wesensüberprüfung für Registrierung', 'Wesensüberprüfung bei Registrierung', NOW(), NOW()),
(59, 8, 'Überprüfung Rassestandard für Registrierung', 'Rassestandard-Überprüfung bei Registrierung', NOW(), NOW()),
(60, 8, 'Registrierungsbescheinigung', 'Ausstellung der Registrierungsbescheinigung', NOW(), NOW()),

-- Verwaltung
(61, 9, 'Versandkostenpauschale', 'Versandkosten für alle Gebühren', NOW(), NOW()),
(62, 9, 'Einspruchsgebühr Prüfungsergebnis', 'Einspruch gegen Prüfungsergebnis', NOW(), NOW());

-- 4. Gebühren erstellen (mit aktuellen Preisen von 2024)
INSERT INTO gebuehren (id, gebuehrenkatalog_id, gebuehrenordnung_id, stand, gueltig_ab, gueltig_bis, kosten_mitglied, kosten_nichtmitglied, aktiv, created_at, updated_at) VALUES
-- Mitgliedschaft
(1, 1, 1, '2024-10-31', '2024-04-01', NULL, 59.00, 59.00, 1, NOW(), NOW()),
(2, 2, 1, '2024-10-31', '2024-04-01', NULL, 30.00, 30.00, 1, NOW(), NOW()),
(3, 3, 1, '2024-10-31', '2024-04-01', NULL, 70.00, 70.00, 1, NOW(), NOW()),
(4, 4, 1, '2024-10-31', '2024-04-01', NULL, 35.00, 35.00, 1, NOW(), NOW()),
(5, 5, 1, '2024-10-31', '2024-04-01', NULL, 30.00, 30.00, 1, NOW(), NOW()),
(6, 6, 1, '2024-10-31', '2024-04-01', NULL, 15.00, 15.00, 1, NOW(), NOW()),
(7, 7, 1, '2024-10-31', '2024-04-01', NULL, 25.00, 25.00, 1, NOW(), NOW()),
(8, 8, 1, '2024-10-31', '2024-04-01', NULL, 2.50, 2.50, 1, NOW(), NOW()),
(9, 9, 1, '2024-10-31', '2024-04-01', NULL, 10.00, 10.00, 1, NOW(), NOW()),
(10, 10, 1, '2024-10-31', '2024-04-01', NULL, 10.00, 10.00, 1, NOW(), NOW()),

-- Ausstellungen (Mitglieder und Nichtmitglieder gleiche Preise)
(11, 11, 1, '2024-10-31', '2024-04-01', NULL, 35.00, 35.00, 1, NOW(), NOW()),
(12, 12, 1, '2024-10-31', '2024-04-01', NULL, 30.00, 30.00, 1, NOW(), NOW()),
(13, 13, 1, '2024-10-31', '2024-04-01', NULL, 30.00, 30.00, 1, NOW(), NOW()),
(14, 14, 1, '2024-10-31', '2024-04-01', NULL, 45.00, 45.00, 1, NOW(), NOW()),
(15, 15, 1, '2024-10-31', '2024-04-01', NULL, 40.00, 40.00, 1, NOW(), NOW()),
(16, 16, 1, '2024-10-31', '2024-04-01', NULL, 30.00, 30.00, 1, NOW(), NOW()),
(17, 17, 1, '2024-10-31', '2024-04-01', NULL, 55.00, 55.00, 1, NOW(), NOW()),
(18, 18, 1, '2024-10-31', '2024-04-01', NULL, 50.00, 50.00, 1, NOW(), NOW()),
(19, 19, 1, '2024-10-31', '2024-04-01', NULL, 30.00, 30.00, 1, NOW(), NOW()),
(20, 20, 1, '2024-10-31', '2024-04-01', NULL, 45.00, 90.00, 1, NOW(), NOW()),

-- Prüfungen Jagdlich
(21, 21, 1, '2024-10-31', '2024-04-01', NULL, 80.00, 120.00, 1, NOW(), NOW()),
(22, 22, 1, '2024-10-31', '2024-04-01', NULL, 80.00, 120.00, 1, NOW(), NOW()),
(23, 23, 1, '2024-10-31', '2024-04-01', NULL, 90.00, 130.00, 1, NOW(), NOW()),
(24, 24, 1, '2024-10-31', '2024-04-01', NULL, 90.00, 130.00, 1, NOW(), NOW()),
(25, 25, 1, '2024-10-31', '2024-04-01', NULL, 120.00, 160.00, 1, NOW(), NOW()),
(26, 26, 1, '2024-10-31', '2024-04-01', NULL, 170.00, 230.00, 1, NOW(), NOW()),
(27, 27, 1, '2024-10-31', '2024-04-01', NULL, 150.00, 200.00, 1, NOW(), NOW()),
(28, 28, 1, '2024-10-31', '2024-04-01', NULL, 150.00, 200.00, 1, NOW(), NOW()),
(29, 29, 1, '2024-10-31', '2024-04-01', NULL, 150.00, 210.00, 1, NOW(), NOW()),
(30, 30, 1, '2024-10-31', '2024-04-01', NULL, 150.00, 210.00, 1, NOW(), NOW()),
(31, 31, 1, '2024-10-31', '2024-04-01', NULL, 150.00, 210.00, 1, NOW(), NOW()),

-- Prüfungen Dummy/Working
(32, 32, 1, '2024-10-31', '2024-04-01', NULL, 45.00, 80.00, 1, NOW(), NOW()),
(33, 33, 1, '2024-10-31', '2024-04-01', NULL, 60.00, 75.00, 1, NOW(), NOW()),
(34, 34, 1, '2024-10-31', '2024-04-01', NULL, 45.00, 60.00, 1, NOW(), NOW()),
(35, 35, 1, '2024-10-31', '2024-04-01', NULL, 75.00, 90.00, 1, NOW(), NOW()),
(36, 36, 1, '2024-10-31', '2024-04-01', NULL, 300.00, 300.00, 1, NOW(), NOW()),
(37, 37, 1, '2024-10-31', '2024-04-01', NULL, 60.00, 60.00, 1, NOW(), NOW()),
(38, 38, 1, '2024-10-31', '2024-04-01', NULL, 50.00, 70.00, 1, NOW(), NOW()),
(39, 39, 1, '2024-10-31', '2024-04-01', NULL, 120.00, 140.00, 1, NOW(), NOW()),

-- Prüfungen Sonstige (alle gleiche Preise für Mitglieder/Nichtmitglieder)
(40, 40, 1, '2024-10-31', '2024-04-01', NULL, 20.00, 32.50, 1, NOW(), NOW()),
(41, 41, 1, '2024-10-31', '2024-04-01', NULL, 45.00, 45.00, 1, NOW(), NOW()),
(42, 42, 1, '2024-10-31', '2024-04-01', NULL, 45.00, 45.00, 1, NOW(), NOW()),
(43, 43, 1, '2024-10-31', '2024-04-01', NULL, 45.00, 45.00, 1, NOW(), NOW()),

-- Zucht
(44, 44, 1, '2024-10-31', '2024-04-01', NULL, 100.00, 100.00, 1, NOW(), NOW()),
(45, 45, 1, '2024-10-31', '2024-04-01', NULL, 40.00, 40.00, 1, NOW(), NOW()),
(46, 46, 1, '2024-10-31', '2024-04-01', NULL, 75.00, 75.00, 1, NOW(), NOW()),
(47, 47, 1, '2024-10-31', '2024-04-01', NULL, 100.00, 100.00, 1, NOW(), NOW()),
(48, 48, 1, '2024-10-31', '2024-04-01', NULL, 180.00, 180.00, 1, NOW(), NOW()),
(49, 49, 1, '2024-10-31', '2024-04-01', NULL, 280.00, 280.00, 1, NOW(), NOW()),
(50, 50, 1, '2024-10-31', '2024-04-01', NULL, 150.00, 250.00, 1, NOW(), NOW()),
(51, 51, 1, '2024-10-31', '2024-04-01', NULL, 100.00, 170.00, 1, NOW(), NOW()),
(52, 52, 1, '2024-10-31', '2024-04-01', NULL, 50.00, 100.00, 1, NOW(), NOW()),
(53, 53, 1, '2024-10-31', '2024-04-01', NULL, 35.00, 35.00, 1, NOW(), NOW()),

-- Gesundheit/Gutachten
(54, 54, 1, '2024-10-31', '2024-04-01', NULL, 80.00, 80.00, 1, NOW(), NOW()),
(55, 55, 1, '2024-10-31', '2024-04-01', NULL, 100.00, 100.00, 1, NOW(), NOW()),
(56, 56, 1, '2024-10-31', '2024-04-01', NULL, 100.00, 100.00, 1, NOW(), NOW()),

-- Registrierung
(57, 57, 1, '2024-10-31', '2024-04-01', NULL, 70.00, 70.00, 1, NOW(), NOW()),
(58, 58, 1, '2024-10-31', '2024-04-01', NULL, 45.00, 45.00, 1, NOW(), NOW()),
(59, 59, 1, '2024-10-31', '2024-04-01', NULL, 200.00, 200.00, 1, NOW(), NOW()),
(60, 60, 1, '2024-10-31', '2024-04-01', NULL, 150.00, 150.00, 1, NOW(), NOW()),

-- Verwaltung
(61, 61, 1, '2024-10-31', '2024-04-01', NULL, 7.50, 7.50, 1, NOW(), NOW()),
(62, 62, 1, '2024-10-31', '2024-04-01', NULL, 50.00, 50.00, 1, NOW(), NOW());
