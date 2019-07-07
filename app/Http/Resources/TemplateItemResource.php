<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TemplateItemResource extends JsonResource
{
    public function toArray($request){
        $due = new \DateTime($this->due);
        $diff = $due->diff(new \DateTime());
        $due_interval = ($diff->days * 24 * 60) + ($diff->h * 60) + $diff->i;    
        return [
            'urgency'       => $this->urgency,
            'description'   => $this->description,
            'due_interval'  => $due_interval,
            'due_unit'      => 'minute',
        ];
    }
}