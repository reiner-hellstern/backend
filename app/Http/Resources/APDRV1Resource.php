<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class APDRV1Resource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $output = parent::toArray($request);

        $output['test1_ausfuehrung'] = $this->getOptionTest1();
        $output['test2_ausfuehrung'] = $this->getOptionTest2();
        $output['test3_ausfuehrung'] = $this->getOptionTest3();
        $output['test4_ausfuehrung'] = $this->getOptionTest4();

        $output['ausschlussgrund'] = $this->getOptionAusschlussgrund();

        return $output;
    }
}
