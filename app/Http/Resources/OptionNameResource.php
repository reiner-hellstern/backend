<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OptionNameResource extends JsonResource
{
    // public $preserveKeys = true;

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
        return $this->wert != null ? ['id' => $this->id, 'name' => $this->name, 'wert' => $this->wert] : ['id' => $this->id, 'name' => $this->name];
    }
}
