<?php

namespace App\Http\Controllers\templates\dokumente;

use App\Http\Controllers\templates\TemplateBaseController;

class AenderungsmeldungKontaktdatenController extends TemplateBaseController
{
    // (1): false, –, ... false
    // (2): true, true, true, true, ... false
    // (3): true, true, true, false, ... false
    // (4): true, true, false, false, ... false
    // (5): true, false, -, false, false, ... false
    // (6): true, false, -, true, false, ... false
    // (7): true, false, true, false, true, false, false
    // (8): true, false, true, true, true, false, false
    // (9): true, false, false, true, true, false, false
    // (10): true, false, false, true, true, true, false
    // (11): -, -, -, -, -, -, true
    public function show()
    {
        global $changedData;
        $changedData = [
            'newFirstName' => null,
            'newLastName' => null,
            'newPhone' => null,
            'newEmail' => null,
            'newWebsite' => null,
            'newAddress' => 'Dummystraße 12',
            'newAddressSupplement' => null,
            'newPlace' => null,
            'newZipCode' => null,
            'newCountry' => null,
        ];

        /**
         * Returns an array containing the page's subheadline and the section headline
         * for the changed data.
         *
         * The first element of the array is the page's subheadline as a string, e.g. "Name, Telefon, E-Mail"
         * The second element of the array is the section headline. If only one value changed, the second element
         * is a specific headline, e.g. "Geänderte Telefonnummer".
         * If multiple values have been changed "Neue Kontaktdaten"
         *
         * @param  array  $changedData  An array containing the changed data
         * @return array An array containing the changed data as a string and the section headline
         */
        function generateHeadlines($changedData)
        {
            $countNotNull = 0;
            $text = '';

            foreach ($changedData as $key => $value) {
                if ($value != null) {
                    $append = '';
                    switch ($key) {
                        case 'newFirstName':
                            $append = 'Name';
                            break;
                        case 'newLastName':
                            if (! str_contains($text, 'Name')) {
                                $append = 'Name';
                            } else {
                                $countNotNull--;
                            }
                            $text = substr($text, 0, -2);
                            break;
                        case 'newPhone':
                            $append = 'Telefon';
                            break;
                        case 'newEmail':
                            $append = 'E-Mail';
                            break;
                        case 'newWebsite':
                            $append = 'Website';
                            break;
                        case 'newAddress':
                            $append = 'Adresse';
                            break;
                        case 'newAddressSupplement':
                            if (! str_contains($text, 'Adresse')) {
                                $append = 'Adresse';
                            } else {
                                $countNotNull--;
                            }
                            $text = substr($text, 0, -2);
                            break;
                        case 'newPlace':
                            if (! str_contains($text, 'Adresse')) {
                                $append = 'Adresse';
                            } else {
                                $countNotNull--;
                            }
                            $text = substr($text, 0, -2);
                            break;
                        case 'newZipCode':
                            if (! str_contains($text, 'Adresse')) {
                                $append = 'Adresse';
                            } else {
                                $countNotNull--;
                            }
                            $text = substr($text, 0, -2);
                            break;
                        case 'newCountry':
                            if (! str_contains($text, 'Adresse')) {
                                $append = 'Adresse';
                            } else {
                                $countNotNull--;
                            }
                            $text = substr($text, 0, -2);
                            break;
                        default:
                            break;
                    }
                    $countNotNull++;
                    $text = $text . $append . ', ';
                }
            }

            $changedDataSectionHeadline = 'Neue Kontaktdaten';
            if ($countNotNull == 1) {
                switch (substr($text, 0, -2)) {
                    case 'Name':
                        $changedDataSectionHeadline = 'Geänderter Name';
                        break;
                    case 'Telefon':
                        $changedDataSectionHeadline = 'Geänderte Telefonnummer';
                        break;
                    case 'E-Mail':
                        $changedDataSectionHeadline = 'Geänderte E-Mail-Adresse';
                        break;
                    case 'Website':
                        $changedDataSectionHeadline = 'Geänderte Website';
                        break;
                    case 'Adresse':
                        $changedDataSectionHeadline = 'Zukünftiger Wohnsitz';
                        break;
                    default:
                        break;
                }
            }

            return [('– ' . substr($text, 0, -2) . ' vom [dd.mm.yyyy] –'), $changedDataSectionHeadline];
        }

        // function generateConfirmations(?int $familyExceptionId = null)
        // {
        //     if ($familyExceptionId) {

        //     } else {

        //     }

        //     $dummyZwinger = [
        //         'id' => 0,
        //         'long' => "10.000000",
        //         'lat' => "50.000000",
        //         'strasse' => "Dummystraße 1",
        //         'adresszusatz' => null,
        //         'postleitzahl' => "90000",
        //         'ort' => "Dummystadt",
        //         'land' => "Deutschland",
        //         'laenderkuerzel' => "DE",
        //         'telefon_1' => null,
        //         'telefon_2' => null,
        //         'email_1' => null,
        //         'email_2' => null,
        //         'bemerkung' => null,
        //         'rasse' => "G",
        //         'verein' => "DRC",
        //         'mitgliedsnummer' => '310000',
        //         'zwingernummer' => '2921',
        //         'zwingername' => "...vom Dummyzwinger",
        //         'zwingername_praefix' => null,
        //         'zwingername_suffix' => "vom Dummyzwinger",
        //         'gebiet' => "FCI 40/20",
        //         'fcinummer' => 'x',
        //     ];

        //     function didChange($key)
        //     {
        //         global $changedData;
        //         return array_key_exists($key, $changedData) && $changedData[$key] !== null;
        //     }

        //     $confirmations = [];

        //     $isZwingergemeinschaft = true;
        //     $isZuechter = true;
        //     $isZweitwohnsitz = false;
        //     $isFamilyException = false;
        //     $zuchtstaettenbesichtigungAlreadyDone = false;

        //     global $changedData;

        //     if ($isZwingergemeinschaft) {
        //         // Wir bestätigen ...
        //         array_push($confirmations, "Hiermit bestätigen wir die Richtigkeit der oben gemachten Angaben.");

        //         if ($isFamilyException) {
        //             // Ausnahmefall: Mutter / Vater -> Kinder (Verwandtschaftsgrad 1 muss bestehen!)
        //             array_push($confirmations, "Mein neuer Wohnsitz entspricht der Zuchtstätten-Adresse der Zwinger-Gemeinschaft.");

        //             $zwinger = [
        //                 'addressOld' => "Musterstraße 1",
        //                 'addressNew' => "Musterstraße 1",
        //             ];

        //             $mitinhaber1 = [
        //                 'addressOld' => "Musterstraße 1",
        //                 'addressNew' => "Musterstraße 1",
        //             ];

        //             $mitinhaber2 = [
        //                 'addressOld' => "Musterstraße 1",
        //                 'addressNew' => "Musterstraße 1",
        //             ];

        //             $mitinhaber3 = [
        //                 'addressOld' => "Musterstraße 1",
        //                 'addressNew' => "Musterstraße 1",
        //             ];

        //             $mitinhaber_list = [
        //                 $mitinhaber1,
        //                 $mitinhaber2,
        //                 $mitinhaber3
        //             ];

        //             $sameAddressCount = 0;
        //             foreach ($mitinhaber_list as $mitinhaber) {
        //                 if ($mitinhaber['addressNew'] == $zwinger['addressNew']) {
        //                     $sameAddressCount++;
        //                 }
        //             }

        //             if ($sameAddressCount == 0) {
        //                 // Alle Personen
        //                 // CASE-ID: 16
        //                 array_push(
        //                     $confirmations,
        //                     "Der Wohnsitz der Zwinger-Inhaber stimmt nicht mit der Zuchtstätten-Adresse überein.",
        //                     "Unsere 2. Wohnsitz-Nachweise für die Zuchtstätte sind mit der Änderungsmeldung am [xx.xx.xxxx] erfolgt und wurde am [xx.xx.xxxx] von der DRC-Geschäftsstelle bestätigt.."
        //                 );
        //             }
        //         } else {
        //             if (didChange("newAddress") + didChange("newAddressSupplement") + didChange("newPlace") + didChange("newZipCode") == true) {
        //                 // Address changed
        //                 if ($isZuechter) {
        //                     if ($changedData["newAddress"] == $dummyZwinger['strasse']) {
        //                         // Alle Züchter ziehen an die Adresse der bisherigen Zuchtstätte
        //                         // CASE-ID: 9
        //                         array_push($confirmations, "Der Wohnsitz der Zwinger-Inhaber stimmt mit der Zuchtstätten-Adresse überein.");
        //                     } else if ($isZweitwohnsitz) {
        //                         // Züchter ziehen um, Wohnadressen und Zuchtsättenadresse sind unterschiedlich, aber über einen Zweitwohnsitz hinterlegt.
        //                         // CASE-ID: 10
        //                         array_push(
        //                             $confirmations,
        //                             "Der Wohnsitz der Zwinger-Inhaber stimmt nicht mit der Zuchtstätten-Adresse überein.",
        //                             "Unsere 2. Wohnsitz-Nachweise für die Zuchtstätte sind mit der Änderungsmeldung am [xx.xx.xxxx] erfolgt und wurde am [xx.xx.xxxx] von der DRC-Geschäftsstelle bestätigt.."
        //                         );

        //                     } else {
        //                         // Züchter ziehen an die gleiche Wohnadresse um. Wohnadresse und Zuchtstättenadresse ändert sich.
        //                         // CASE-IDs: 7 & 8
        //                         array_push($confirmations, "Die Zuchtstätten-Adresse entspricht meinem neuen Wohnsitz Diese wurde, soweit noch notwendig, automatisch in das Zwinger-Profil übernommen.");
        //                         if ($zuchtstaettenbesichtigungAlreadyDone) {
        //                             // Zustsättenbesichtigung ist abgeschlossen
        //                             // CASE-ID: 8
        //                             array_push(
        //                                 $confirmations,
        //                                 "Der Wohnsitz der Zwinger-Inhaber stimmt mit der Zuchtstätten-Adresse überein. Diese wurde, soweit notwendig, automatisch in das Zwinger-Profil der Zwinger-Gemeinschaft übernommen.",
        //                                 "Die neue Zuchtstätte ist bereits durch die Zuchtstätten-Besichtigung vom [xx.xx.xxxx] freigegeben.",
        //                                 "Der Umzug der Zuchtstätte muss durch den DRC an den VDH gemeldet werden. Wir erhalten nach Rückgabe unserer bisherigen Karte an die DRC-Geschäftstelle eine neue VDH-Zwingerkarte.",
        //                                 "Die neue VDH-Zwingerkarte ist kostenpflichtig. Der Betrag in Höhe von [Gebühr für neue Zwingerkarte] wird vom Konto des Melders abgebucht.",
        //                             );
        //                         } else {
        //                             // Zustsättenbesichtigung ist noch nicht abegeschlossen (ausstehend)
        //                             // CASE-ID: 7
        //                             array_push(
        //                                 $confirmations,
        //                                 "Der Wohnsitz der Zwinger-Inhaber stimmt mit der Zuchtstätten-Adresse überein. Diese wurde, soweit notwendig, automatisch in das Zwinger-Profil der Zwinger-Gemeinschaft übernommen.",
        //                                 "Uns ist bewusst, dass unsere Zwinger-Tätigkeit ruht, solange die neue Zuchtstätte nicht per Zuchtstätten-Besichtigung freigegeben ist.",
        //                                 "Der Umzug der Zuchtstätte muss durch den DRC an den VDH gemeldet werden. Wir erhalten nach Rückgabe unserer bisherigen Karte an die DRC-Geschäftstelle eine neue VDH-Zwingerkarte.",
        //                                 "Die neue VDH-Zwingerkarte ist kostenpflichtig. Der Betrag in Höhe von [Gebühr für neue Zwingerkarte] wird vom Konto des Melders abgebucht.",
        //                             );
        //                         }
        //                     }
        //                 }
        //             }
        //         }
        //     } else {
        //         // Ich bestätige ...
        //         array_push($confirmations, "Hiermit bestätige ich die Richtigkeit der oben gemachten Angaben.");

        //         if (didChange("newFirstName") + didChange("newLastName") == true) {
        //             // Name did change
        //             array_push($confirmations, "Die Änderung meines Namens, bedingt eine Neuausstellung meines DRC-Mitgliedsausweises. Nach Rückgabe meiner bisherigen Mitgliedskarte an die DRC-Geschäftstelle erhalte ich meinen neuen DRC-Mitgliedsausweis.");
        //             if ($isZuechter) {
        //                 array_push(
        //                     $confirmations,
        //                     "Die Änderung meines Namens, bedingt eine Meldung des DRC an den VDH und eine Neuausstellung meiner VDH-Zwingerschutzkarte. Nach Rückgabe meiner bisherigen original Zwingerschutzkarte an die DRC-Geschäftstelle erhalte ich eine neue VDH-Zwingerschutzkarte.",
        //                     "Die neue VDH-Zwingerkarte ist kostenpflichtig. Der Betrag in Höhe von [Gebühr für neue Zwingerkarte] wird von meinem Konto abgebucht."

        //                 );
        //             }
        //         }

        //         if (didChange("newCountry") && $changedData['newCountry'] != "Deutschland") {
        //             // Züchter zieht ins Ausland
        //             // CASE-ID: 6
        //             array_push(
        //                 $confirmations,
        //                 "Mir ist bewusst, dass meine Zwinger-Tätigkeit beim DRC ruht, solange sich mein 1. Wohnsitz außerhalb Deutschlands befindet.",
        //                 "Meine original Zwingerschutzkarte habe ich an die DRC-Geschäftsstelle zur Weiterleitung an den VDH geschickt. Ich erhalte eine Abmeldebstätigung mit der ich mich bei meinem zukünftigen FCI-Zuchtverein anmelden kann. Von diesem erhalte ich dann auch meine neue Zwingerschutzbescheinigung."
        //             );
        //         } else if (didChange("newAddress") + didChange("newAddressSupplement") + didChange("newPlace") + didChange("newZipCode") == true) {
        //             // Address changed
        //             if ($isZuechter) {
        //                 if ($changedData["newAddress"] == $dummyZwinger['strasse']) {
        //                     // Züchter zieht an die Adresse der bisherigen Zuchtstätte
        //                     // CASE-ID: 4
        //                     array_push($confirmations, "Die Zuchtstätten-Adresse entspricht meinem neuen Wohnsitz.");
        //                 } else if ($isZweitwohnsitz) {
        //                     // Züchter zieht um, Wohnadresse und Zuchtsättenadresse sind unterschiedlich, aber über einen Zweitwohnsitz hinterlegt.
        //                     // CASE-ID: 5
        //                     array_push(
        //                         $confirmations,
        //                         "Die Zuchtstätte verbleibt an ihrer bisherigen Adresse und stimmt nicht mehr mit meinem Wohnsitz überein.",
        //                         "Mein 2. Wohnsitz-Nachweis für die Zuchtstätte ist mit der Änderungsmeldung am [xx.xx.xxxx] erfolgt und wurde am [xx.xx.xxxx] von der DRC-Geschäftsstelle bestätigt."
        //                     );

        //                 } else {
        //                     // Züchter zieht um, Wohnadresse und Zuchtstättenadresse ändert sich.
        //                     // CASE-IDs: 2 & 3
        //                     array_push($confirmations, "Die Zuchtstätten-Adresse entspricht meinem neuen Wohnsitz Diese wurde, soweit noch notwendig, automatisch in das Zwinger-Profil übernommen.");
        //                     if ($zuchtstaettenbesichtigungAlreadyDone) {
        //                         // Zustsättenbesichtigung ist abgeschlossen
        //                         // CASE-ID: 2
        //                         array_push(
        //                             $confirmations,
        //                             "Die neue Zuchtstätte ist bereits durch die Zuchtstätten-Besichtigung vom [xx.xx.xxxx] freigegeben.",
        //                             "Der Umzug der Zuchtstätte muss durch den DRC an den VDH gemeldet werden. Ich erhalte nach Rückgabe meiner bisherigen Karte an die DRC-Geschäftsstelle eine neue VDH-Zwingerkarte.",
        //                             "Die neue VDH-Zwingerkarte ist kostenpflichtig. Der Betrag in Höhe von [Gebühr für neue Zwingerkarte] wird von meinem Konto abgebucht.",
        //                         );
        //                     } else {
        //                         // Zustsättenbesichtigung ist noch nicht abegeschlossen (ausstehend)
        //                         // CASE-ID: 3
        //                         array_push(
        //                             $confirmations,
        //                             "Mir ist bewusst, dass meine Zwinger-Tätigkeit ruht, solange die neue Zuchtstätte nicht per Zuchtstätten-Besichtigung freigegeben ist.",
        //                             "Der Umzug der Zuchtstätte muss durch den DRC an den VDH gemeldet werden. Ich erhalte nach Rückgabe meiner bisherigen Karte an die DRC-Geschäftsstelle eine neue VDH-Zwingerkarte.",
        //                             "Die neue VDH-Zwingerkarte ist kostenpflichtig. Der Betrag in Höhe von [Gebühr für neue Zwingerkarte] wird von meinem Konto abgebucht.",
        //                         );
        //                     }
        //                 }
        //             }
        //         }

        //     }

        //     return $confirmations;
        // }

        function generateConfirmations($caseId)
        {
            $confirmations = [];
            switch ($caseId) {
                case 1:
                    array_push(
                        $confirmations,
                        'Hiermit bestätige ich die Richtigkeit der oben gemachten Angaben.'
                    );
                    break;
                case 2:
                    array_push(
                        $confirmations,
                        'Hiermit bestätige ich die Richtigkeit der oben gemachten Angaben.',
                        'Die Zuchtstätten-Adresse entspricht meinem neuen Wohnsitz. Diese wurde, soweit noch notwendig, automatisch in das Zwinger-Profil übernommen.',
                        'Die neue Zuchtstätte ist bereits durch die Zuchtstätten-Besichtigung vom [xx.xx.xxxx] freigegeben.',
                        'Der Umzug der Zuchtstätte muss durch den DRC an den VDH gemeldet werden. Ich erhalte nach Rückgabe meiner bisherigen Karte an die DRC-Geschäftsstelle eine neue VDH-Zwingerkarte.',
                        'Die neue VDH-Zwingerkarte ist kostenpflichtig. Der Betrag in Höhe von [Gebühr für neue Zwingerkarte] wird von meinem Konto abgebucht.'
                    );
                    break;
                case 3:
                    array_push(
                        $confirmations,
                        'Hiermit bestätige ich die Richtigkeit der oben gemachten Angaben.',
                        'Die Zuchtstätten-Adresse entspricht meinem neuen Wohnsitz. Diese wurde, soweit noch notwendig, automatisch in das Zwinger-Profil übernommen.',
                        'Mir ist bewusst, dass meine Zwinger-Tätigkeit ruht, solange die neue Zuchtstätte nicht per Zuchtstätten-Besichtigung freigegeben ist.',
                        'Der Umzug der Zuchtstätte muss durch den DRC an den VDH gemeldet werden. Ich erhalte nach Rückgabe meiner bisherigen Karte an die DRC-Geschäftsstelle eine neue VDH-Zwingerkarte.',
                        'Die neue VDH-Zwingerkarte ist kostenpflichtig. Der Betrag in Höhe von [Gebühr für neue Zwingerkarte] wird von meinem Konto abgebucht.'
                    );
                    break;
                case 4:
                    array_push(
                        $confirmations,
                        'Hiermit bestätige ich die Richtigkeit der oben gemachten Angaben.',
                        'Die Zuchtstätten-Adresse entspricht meinem neuen Wohnsitz.'
                    );
                    break;
                case 5:
                    array_push(
                        $confirmations,
                        'Hiermit bestätige ich die Richtigkeit der oben gemachten Angaben.',
                        'Die Zuchtstätte verbleibt an ihrer bisherigen Adresse und stimmt nicht mehr mit meinem Wohnsitz überein.',
                        'Mein 2. Wohnsitz-Nachweis für die Zuchtstätte ist mit der Änderungsmeldung am [xx.xx.xxxx] erfolgt und wurde am [xx.xx.xxxx] von der DRC-Geschäftsstelle bestätigt.'
                    );
                    break;
                case 6:
                    array_push(
                        $confirmations,
                        'Hiermit bestätige ich die Richtigkeit der oben gemachten Angaben.',
                        'Mir ist bewusst, dass meine Zwinger-Tätigkeit beim DRC ruht, solange sich mein 1. Wohnsitz außerhalb Deutschlands befindet.',
                        'Meine original Zwingerschutzkarte habe ich an die DRC-Geschäftsstelle zur Weiterleitung an den VDH geschickt. Ich erhalte eine Abmeldebstätigung mit der ich mich bei meinem zukünftigen FCI-Zuchtverein anmelden kann. Von diesem erhalte ich dann auch meine neue Zwingerschutzbescheinigung.'
                    );
                    break;
                case 7:
                    array_push(
                        $confirmations,
                        'Hiermit bestätigen wir die Richtigkeit der oben gemachten Angaben.',
                        'Der Wohnsitz der Zwinger-Inhaber stimmt mit der Zuchtstätten-Adresse überein. Diese wurde, soweit notwendig, automatisch in das Zwinger-Profil der Zwinger-Gemeinschaft übernommen.',
                        'Uns ist bewusst, dass unsere Zwinger-Tätigkeit ruht, solange die neue Zuchtstätte nicht per Zuchtstätten-Besichtigung freigegeben ist.',
                        'Der Umzug der Zuchtstätte muss durch den DRC an den VDH gemeldet werden. Wir erhalten nach Rückgabe unserer bisherigen Karte an die DRC-Geschäftstelle eine neue VDH-Zwingerkarte.',
                        'Die neue VDH-Zwingerkarte ist kostenpflichtig. Der Betrag in Höhe von [Gebühr für neue Zwingerkarte] wird vom Konto des Melders abgebucht.'
                    );
                    break;
                case 8:
                    array_push(
                        $confirmations,
                        'Hiermit bestätigen wir die Richtigkeit der oben gemachten Angaben.',
                        'Der Wohnsitz der Zwinger-Inhaber stimmt mit der Zuchtstätten-Adresse überein. Diese wurde, soweit notwendig, automatisch in das Zwinger-Profil der Zwinger-Gemeinschaft übernommen.',
                        'Die neue Zuchtstätte ist bereits durch die Zuchtstätten-Besichtigung vom [xx.xx.xxxx] freigegeben.',
                        'Der Umzug der Zuchtstätte muss durch den DRC an den VDH gemeldet werden. Wir erhalten nach Rückgabe unserer bisherigen Karte an die DRC-Geschäftstelle eine neue VDH-Zwingerkarte.',
                        'Die neue VDH-Zwingerkarte ist kostenpflichtig. Der Betrag in Höhe von [Gebühr für neue Zwingerkarte] wird vom Konto des Melders abgebucht.'
                    );
                    break;
                case 9:
                    array_push(
                        $confirmations,
                        'Hiermit bestätigen wir die Richtigkeit der oben gemachten Angaben.',
                        'Der Wohnsitz der Zwinger-Inhaber stimmt mit der Zuchtstätten-Adresse überein.'
                    );
                    break;
                case 10:
                    array_push(
                        $confirmations,
                        'Hiermit bestätigen wir die Richtigkeit der oben gemachten Angaben.',
                        'Der Wohnsitz der Zwinger-Inhaber stimmt nicht mit der Zuchtstätten-Adresse überein.',
                        'Unsere 2. Wohnsitz-Nachweise für die Zuchtstätte sind mit der Änderungsmeldung am [xx.xx.xxxx] erfolgt und wurde am [xx.xx.xxxx] von der DRC-Geschäftsstelle bestätigt.'
                    );
                    break;
                case 11:
                    array_push(
                        $confirmations,
                        'Hiermit bestätigen wir die Richtigkeit der oben gemachten Angaben.',
                        'Mein neuer Wohnsitz entspricht der Zuchtstätten-Adresse der Zwinger-Gemeinschaft.',
                        'Die Genehmigung der (zum Teil) abweichenden Wohnsitze zur Zuchtstätte unserer Zwinger-Gemeinschaft ist am [xx.xx.xxxx] durch den DRC-Vorstand erfolgt.',
                        'Die neue Zuchtstätte ist bereits durch die Zuchtstätten-Besichtigung vom [xx.xx.xxxx] freigegeben.',
                        'Der Umzug der Zuchtstätte muss durch den DRC an den VDH gemeldet werden. Wir erhalten nach Rückgabe unserer bisherigen Karte an die DRC-Geschäftstelle eine neue VDH-Zwingerkarte.',
                        'Die neue VDH-Zwingerkarte ist kostenpflichtig. Der Betrag in Höhe von [Gebühr für neue Zwingerkarte] wird vom Konto des Änderungsmelders abgebucht.'
                    );
                    break;
                case 12:
                    array_push(
                        $confirmations,
                        'Hiermit bestätigen wir die Richtigkeit der oben gemachten Angaben.',
                        'Mein neuer Wohnsitz entspricht der Zuchtstätten-Adresse der Zwinger-Gemeinschaft.',
                        'Die Genehmigung der (zum Teil) abweichenden Wohnsitze zur Zuchtstätte unserer Zwinger-Gemeinschaft ist am [xx.xx.xxxx] durch den DRC-Vorstand erfolgt.',
                        'Uns ist bewusst, dass unsere Zwinger-Tätigkeit ruht, solange die neue Zuchtstätte nicht per Zuchtstätten-Besichtigung freigegeben ist.',
                        'Der Umzug der Zuchtstätte muss durch den DRC an den VDH gemeldet werden. Wir erhalten nach Rückgabe unserer bisherigen Karte an die DRC-Geschäftstelle eine neue VDH-Zwingerkarte.',
                        'Die neue VDH-Zwingerkarte ist kostenpflichtig. Der Betrag in Höhe von [Gebühr für neue Zwingerkarte] wird vom Konto des Änderungsmelders abgebucht.'
                    );
                    break;
                case 13:
                    array_push(
                        $confirmations,
                        'Hiermit bestätigen wir die Richtigkeit der oben gemachten Angaben.',
                        'Mein neuer Wohnsitz entspricht der Zuchtstätten-Adresse der Zwinger-Gemeinschaft.'
                    );
                    break;
                case 14:
                    array_push(
                        $confirmations,
                        'Hiermit bestätigen wir die Richtigkeit der oben gemachten Angaben.',
                        'Mein neuer Wohnsitz entspricht nicht dem Wohnsitz und Zuchtstätten-Adresse der Zwinger-Gemeinschaft.',
                        'Die Genehmigung meines abweichenden Wohnsitzes von der Zuchtstätten-Adresse unserer Zwinger-Gemeinschaft ist am [xx.xx.xxxx] durch den DRC-Vorstand erfolgt.',
                        'Der Nachweis meines Verwandtschaftsgrades 1 zum/zu den Zwinger-Mitinhaber/ ist am [xx.xx.xxxx] erfolgt und wurde von der DRC-Geschäftsstelle am [xx.xx.xxxx] bestätigt.',
                        'Der Nachweis meines 2. Wohnsitzes an der Adresse der/s Zwinger-Mitinhaber/s und somit der Zuchtstätten-Adresse ist am [xx.xx.xxxx] erfolgt und wurde von der DRC-Geschäftsstelle am [xx.xx.xxxx] bestätigt.'
                    );
                    break;
                case 15:
                    array_push(
                        $confirmations,
                        'Hiermit bestätigen wir die Richtigkeit der oben gemachten Angaben.',
                        'Mein neuer Wohnsitz entspricht nicht dem Wohnsitz und Zuchtstätten-Adresse der Zwinger-Gemeinschaft.',
                        'Die Genehmigung meines abweichenden Wohnsitzes von der Zuchtstätten-Adresse unserer Zwinger-Gemeinschaft ist am [xx.xx.xxxx] durch den DRC-Vorstand erfolgt.',
                        'Der Nachweis meines Verwandtschaftsgrades 1 zum/zu den Zwinger-Mitinhaber/n ist am [xx.xx.xxxx] erfolgt und wurde von der DRC-Geschäftsstelle am [xx.xx.xxxx] bestätigt.',
                        'Der Nachweis meines 2. Wohnsitzes an der Adresse der/s Zwinger-Mitinhaber/s und somit der Zuchtstätten-Adresse ist am [xx.xx.xxxx] erfolgt und wurde von der DRC-Geschäftsstelle am [xx.xx.xxxx] bestätigt.'
                    );
                    break;
                case 16:
                    array_push(
                        $confirmations,
                        'Hiermit bestätigen wir die Richtigkeit der oben gemachten Angaben.',
                        'Uns ist bewusst, dass unsere Zwinger-Tätigkeit beim DRC ruht, solange der Wohnsitz aller Zwinger-Mitinhaber sowie die Adresse der Zuchtstätte nicht übereinstimmen bzw. wir für die Zuchtstätte keinen 2. Wohnsitz nachweisen können.'
                    );
                    break;
                case 17:
                    array_push(
                        $confirmations,
                        'Hiermit bestätigen wir die Richtigkeit der oben gemachten Angaben.',
                        'Uns ist bewusst, dass unsere Zwinger-Tätigkeit beim DRC ruht, solange sich einer unserer Wohnsitze außerhalb Deutschlands befindet.',
                        'Unsere original Zwingerschutzkarte haben wir an die DRC-Geschäftsstelle zur Weiterleitung an den VDH geschickt. Wir erhalten eine Abmeldebstätigung mit der wir uns bei unserem zukünftigen FCI-Zuchtverein anmelden können. Von diesem erhalten wir dann auch unsere neue Zwingerschutzbescheinigung.'
                    );
                    break;
                default:
                    // code...
                    break;
            }

            return $confirmations;
        }

        $caseId = 3;
        $confirmations = generateConfirmations($caseId);
        $generatedHeadlines = generateHeadlines($changedData);

        return $this->renderPdf(
            'dokumente.aenderungsmeldung-kontaktdaten',
            [
                'caseId' => $caseId,
                'confirmations' => $confirmations,
                'changedData' => $changedData,
                'sectionheadlineChangedData' => $generatedHeadlines[1],
            ],
            '[{"text": "Änderungsmeldung","smaller": false},{"text": "Kontaktdaten","smaller": false}]',
            $generatedHeadlines[0],
            '[{"text": "Änderungsmeldung","smaller": false},{"text": "Kontaktdaten","smaller": false}]',
            null
        );
    }
}

