<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    public function toArray($request){
        $due = new \DateTime($this->due);
        return [
            'type'  => 'item',
            'id'    => (string)$this->item_id,
            'attributes'    => [
                'description'   => $this->description,
                'is_completed'  => $this->is_completed == 0 ? false : true,
                'due'           => $due->format('Y-m-d\TH:i:s.u\Z'),
                'urgency'       => $this->urgency,
                'assignee_id'   => $this->assginee_id,
                'completed_at'  => $this->completed_at,
                'updated_at'    => $this->updated_at,
                'created_at'    => $this->created_at,
            ],
            'links'         => [
                'self' => route('item.show', ['checklist_id' => $this->checklist_id, 'item_id' => $this->item_id]),
            ],
        ];
    }
}