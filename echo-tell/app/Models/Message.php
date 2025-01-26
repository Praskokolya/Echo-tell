<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Message extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'messages';
    protected $fillable = [
        'user_id',
        'message',
        'sender_id',
        'sender_name',
        'name_visibility',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function senderName(): Attribute
    {
        return Attribute::make(
            get: function ($value, array $attributes) {
                $attributes['name_visibility'] = 0;
                if ($attributes['name_visibility'] == 0) {
                    return 'Anonymous';
                }
                return $value;
            }
        );
    }
}
