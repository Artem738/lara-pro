<?php

namespace App\Http\Resources;

use App\Repositories\Categories\Iterators\CategoryIterator;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryIdNameResource extends JsonResource
{
    /**
     * Transform into array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        /** @var CategoryIterator $res */
        $res = $this->resource;
        return [
            'id' => $res->getId(),
            'name' => $res->getName(),
        ];

    }
}

