<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    public function toArray($request): array
    {
        $res = $this->resource;  // Або  $this->resource->getId(),
        return [
            'id' => $res->getId(),
            'name' => $res->getName(),
            'year' => $res->getYear(),
            'lang' => $res->getLang(),
            'pages' => $res->getPages(),
            'category' => new CategoryResource($res->getCategory()),
            'created_at' => $res->getCreatedAt(),
            'updated_at' => $res->getUpdatedAt(),
        ];
    }
}

