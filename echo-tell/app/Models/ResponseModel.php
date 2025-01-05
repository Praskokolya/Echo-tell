<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResponseModel extends Model
{
    protected $table = 'responses';
    protected $fillable = [
        'response',
        'question_id',
        'user_id',
        'user_name',
        'name_visibility'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function question(){
        return $this->belongsTo(QuestionsModel::class, 'question_id');
    }
}
