<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    public function toArray($request): array
    {
        $res = $this->resource;
        return [
            'id' => $res->getId(),
            'name' => $res->getName(),
            'year' => $res->getYear(),
            'lang' => $res->getLang(),
            'pages' => $res->getPages(),
            //'category' => new CategoryResource($res->getCategory()), //Switch Manual
            'category' => new CategoryIdNameResource($res->getCategory()),
            'createdAt' => $res->getCreatedAt(),
            'updatedAt' => $res->getUpdatedAt(),
        ];
    }
}