// class Person
// {
//     private $id;
//     private $address;
//     private $secondaryResidences;

//     public function __construct($id, $address, $secondaryResidences = [])
//     {
//         $this->id = $id;
//         $this->address = $address;
//         $this->secondaryResidences = $secondaryResidences;
//     }

//     public function getId()
//     {
//         return $this->id;
//     }

//     public function getAddress()
//     {
//         return $this->address;
//     }

//     public function setAddress($address)
//     {
//         $this->address = $address;
//     }

//     public function getSecondaryResidences()
//     {
//         return $this->secondaryResidences;
//     }

//     public function setSecondaryResidences($secondaryResidences)
//     {
//         $this->secondaryResidences = $secondaryResidences;
//     }
// }

// class Move
// {
//     public $person;
//     public $oldAddress;
//     public $newAddress;
//     public $zwinger;

//     public function __construct($person, $newAddress, $zwinger = null)
//     {
//         $this->person = $person;
//         $this->oldAddress = $person->getAddress();
//         $this->newAddress = $newAddress;
//         $this->zwinger = $zwinger;
//     }

//     public function execute()
//     {
//         $this->person->setAddress($this->newAddress);
//         if ($this->zwinger) {
//             $this->zwinger->setAddress($this->newAddress);
//         }
//         return "Address changed from {$this->oldAddress} to {$this->newAddress}.";
//     }
// }

