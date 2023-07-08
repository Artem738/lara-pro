<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'author' => $this->resource->author,
            'year' => $this->resource->year,
            'countPages' => $this->resource->countPages,
        ];
    }
}
