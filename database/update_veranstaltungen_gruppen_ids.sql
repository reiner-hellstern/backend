-- SQL Skript zum Aktualisieren der veranstalter_id und ausrichter_id in veranstaltungen
-- Führen Sie dieses Skript in der MySQL/MariaDB Konsole aus

-- Schritt 1: Backup der aktuellen Daten (optional aber empfohlen)
CREATE TABLE veranstaltungen_backup_$(date +%Y%m%d) AS SELECT * FROM veranstaltungen;

-- Schritt 2: Update veranstalter_id

-- Wenn veranstalter_bund = 1, dann Bund Gruppe (angenommen ID 1)
UPDATE veranstaltungen v 
SET veranstalter_id = (
    SELECT id FROM gruppen 
    WHERE gruppenable_type = 'App\\Models\\Bund' 
    LIMIT 1
)
WHERE v.veranstalter_bund = 1;

-- Wenn veranstalter_bezirksgruppen_id vorhanden, dann entsprechende Bezirksgruppe
UPDATE veranstaltungen v 
SET veranstalter_id = (
    SELECT g.id 
    FROM gruppen g 
    WHERE g.gruppenable_type = 'App\\Models\\Bezirksgruppe' 
    AND g.gruppenable_id = v.veranstalter_bezirksgruppen_id
)
WHERE v.veranstalter_bezirksgruppen_id IS NOT NULL 
AND v.veranstalter_bund != 1;

-- Wenn keine Bezirksgruppe, aber veranstalter_landesgruppen_id vorhanden, dann Landesgruppe
UPDATE veranstaltungen v 
SET veranstalter_id = (
    SELECT g.id 
    FROM gruppen g 
    WHERE g.gruppenable_type = 'App\\Models\\Landesgruppe' 
    AND g.gruppenable_id = v.veranstalter_landesgruppen_id
)
WHERE v.veranstalter_landesgruppen_id IS NOT NULL 
AND v.veranstalter_bezirksgruppen_id IS NULL 
AND v.veranstalter_bund != 1;

-- Schritt 3: Update ausrichter_id

-- Wenn ausrichter_bund = 1, dann Bund Gruppe
UPDATE veranstaltungen v 
SET ausrichter_id = (
    SELECT id FROM gruppen 
    WHERE gruppenable_type = 'App\\Models\\Bund' 
    LIMIT 1
)
WHERE v.ausrichter_bund = 1;

-- Wenn ausrichter_bezirksgruppen_id vorhanden, dann entsprechende Bezirksgruppe
UPDATE veranstaltungen v 
SET ausrichter_id = (
    SELECT g.id 
    FROM gruppen g 
    WHERE g.gruppenable_type = 'App\\Models\\Bezirksgruppe' 
    AND g.gruppenable_id = v.ausrichter_bezirksgruppen_id
)
WHERE v.ausrichter_bezirksgruppen_id IS NOT NULL 
AND v.ausrichter_bund != 1;

-- Wenn keine Bezirksgruppe, aber ausrichter_landesgruppen_id vorhanden, dann Landesgruppe
UPDATE veranstaltungen v 
SET ausrichter_id = (
    SELECT g.id 
    FROM gruppen g 
    WHERE g.gruppenable_type = 'App\\Models\\Landesgruppe' 
    AND g.gruppenable_id = v.ausrichter_landesgruppen_id
)
WHERE v.ausrichter_landesgruppen_id IS NOT NULL 
AND v.ausrichter_bezirksgruppen_id IS NULL 
AND v.ausrichter_bund != 1;

-- Schritt 4: Überprüfung der Ergebnisse
SELECT 
    COUNT(*) as total_veranstaltungen,
    COUNT(veranstalter_id) as veranstalter_gesetzt,
    COUNT(ausrichter_id) as ausrichter_gesetzt
FROM veranstaltungen;

-- Detaillierte Übersicht
SELECT 
    'Bund als Veranstalter' as typ,
    COUNT(*) as anzahl
FROM veranstaltungen v
JOIN gruppen g ON v.veranstalter_id = g.id
WHERE g.gruppenable_type = 'App\\Models\\Bund'

UNION ALL

SELECT 
    'Landesgruppe als Veranstalter' as typ,
    COUNT(*) as anzahl
FROM veranstaltungen v
JOIN gruppen g ON v.veranstalter_id = g.id
WHERE g.gruppenable_type = 'App\\Models\\Landesgruppe'

UNION ALL

SELECT 
    'Bezirksgruppe als Veranstalter' as typ,
    COUNT(*) as anzahl
FROM veranstaltungen v
JOIN gruppen g ON v.veranstalter_id = g.id
WHERE g.gruppenable_type = 'App\\Models\\Bezirksgruppe';

-- Zeige Veranstaltungen ohne zugewiesene Veranstalter/Ausrichter
SELECT 
    id, 
    name,
    veranstalter_bund,
    veranstalter_landesgruppen_id,
    veranstalter_bezirksgruppen_id,
    veranstalter_id,
    ausrichter_bund,
    ausrichter_landesgruppen_id,
    ausrichter_bezirksgruppen_id,
    ausrichter_id
FROM veranstaltungen 
WHERE veranstalter_id IS NULL OR ausrichter_id IS NULL
LIMIT 10;