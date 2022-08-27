<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Ordini extends JsonResource
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
            'partner' => $this->partner,
            'totale' => $this->totale
        ];
    }
}
