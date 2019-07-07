<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChecklistResource extends JsonResource
{
    public function toArray($request){
        $due = new \DateTime($this->due);
        return [
            'type'  => 'checklist',
            'id'    => (string)$this->checklist_id,
            'attributes'    => [
                'object_domain' => $this->object_domain,
                'object_id'     => (string)$this->object_id,
                'task_id'       => $this->task_id,
                'description'   => $this->description,
                'is_completed'  => $this->is_completed == 0 ? false : true,
                'due'           => $due->format('Y-m-d\TH:i:s.u\Z'),
                'urgency'       => $this->urgency,
                'completed_at'  => $this->completed_at,
                'updated_by'    => $this->updated_by,
                'created_by'    => $this->created_by,
                'created_at'    => $this->created_at,
                'updated_at'    => $this->updated_at,
            ],
            'links'         => [
                'self' => route('checklist.show', ['checklist_id' => $this->checklist_id]),
            ],
        ];
    }
}