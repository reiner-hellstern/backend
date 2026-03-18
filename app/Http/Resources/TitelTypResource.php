<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TitelTypResource extends JsonResource
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
            'ausrichter_label' => $this->ausrichter_label,
            'land' => $this->land,
            'kategorie' => $this->kategorie,
            'feldbezeichner' => $this->feldbezeichner,
            'ahnentafeleintrag' => $this->ahnentafeleintrag,
            'optionen_ausrichters' => OptionNameWertlosResource::collection($this->ausrichters),
            'tags' => OptionNameWertlosResource::collection($this->tags),
        ];
    }
}
