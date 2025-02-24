<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Response extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'responses';
    protected $fillable = [
        'name_visibility',
        'question_id',
        'user_id',
        'user_name',
        'response',
        'author_id'
    ];

    public function userName(): Attribute
    {
        return Attribute::make(
            get: function($value, $attributes){
                if (isset($attributes['name_visibility']) && $attributes['name_visibility'] == 1) {
                    return $value;
                }
                return 'Anonymous';
            }
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
}
