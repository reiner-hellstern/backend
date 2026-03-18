<?php

namespace App\Http\Resources;

use App\Models\ProfileDokumenteItem;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileDokumenteItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'title' => $this->title,
            'order' => $this->order,
            'to' => $this->to,
            'icon' => $this->icon,
            'items' => ProfileDokumenteItemResource::collection(ProfileDokumenteItem::orderBy('order')->where('parent_id', $this->id)->get()),
        ];

        return parent::toArray($request);
    }
}
