<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    // const CREATED_AT = 'created_at';
    // const UPDATED = 'update_at';

    // protected $connection = 'mysql';
    // protected $table = 'topics';
    // protected $priamryKey = 'id';
    // protected $keyType = 'int';
    // public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'name',
        'classroom_id',
        'user_id'
    ];
    
    
    public function classworks()
    {
        return $this->hasMany(Classwork::class, 'topic_id', 'id');
    }
}
