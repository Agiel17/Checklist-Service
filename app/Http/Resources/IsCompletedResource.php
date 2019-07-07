<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class IsCompletedResource extends JsonResource
{
    public function toArray($request){
        return [
            'id'    => $this->item_id,
            'item_id'    => $this->item_id,
            'is_completed'  => $this->is_completed == 0 ? false : true,
            'checklist_id'    => $this->checklist_id,
        ];
    }
}