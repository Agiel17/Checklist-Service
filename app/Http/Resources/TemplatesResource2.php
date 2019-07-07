<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

class TemplatesResource2 extends ResourceCollection
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
            'data' => TemplateResource2::collection($this->collection),
        ];
    }

    public function with($request)
    {
        $item = $this->collection->flatMap(
            function ($checklist) {
                return $checklist->item;
            }
        );
        return [
            'included' => $this->withIncluded($item),
        ];
    }

    private function withIncluded(Collection $included)
    {
        return $included->map(
            function ($include) {
                return new ItemResource($include);
            }
        );
    }

}