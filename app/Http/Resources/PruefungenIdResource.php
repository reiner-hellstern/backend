<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PruefungenIdResource extends JsonResource
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
            'id' => $this->veranstaltungstyp_id,
            'name' => $this->veranstaltungstyp->name,
        ];
    }
}
