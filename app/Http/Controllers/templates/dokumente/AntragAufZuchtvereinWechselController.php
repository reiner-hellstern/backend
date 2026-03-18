<?php

namespace App\Http\Controllers\templates\dokumente;

use App\Http\Controllers\templates\TemplateBaseController;

class AntragAufZuchtvereinWechselController extends TemplateBaseController
{
    /**
     * @param  bool  $transferToGermanClub
     * @param  int|null  $zwingerschutzKarteDocumentId
     * @param  string  $transferringToCountry
     * @param  string|null  $transferringToClubName
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $transferToGermanClub = false;
        $transferringToClubName = 'LCD';

        return $this->renderPdf(
            'dokumente.antrag-auf-zuchtverein-wechsel',
            [
                'transferToGermanClub' => $transferToGermanClub,
                'zwingerschutzKarteDocumentId' => null,
                'transferringToCountry' => $transferToGermanClub ? 'Deutschland' : '[Land]',
                'transferringToClubName' => $transferringToClubName,
            ],
            '[{"text": "Antrag auf Zuchtverein-Wechsel","smaller": false}]',
            $transferToGermanClub ?
            ($transferringToClubName == 'GRC' || $transferringToClubName == 'LCD' ? "– Wechsel in den {$transferringToClubName} –" : '– Wechsel in einen VDH-Zuchtverein –')
            : '– Wechsel in einen ausländischen FCI-Zuchtverein –'
        );
    }
}
