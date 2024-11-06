<?php

namespace App\Observers;

use App\Models\classroom;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ClassroomObserver
{
    /**
     * Handle the classroom "created" event.
     */
    public function creating(classroom $classroom): void
    {
        $classroom->code = Str::random(8);
        $classroom->user_id = Auth::id();
    }

    /**
     * Handle the classroom "updated" event.
     */
    public function updated(classroom $classroom): void
    {
        // 
    }

    /**
     * Handle the classroom "deleted" event.
     */
    public function deleting(Classroom $classroom): void
    {
        $classroom->status = 'archived';
        $classroom->save();
    }
    /**
     * Handle the classroom "restored" event.
     */
    public function restored(classroom $classroom): void
    {
        $classroom->status = 'active';
        $classroom->save();
    }

    /**
     * Handle the classroom "force deleted" event.
     */
    public function forceDeleted(classroom $classroom): void
    {
        classroom::deletedCoverImage($classroom->cover_image_path);
    }
}
