<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessagesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=> $this->id,
            'user_name' => $this->user->name,
            'text' => $this->message,
            'sender_name' => $this->sender_name,
            'type' => 'message',
            'created_at' => $this->created_at,
            'url' => $this->url
        ];
    }
}
