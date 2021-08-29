<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed id
 * @property mixed title
 * @property mixed description
 * @property mixed created_at
 * @property mixed user
 * @property mixed images
 */
class AdResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'    => $this->id,
            'title'  => $this->title,
            'description' => $this->description,
            'created_at' => $this->created_at->diffForHumans(),
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
            ],
            'images' => ImageResource::collection($this->images),
        ];
    }
}
