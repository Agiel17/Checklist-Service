<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemIdentifierResource extends JsonResource
{
    public function toArray($request){
        return [
            'type'  => 'item',
            'id'    => (string)$this->item_id,
        ];
    }
}