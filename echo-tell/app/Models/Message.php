<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Message extends Model
{
    use HasFactory, Notifiable, HasUuids, SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $table = 'messages';
    protected $appends = ['url'];

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

    public function url(): Attribute {
        return Attribute::make(
            get: function($value, array $attributes){
                return url('message', $attributes['id']);
            }  
        );
    }

    public function senderName(): Attribute
    {
        return Attribute::make(
            get: function ($value, array $attributes) {
                if (isset($attributes['name_visibility']) && ($attributes['name_visibility'] == 1)) {
                    return $value;
                }
                return 'Anonymous';
            }
        );
    }
}
