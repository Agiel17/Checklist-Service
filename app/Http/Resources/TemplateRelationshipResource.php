<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TemplateRelationshipResource extends JsonResource
{
    
    public function toArray($request){
        return [
            'items'   => [
                'links' => [
                    'self'    => route('checklist.relationships.item', ['checklist_id' => $this->checklist_id]),
                    'related' => route('item.index', ['checklist_id' => $this->checklist_id]),
                ],
                'data'  => ItemIdentifierResource::collection($this->item),
            ],
        ];
    }
}