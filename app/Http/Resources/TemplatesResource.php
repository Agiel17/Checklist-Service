<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TemplatesResource extends ResourceCollection
{
    public function __construct($resource)
    {
        $this->meta = [
            'count' => $resource->count(),
            'total' => $resource->total(),
        ];

        $resource = $resource->getCollection();

        parent::__construct($resource);
    }
    
    public function toArray($request){
        return [
            'meta' => $this->meta,
            'links' => [
                'first' => route("template.index")."?page[limit]=10&page[offset]=0",
                'last'=> route("template.index")."?page[limit]=10&page[offset]=10",
                'next'=> route("template.index")."?page[limit]=10&page[offset]=10",
                'prev'=> null,
            ],
            'data' => TemplateResource::collection($this->collection),
        ];
    }

}