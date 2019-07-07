<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChecklistItemsResource extends JsonResource
{
    public function toArray($request){
        $due = new \DateTime($this->due);
        return [
            'type'          => 'checklist',
            'id'            => (string)$this->checklist_id,
            'attributes'    => [
                'object_domain' => $this->object_domain,
                'object_id'     => (string)$this->object_id,
                'description'   => $this->description,
                'is_completed'  => $this->is_completed == 0 ? false : true,
                'due'           => $due->format('Y-m-d\TH:i:s.u\Z'),
                'urgency'       => $this->urgency,
                'completed_at'  => $this->completed_at,
                'last_updated_by'    => $this->updated_by,
                'updated_at'    => $this->updated_at,
                'created_at'    => $this->created_at, 
                'items' => $this->item,           
            ],
            'links'         => [
                'self' => route('checklist.show', ['checklist_id' => $this->checklist_id]),
            ],
        ];   
    }
}