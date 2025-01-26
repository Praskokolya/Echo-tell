<?php

namespace App\Models;

use Illuminate\Database\Console\DumpCommand;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class ResponseModel extends Model
{
    use HasFactory;

    protected $table = 'responses';
    protected $fillable = [
        'name_visibility',
        'question_id',
        'user_id',
        'user_name',
        'response',
    ];

    // public function nameVisibility(): Attribute{
    //     return Attribute::get(function ($attributes){
    //         return $attributes['name_visibility'];
    //     });
    // }
    public function userName(): Attribute
    {
        return Attribute::make(
            get: function($value, $attributes){
                $attributes['name_visibility'] = 0;
                if($attributes['name_visibility'] == 0){
                    return 'Anonymous';
                }
                return $value;
            }
        );
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
