<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AnwartschaftTypResource extends JsonResource
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
        $land = $this->land ? ' / ' . $this->land : '';

        return [
            'id' => $this->id,
            'name' => $this->name . ' (' . $this->name_kurz . ' / ' . $this->verband_verein . $land . ' )',
        ];
    }
}
