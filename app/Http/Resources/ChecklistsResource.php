<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ChecklistsResource extends ResourceCollection
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
                'first' => route("checklist.index")."?page[limit]=10&page[offset]=0",
                'last'=> route("checklist.index")."?page[limit]=10&page[offset]=10",
                'next'=> route("checklist.index")."?page[limit]=10&page[offset]=10",
                'prev'=> null,
            ],
            'data' => ChecklistResource::collection($this->collection),
        ];
    }

}