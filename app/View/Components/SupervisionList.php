<?php

namespace App\View\Components;

use App\Models\Person;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Helper class to easily list Persons of different kinds inside SupervisionList
 */
class SupervisionListElement
{
    public function __construct(?string $vorname = null, ?string $nachname = null, ?string $amtstitel = null, ?string $vrnr = null)
    {
        $this->vorname = $vorname;
        $this->nachname = $nachname;
        $this->amtstitel = $amtstitel;
        $this->vrnr = $vrnr;
    }
}

class SupervisionList extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public int $pruefungsLeiterId = -1,
        public int $richterObmannId = -1,
        public string $richterIds = '',
    ) {}

    public function getPersonsFromDB(): array
    {
        $supervisionPersons = [];

        if ($this->pruefungsLeiterId != -1) {
            // Get Prüfungsleiter
            $personDbEntry = Person::where('id', $this->pruefungsLeiterId)->first();
            $person = new SupervisionListElement(
                vorname: $personDbEntry->vorname,
                nachname: $personDbEntry->nachname,
                amtstitel: 'Prüfungsleiter',
                vrnr: 'TODO',
            );

            array_push($supervisionPersons, $person);
        }
        if ($this->richterObmannId != -1) {
            // Get Prüfungsleiter
            $personDbEntry = Person::where('id', $this->richterObmannId)->first();
            $person = new SupervisionListElement(
                vorname: $personDbEntry->vorname,
                nachname: $personDbEntry->nachname,
                amtstitel: 'Richterobmann',
                vrnr: 'TODO',
            );

            array_push($supervisionPersons, $person);
        }

        if ($this->richterIds != '') {
            $decode = json_decode($this->richterIds, true);
            // Get Richter (multiple)
            foreach ($decode as $richterId) {
                $personDbEntry = Person::where('id', $richterId)->first();
                $person = new SupervisionListElement(
                    vorname: $personDbEntry->vorname,
                    nachname: $personDbEntry->nachname,
                    amtstitel: 'Richter',
                    vrnr: 'TODO',
                );

                array_push($supervisionPersons, $person);
            }
        }

        return $supervisionPersons;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $persons = $this->getPersonsFromDB();
        $data = [];
        for ($i = 0; $i < count($persons); $i++) {
            array_push($data, [
                'vorname' => $persons[$i]->vorname,
                'nachname' => $persons[$i]->nachname,
                'amtstitel' => $persons[$i]->amtstitel,
                'vrnr' => $persons[$i]->vrnr,
            ]);
        }

        return view('pdf.components.supervision-list', [
            'persons' => $data,
        ]);
    }
}
