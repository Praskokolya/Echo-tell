<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionsModel extends Model
{
    protected $fillable = [
        'question',
        'slug',
        'user_id',
        'user_name'
    ];
    
    protected $table = 'questions';

    protected $appends = ['url'];

    public function getUrlAttribute(){
        return url('question/' . $this->id . '/'.$this->slug);
    }

    // Question relationship with user
    public function user(){
        return $this->belongsTo(User::class);
    }
    
    public function responses(){
        return $this->hasMany(ResponseModel::class, 'question_id');
    }
    
}
