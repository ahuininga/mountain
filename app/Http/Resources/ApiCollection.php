<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ApiCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<\Illuminate\Support\Collection>
     * @SuppressWarnings("unused")
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
        ];
    }
}
