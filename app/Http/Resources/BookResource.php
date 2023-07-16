<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    public function toArray($request): array
    {
        //$resource = $this->resource;  // Щоб можна було не писати $this->resource далі а зразу  'id' => $resource->getId(),
        return [
            'id' => $this->resource->getId(),
            'name' => $this->resource->getName(),
            'year' => $this->resource->getYear(),
            'lang' => $this->resource->getLang(),
            'pages' => $this->resource->getPages(),
            'created_at' => $this->resource->getCreatedAt(),
            'updated_at' => $this->resource->getUpdatedAt(),
        ];
    }
}

