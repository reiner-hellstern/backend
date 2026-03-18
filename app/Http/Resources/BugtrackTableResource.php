<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BugtrackTableResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $status = $this->closed == '1' ? 'erledigt' : 'offen';

        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'author' => $this->author,
            'page_name' => $this->page_name,
            'text' => $this->text,
            'status' => $status,
            'closed' => $status,
            'erstellt' => $this->created_at,
            'url' => $this->url,
            'geaendert' => $this->updated_at,
            // 'mutter' => HundResource::collection(Hund::where('id', $this->mutter_id)->get()),
            // 'vater' => HundResource::collection(Hund::where('id', $this->vater_id)->get())

        ];
    }
}