// class Zwinger
// {
//     public $id;
//     private $address;
//     private $relatedPersons = [];

//     public function __construct($id, $address, $relatedPersons)
//     {
//         $this->id = $id;
//         $this->address = $address;
//         $this->relatedPersons = $relatedPersons;
//     }

//     public function getId()
//     {
//         return $this->id;
//     }

//     public function addRelatedPerson(Person $person)
//     {
//         $this->relatedPersons[] = $person;
//     }

//     public function getRelatedPersons()
//     {
//         return $this->relatedPersons;
//     }

//     public function getAddress()
//     {
//         return $this->address;
//     }

//     public function setAddress($address)
//     {
//         $this->address = $address;
//     }
// }

// class AenderungsmeldungKontaktdatenController extends TemplateBaseController
// {

//     function checkMove(Move $move, $persons)
//     {
//         if (!is_array($persons)) {
//             throw new Exception("{gettype($persons)} was passed Array of Person expected", 1);
//         }

//         $isValidMove = false;

//         $movedToAddress = $move->newAddress;

//         $counter = 0;
//         $invalidPersons = [];
//         foreach ($persons as $index => $person) {
//             if ($person->getAddress() == $movedToAddress) {
//                 $counter++;
//                 // dd("1");
//             } else if (in_array($movedToAddress, $person->getSecondaryResidences())) {
//                 $counter++;
//             } else {
//                 array_push($invalidPersons, $person);
//             }
//         }

