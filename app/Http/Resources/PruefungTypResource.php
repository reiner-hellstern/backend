<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PruefungTypResource extends JsonResource
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
            'name_voll' => $this->name_kurz . ' | ' . $this->name,
            'name' => $this->name,
            'name_kurz' => $this->name_kurz,
            'template_type' => $this->template_type,
            'classement_label' => $this->classement_label,
            'wertung_label' => $this->wertung_label,
            'ausrichter_label' => $this->ausrichter_label,
            'zusatz_label' => $this->zusatz_label,
            'extern' => $this->extern,
            'optionen_classements' => OptionNameWertlosResource::collection($this->classements),
            'optionen_ausrichters' => OptionNameWertlosResource::collection($this->ausrichters),
            'optionen_zusatz' => OptionNameWertlosResource::collection($this->zusaetze),
            'optionen_wertung' => OptionNameWertlosResource::collection($this->wertungen),
            'tags' => OptionNameWertlosResource::collection($this->tags),
        ];
    }
}
