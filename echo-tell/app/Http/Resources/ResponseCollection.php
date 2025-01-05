<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ResponseCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'response' => $this->response,
            'question_id' => $this->question_id,
            'user_id' => $this->user_id,
            'user_name' => $this->name_visibility ? $this->user_name : 'Anonymous',
            'name_visibility' => $this->name_visibility,
        ];
    }
}
