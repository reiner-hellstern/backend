<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OptionNameWithPivotResource extends JsonResource
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
        return $this->pivot != null ? ['id' => $this->id, 'name' => $this->name, 'fixed' => $this->pivot->fixed] : ['id' => $this->id, 'name' => $this->name, 'fixed' => false];
    }
}
