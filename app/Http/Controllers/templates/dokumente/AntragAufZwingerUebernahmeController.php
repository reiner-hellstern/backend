<?php

namespace App\Http\Controllers\templates\dokumente;

use App\Http\Controllers\templates\TemplateBaseController;

enum AntragAufZwingerUebernahmeTransferType: string
{
    case ForeignToDRC = 'foreign_to_drc';
    case OtherGermanRetrieverToDRC = 'other_german_retriever_to_drc';
    case VDHToDRC = 'vdh_to_drc';
}

class AntragAufZwingerUebernahmeController extends TemplateBaseController
{
    public function inferTransferType(?string $landBisherigerZuchtverein, ?string $nameBisherigerZuchtverein)
    {
        if ($landBisherigerZuchtverein != 'Deutschland') {
            return AntragAufZwingerUebernahmeTransferType::ForeignToDRC;
        } else {
            if ($nameBisherigerZuchtverein == 'LCD' || $nameBisherigerZuchtverein == 'GRC') {
                return AntragAufZwingerUebernahmeTransferType::OtherGermanRetrieverToDRC;
            } else {
                return AntragAufZwingerUebernahmeTransferType::VDHToDRC;
            }
        }
    }

    public function show($antragAufZwingerUebernahme)
    {
        $antragAufZwingerUebernahme = json_decode($antragAufZwingerUebernahme);
        $transferType = $this->inferTransferType($antragAufZwingerUebernahme->zwinger->land_bisheriger_zuchtverein, $antragAufZwingerUebernahme->zwinger->name_bisheriger_zuchtverein);

        // $transferType = AntragAufZwingerUebernahmeTransferType::ForeignToDRC;
        return $this->renderPdf(
            'dokumente.antrag-auf-zwinger-uebernahme',
            [
                'antragAufZwingerUebernahme' => $antragAufZwingerUebernahme,
                // 'antragstellerNeuzuechterseminarSystemBekannt' => true,
                // 'antragstellerAbweichenderWohnsitz' => true,
                // 'zuchtstaettenbesichtigungSystemBekannt' => $antragAufZwingerUebernahme->zwinger->zuchtstaettenbesichtigung_system_bekannt,
                'transferType' => $transferType,
                // 'zwingerschutzBescheinigungDocumentId' => $antragAufZwingerUebernahme->zwinger->zwingerschutz_bescheinigung_document_id,
            ],
            '[{"text": "Antrag auf Zwinger-Übernahme","smaller": false}]',
            '– Wechsel aus ' .
            (
                $transferType == AntragAufZwingerUebernahmeTransferType::ForeignToDRC ?
                'einem ausländischen FCI-Zuchtverein' :
                (
                    $transferType == AntragAufZwingerUebernahmeTransferType::OtherGermanRetrieverToDRC ?
                    'dem LCD/GRC' :
                    'einem VDH-Zuchtverein'
                )
            ) . ' –',
        );
    }
}
