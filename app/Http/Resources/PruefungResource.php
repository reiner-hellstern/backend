<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PruefungResource extends JsonResource
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
            'resultable_id' => $this->resultable_id,
            'resultable_type' => $this->resultable_type,
            'module_vue' => $this->module_vue,
            'ort' => $this->ort,
            'datum' => $this->datum,
            'bestanden' => $this->bestanden,
            'extern' => $this->extern,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
            'classement_id' => $this->classement_id,
            'wertung_id' => $this->wertung_id,
            'ausrichter_id' => $this->ausrichter_id,
            'zusatz_id' => $this->zusatz_id,
            'name_voll' => $this->type->name_kurz . ' | ' . $this->type->name,
            'name' => $this->type->name,
            'name_kurz' => $this->type->name_kurz,
            'classement' => $this->classement,
            'wertung' => $this->wertung,
            'ausrichter' => $this->ausrichter,
            'zusatz' => $this->zusatz,
            'resultable' => $this->resultable,
            'name_template' => $this->type->name_template,
            'tags' => OptionNameWertlosResource::collection($this->type->tags),
            'classement_label' => $this->type->classement_label,
            'ausrichter_label' => $this->type->ausrichter_label,
            'wertung_label' => $this->type->wertung_label,
            'zusatz_label' => $this->type->zusatz_label,
            'jahr_label' => $this->type->jahr_label,
            'template_type' => $this->type->template_type,
            // 'optionen_classements' => OptionNameWertlosResource::collection($this->type->classements),
            // 'optionen_ausrichters' => OptionNameWertlosResource::collection($this->type->ausrichters),
            // 'optionen_zusatz' => OptionNameWertlosResource::collection($this->type->zusaetze),
            // 'optionen_wertung' => OptionNameWertlosResource::collection($this->type->wertungen),
            'dokumente' => $this->dokumente,
            'status' => $this->status,
            //    'optionen_classements' => OptionNameWertlosResource::collection($this->classements),
            //    'optionen_ausrichters' => OptionNameWertlosResource::collection($this->ausrichters),
            //    'optionen_zusatz' => OptionNameWertlosResource::collection($this->zusaetze),
            //    'optionen_wertung' => OptionNameWertlosResource::collection($this->wertungen),
        ];
    }
}
