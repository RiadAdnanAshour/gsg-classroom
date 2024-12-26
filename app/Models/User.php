<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

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
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function classrooms()
    {
        return $this->belongsToMany(
        Classroom::class,            //Related model
        'classroom_user',       //Pivot table
        'user_id',         //Fk for current mode in the pivot table
        'classroom_id',              //Fk for realted mode in the pivot table    
        'id',                   // PK for current model
        'id'
    );                  //PK for related model    
    }

    public function createdC1asssrooms()
    {
        return $this->hasMany(Classroom::class, 'user_id');
    }
    public function classwork()
    {
        return $this->belongsToMany(User::class)
        ->wherePivot(['grade','status','submitted_at','created_at'])
        ->using(ClassworkUser::class);
    }
}
