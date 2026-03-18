<?php

namespace App\Http\Controllers\templates\oeffentlich;

use App\Http\Controllers\templates\TemplateBaseController;

class DnaProfilGentestFormularController extends TemplateBaseController
{
    public function show($formData)
    {
        $formData = json_decode($formData);

        return $this->renderPdf(
            'oeffentlich.dna-profil-gentest-formular',
            ['formData' => $formData],
            '[{"text": "DNA-Profil und Genotypisierung","smaller": false}]',
            '– Probeneinsendung und Untersuchungsauftrag –',
            '[{"text": "DNA-Profil und Genotypisierung","smaller": false}]',
            '– Probeneinsendung und Untersuchungsauftrag –',
        );
    }
}
