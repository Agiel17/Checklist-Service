<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TemplateChecklistResource extends JsonResource
{
    public function toArray($request){
        $due = new \DateTime($this->due);
        $diff = $due->diff(new \DateTime());
        $due_interval = $diff->h + ($diff->days * 24);    
        return [
            'description'   => $this->description,
            'due_interval'  => $due_interval,
            'due_unit'      => 'hour',
        ];
    }
}