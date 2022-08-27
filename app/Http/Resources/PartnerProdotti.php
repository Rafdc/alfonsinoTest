<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PartnerProdotti extends JsonResource
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
            'id_associazione' => $this->id_associazione,
            'prezzo' => $this->prezzo,
            'partner' => $this->partner,
            'prodotto' => $this->prodotto
        ];
    }
}
