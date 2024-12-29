<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = ['user_agent','morphs','ip','content','commentable','user_id'];
    protected $with = ['user'];
   // العلاقة مع المستخدم
   public function user()
   {
       return $this->belongsTo(User::class);
   }

    
   public function commentable()
   {
       return $this->morphTo();
   }


}
