<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\Scopes\UserClassroomScope;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Classroom extends Model
{
    use HasFactory, SoftDeletes; // إضافة السمة

    public function classworks(): HasMany
    {
        return $this->hasMany(Classwork::class, 'classroom_id', 'id');
    }
    public function topic() :HasMany
    {
        return $this->hasMany(Topic::class, 'classroom_id', 'id');
    }

    public function users()
    {
        return $this->belongsToMany(
        User::class,            //Related model
        'classroom_user',       //Pivot table
        'classroom_id',         //Fk for current mode in the pivot table
        'user_id',              //Fk for realted mode in the pivot table    
        'id',                   // PK for current model
        'id'
    );                  //PK for related model    
    }
    public function teacher()
    {
        return $this->users()->wherePivot('role', '=' , 'teacher');
    }
    public function student()
    {
        return $this->users()->wherePivot('role', '=' , 'student');
    }

    protected $fillable = [
        'name',
        'secione',
        'subject',
        'room',
        'code',
        'cover_image_path',
        'theme',
        'user_id',
        'status',
    ];


    protected static function boot()
    {
        parent::boot();

        // static::addGlobalScope('user',function(Builder $query){
        //     $query->where('user_id','=',Auth::id()); 
        // });


        static::addGlobalScope(new UserClassroomScope);
    }

    public function getRouteKeyName()
    {
        return 'id';
    }
    public function ScopeActive(Builder $query)
    {
        $query->where('status', '=', 'active');
    }
    public function scopeRecent(Builder $query)
    {
        $query->orderBy('updated_at', 'DESC'); // تأكد من استخدام updated_at
    }
    public function ScopeStatus(Builder $query, $status)
    {
        $query->where('status', '=', $status);
    }


    public function join($user_id, $role = 'student')
    {
        $this->users()->attach($user_id,[
        'role' => $role,
            'created_at' => now()
        ]);
        // DB::table('classroom_user')->insert([
        //     'classroom_id' => $this->id,
        //     'user_id' => $user_id,
        //     'role' => $role,
        //     'created_at' => now()
        // ]);
    }
    //get{AttributeName}Attribute
    public function getNameAttribute($value)
    {
        return strtoupper($value);
    }
    public function getSecioneAttribute($value)
    {
        return ucfirst($value);
    }
    public function getCoverImagePathAttribute($value)
    {
        return $value ? asset('storage/' . $value) : asset('storage/images/classroom.jpg');
    }
}
