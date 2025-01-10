<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ResponseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'question' => $this->question->question,
            'response' => $this->response,
            'question_id' => $this->question_id,
            'user_id' => $this->user_id,
            'user_name' => $this->user_name,
            'name_visibility' => $this->name_visibility,
            'created_at' => $this->created_at,
        ];
    }
}
