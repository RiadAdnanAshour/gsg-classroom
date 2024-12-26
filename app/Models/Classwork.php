<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Classwork extends Model
{
    use HasFactory;
    const TYPE_ASSIGNEMNT = 'assignment';
    const TYPE_MATERIAL = 'material';
    const TYPE_QUESTION = 'question';

    const STATUS_PUBLISHED = 'published';
    const STATUS_DRAFT = 'draft';

    public function classroom() :BelongsTo
    {
        return $this->belongsTo(Classroom::class,'classroom_id','id');
    }

    public function topic():BelongsTo
    {
        return $this->belongsTo(Topic::class,'topic_id','id');
    }
    public function users()
    {
        return $this->belongsToMany(User::class)
        ->wherePivot(['grade','status','submitted_at','created_at'])
        ->using(ClassworkUser::class);
    }
    protected $fillable =
    [
        'classroom_id',
        'user_id',
        'topic_id',
        'title',
        'description',
        'type',
        'status',
        'published_at',
        'options'
    ];
}
