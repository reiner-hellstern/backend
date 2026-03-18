<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PruefungenTitelResource extends JsonResource
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
            'name' => $this->name,
            'name_kurz' => $this->name_kurz,
            'extern' => $this->extern,
        ];
    }
}