//         if ($counter == count($persons)) {
//             $isValidMove = true;
//         }

//         return ["isValid" => $isValidMove, "persons" => count($persons), "validPersons" => $counter, "invalidPersons" => $invalidPersons];
//     }

//     function show()
//     {
//         $person1 = new Person(1, 'A', []);
//         $person2 = new Person(2, 'A', []);
//         $person3 = new Person(3, 'B', []);
//         $mitinhaber_list = [$person1, $person2, $person3];

//         $zwinger = new Zwinger(1, 'A', $mitinhaber_list);

//         $move = new Move($person3, 'B');
//         $move->execute();

//         dd($this->checkMove($move, $mitinhaber_list));

//         function generateConfirmationsForMove(Move $move, ?Zwinger $compareToZwinger = null)
//         {
//             // if: person moves with the zwinger
//             //// check if the other persons have the 'newAddress' from the move in their list of secondaryResidences

//             // if: person moves without the zwinger

//             // if: the person moves to the same address as the zwinger -> add comment for later

//             // if: the person's old address was the same as the zwinger's but now is not anymore
//             //// check if the person has the zwinger's address in its list of secondaryResidences

//             // if: the person's old address was not at the zwinger and the new is not too
//             //// check if the person  has the zwinger's address in its list of secondaryResidences

