<?php

namespace App\Http\Resources;

use App\Models\DoktreeItem;
use Illuminate\Http\Resources\Json\JsonResource;

class DoktreeItemResource extends JsonResource
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
            'index' => $this->index,
            'tag_id' => $this->tag_id,
            'title' => $this->title,
            'order' => $this->order,
            'to' => $this->to,
            'icon' => $this->icon,
            'color' => $this->color,
            'bookmark' => $this->bookmark,
            'items' => DoktreeItemResource::collection(DoktreeItem::orderBy('order')->where('parent_id', $this->id)->get()),
        ];

        return parent::toArray($request);
    }
}
