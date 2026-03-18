<?php

namespace App\Http\Resources;

use App\Models\OrgatreeItem;
use Illuminate\Http\Resources\Json\JsonResource;

class OrgatreeItemResource extends JsonResource
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
            'edit' => $this->edit,
            'download' => $this->download,
            'detail' => $this->detail,
            'print' => $this->print,
            'edit_to' => $this->edit_to,
            'edit_params' => $this->edit_parameter,
            'download_to' => $this->download_to,
            'download_params' => $this->download_parameter,
            'detail_to' => $this->detail_to,
            'detail_params' => $this->detail_parameter,
            'print_to' => $this->print_to,
            'print_params' => $this->print_parameter,
            'items' => OrgatreeItemResource::collection(OrgatreeItem::orderBy('order')->where('parent_id', $this->id)->get()),
        ];

        return parent::toArray($request);
    }
}
