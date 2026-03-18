<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TitelResource extends JsonResource
{
    public function __construct($resource)
    {
        // Ensure you call the parent constructor
        parent::__construct($resource);
        $this->resource = $resource;

    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'hund_id' => $this->hund_id,
            'type_id' => $this->type_id,
            'veranstaltung_id' => $this->veranstaltung_id,
            'ort' => $this->ort,
            'jahr' => $this->jahr ? $this->jahr : '',
            'jahr_kurz' => $this->jahr ? "'" . substr($this->jahr, -2) : '',
            'datum' => $this->datum,
            'extern' => $this->extern,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
            'ausrichter_id' => $this->ausrichter_id,
            'name_voll' => $this->type->name_kurz . ' | ' . $this->type->name,
            'name' => $this->name,
            'name_kurz' => $this->name_kurz,
            'ausrichter' => $this->ausrichter,
            // 'name_template' => $this->type->name_template,
            'ausrichter_label' => $this->type->ausrichter_label,
            'optionen_ausrichters' => OptionNameWertlosResource::collection($this->type->ausrichters),
            'kategorie' => $this->type->kategorie,
            'feldbezeichner' => $this->type->feldbezeichner,
            'land' => $this->land,
            'antrag' => $this->antrag,
            'ahnentafeleintrag' => $this->type->ahnentafeleintrag,
            'status' => $this->status,
            'dokumente' => $this->dokumente,
            'tags' => OptionNameWertlosResource::collection($this->type->tags),
            'template_type' => $this->type->template_type,
            //    'optionen_classements' => OptionNameWertlosResource::collection($this->classements),
            //    'optionen_ausrichters' => OptionNameWertlosResource::collection($this->ausrichters),
            //    'optionen_zusatz' => OptionNameWertlosResource::collection($this->zusaetze),
            //    'optionen_wertung' => OptionNameWertlosResource::collection($this->wertungen),
        ];
    }
}