//             $confirmations = [];
//             if ($move->zwinger) {
//                 // CASE-ID: 11 oder 12
//                 foreach ($move->zwinger->getRelatedPersons() as $relatedPerson) {
//                     if (in_array($move->newAddress, $relatedPerson->getSecondaryResidences())) {
//                         $a = "Die Adresse des Zwingers {$move->zwinger->getId()} wurde von {$relatedPerson->getId()} bestätigt.";
//                         array_push($confirmations, $a);
//                     }
//                 }
//             } else {
//                 // CASE-ID: 13, 14, 15, 16
//                 if ($move->oldAddress == $compareToZwinger->getAddress()) {
//                     // CASE-ID: 14
//                     // Person zieht von Zwinger weg
//                     array_push($confirmations, "CASE 14");
//                 } else if (in_array($compareToZwinger->getAddress(), $move->person->getSecondaryResidences())) {
//                     $confirmations[] = "Die alte Adresse des Users {$move->person->getId()} war die gleiche wie die Adresse des Zwingers {$compareToZwinger->getId()}.";
//                 } elseif ($move->oldAddress != $compareToZwinger->getAddress() && !in_array($compareToZwinger->getAddress(), $move->person->getSecondaryResidences())) {
//                     $confirmations[] = "Die alte Adresse des Users {$move->person->getId()} war nicht die gleiche wie die Adresse des Zwingers {$compareToZwinger->getId()}.";
//                 }
//             }

//             return $confirmations;
//         }

//         $confirmations = $this->checkMove($move, $mitinhaber_list);
//         // $confirmations = generateConfirmationsForMove($move, $zwinger);
//         return $this->renderPdf(
//             'dokumente.aenderungsmeldung-kontaktdaten',
//             [
//                 'confirmations' => $confirmations
//             ],
//             '[{"text": "Änderungsmeldung","smaller": false},{"text": "Kontaktdaten","smaller": false}]',
//             null
//         );
//     }
// }
