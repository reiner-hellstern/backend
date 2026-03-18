<?php

namespace App\Http\Controllers\templates\dokumente;

use App\Http\Controllers\templates\TemplateBaseController;

class DummyWelpenKaeufer
{
    public function __construct(
        public string $firma,
        public string $vorname,
        public string $nachname,
        public string $strasse,
        public string $hausnummer,
        public ?string $adresszusatz,
        public string $wohnort,
        public string $postleitzahl,
        public string $land,
        public string $drc_mitgliedsnummer,
        public string $mitglied_seit,
        public string $geburtsdatum,
        public ?string $telefon_1,
        public string $email_1,
        public string $website
    ) {
        $this->adresse = $strasse . ' ' . $hausnummer;
        $this->telefon_1 = $telefon_1 ?? '+49 12345 67890';
    }
}

class WelpenkaeuferController extends TemplateBaseController
{
    public function show()
    {
        return $this->renderPdf(
            'dokumente.welpenkaeufer',
            [
                'welpenkaeufer' => [
                    new DummyWelpenKaeufer(
                        firma: 'HerzFürHunde GbR',
                        vorname: 'Peter',
                        nachname: 'Gebauer',
                        strasse: 'Hessestraße',
                        hausnummer: '17',
                        adresszusatz: null,
                        wohnort: 'Frankfurt (Oder)',
                        postleitzahl: '123546',
                        land: 'Deutschland',
                        drc_mitgliedsnummer: 'XXXXXXXXXXXXX',
                        mitglied_seit: '12.07.2007',
                        geburtsdatum: '30.11.1977',
                        telefon_1: null,
                        email_1: 'gebauer@herz-fuer-hunde.de',
                        website: 'herz-fuer-hunde.de'
                    ),
                    new DummyWelpenKaeufer(
                        firma: 'THATdog GmbH',
                        vorname: 'Sonja',
                        nachname: 'Drewniok',
                        strasse: 'Bergstraße',
                        hausnummer: '2',
                        adresszusatz: '2. Stock',
                        wohnort: 'Entenberg',
                        postleitzahl: '123546',
                        land: 'Deutschland',
                        drc_mitgliedsnummer: 'XXXXXXXXXXXXX',
                        mitglied_seit: '03.09.2022',
                        geburtsdatum: '04.04.1960',
                        telefon_1: null,
                        email_1: 'sonja@that-dog.net',
                        website: 'that-dog.net'
                    ),
                    new DummyWelpenKaeufer(
                        firma: 'Hund Katze Maus e.V.',
                        vorname: 'Ulf',
                        nachname: 'Döhler',
                        strasse: 'Maximiliangasse',
                        hausnummer: '217',
                        adresszusatz: '6. Stock',
                        wohnort: 'Berlin',
                        postleitzahl: '123546',
                        land: 'Deutschland',
                        drc_mitgliedsnummer: 'XXXXXXXXXXXXX',
                        mitglied_seit: '22.08.2013',
                        geburtsdatum: '18.02.1980',
                        telefon_1: null,
                        email_1: 'e-mail@adresse.de',
                        website: 'www.website.com'
                    ),
                    new DummyWelpenKaeufer(
                        firma: 'Retriever Vermittlunggesellschaft mbH',
                        vorname: 'Andrea',
                        nachname: 'Ackermann',
                        strasse: 'Haagerstr.',
                        hausnummer: '33',
                        adresszusatz: null,
                        wohnort: 'Passau',
                        postleitzahl: '123546',
                        land: 'Deutschland',
                        drc_mitgliedsnummer: 'XXXXXXXXXXXXX',
                        mitglied_seit: '22.08.2013',
                        geburtsdatum: '18.02.1980',
                        telefon_1: null,
                        email_1: 'e-mail@adresse.de',
                        website: 'www.website.com'
                    ),
                ],
            ],
            '[{"text": "Welpenkäufer","smaller": false}]',
            '– [Rasse], [X]-Wurf, [Welpen Name komplett] –',
            null,
            '– [Rasse], [X]-Wurf, [Welpen Name komplett] –',
        );
    }
}
