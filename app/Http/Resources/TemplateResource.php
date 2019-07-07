<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TemplateResource extends JsonResource
{
    public function toArray($request){
        // dd($this->checklist, $this->item);
        return [
            'type' => 'template',
            'id' => $this->template_id,
            'attributes' => [
                'name' => $this->name,
                'checklist' => TemplateChecklistResource::collection($this->checklist),
                'items' => TemplateItemResource::collection($this->item),
            ]
        ];
    }

    public function with($request)
    {
        return [
            'links' => [
                'self' => route('template.show', ['template_id' => $this->template_id]),
            ],
        ];
    }
}