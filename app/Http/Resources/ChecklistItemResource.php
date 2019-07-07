<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChecklistItemResource extends JsonResource
{
    public function toArray($request){
        $due = new \DateTime($this->due);
        return [
            'type'          => 'item',
            'id'            => (string)$this->item_id,
            'attributes'    => [
                'description'   => $this->description,
                'is_completed'  => $this->is_completed == 0 ? false : true,
                'completed_at'  => $this->completed_at,
                'due'           => $due->format('Y-m-d\TH:i:s.u\Z'),
                'urgency'       => $this->urgency,
                'updated_by'    => $this->updated_by,
                "created_by"    => $this->created_by,
                "checklist_id"  => $this->checklist_id,
                "assignee_id"   => $this->assignee_id,
                "task_id"       => $this->task_id,
                "deleted_at"    => $this->deleted_at,
                'created_at'    => $this->created_at, 
                'updated_at'    => $this->updated_at,
            ],
            'links'         => [
                'self' => route('item.show', ['item_id' => $this->item_id, 'checklist_id' => $this->checklist_id]),
            ],
        ];   
    }
}