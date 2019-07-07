<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class IsCompletedsResource extends ResourceCollection
{
    public function toArray($request){
        return [
            'data' => IsCompletedResource::collection($this->collection)
        ];
    }
}