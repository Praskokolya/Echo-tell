<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
Use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasApiTokens, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $appends = ['url'];

    public function getUrlAttribute(){
        return url('profile',Str::slug($this->attributes['name']));
    }
    
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */

    // User model mutator

    public function setPasswordAttribute($value){
        $this->attributes['password'] = bcrypt($value);
    }

    // User relationship with questions 
    public function question(){
        return $this->hasMany(Question::class);
    }

    public function responses(){
        return $this->hasMany(Response::class);
    }
    
    public function messages(){
        return $this->hasMany(Message::class);
    }

    public function sentMessages(){
        return $this->hasMany(Message::class, 'sender_id');
    }
    
    public function settings(){
        return $this->hasOne(Setting::class);
    }
}
