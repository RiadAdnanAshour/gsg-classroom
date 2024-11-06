<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\Scopes\UserClassroomScope;
use Illuminate\Support\Facades\DB;

class Classroom extends Model
{
    use HasFactory, SoftDeletes; // إضافة السمة

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
        DB::table('classroom_user')->insert([
            'classroom_id' => $this->id,
            'user_id' => $user_id,
            'role' => $role,
            'created_at' => now()
        ]);
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
