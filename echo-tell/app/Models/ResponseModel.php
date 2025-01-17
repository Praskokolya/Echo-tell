<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponseModel extends Model
{
    use HasFactory;

    protected $table = 'responses';
    protected $fillable = [
        'response',
        'question_id',
        'user_id',
        'user_name',
        'name_visibility'
    ];

    public function getUserNameAttribute()
    {
        if (isset($this->attributes['name_visibility']) && $this->attributes['name_visibility'] == 1) {
            return $this->attributes['user_name'];
        }
        return 'Anonymous';

    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function question()
    {
        return $this->belongsTo(QuestionsModel::class, 'question_id');
    }
}
