<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Scopes\UserClassroomScope;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JoinClassroomController extends Controller
{
    public function create($id)
    {
        $classroom = Classroom::withoutGlobalScope(UserClassroomScope::class)
            ->active()
            ->findOrFail($id);

        if ($this->exists($id, Auth::id())) {
            return redirect()->route('classrooms.show', $id);
        }

        return view('classrooms.join', compact('classroom'));
    }

    public function store(Request $request, $id)
    {
        $classroom = Classroom::withoutGlobalScope(UserClassroomScope::class)->active()->findOrFail($id);

        $request->validate([
            'role' => 'in:student,teacher'
        ]);

        if ($this->exists($id, Auth::id())) {
            return redirect()->route('classrooms.show', $id)
                ->with('message', 'You are already enrolled in this classroom.');
        }

        $classroom->join(Auth::id(), $request->input('role', 'student'));

        return redirect()->route('classrooms.show', $id)
            ->with('message', 'You have successfully joined the classroom.');
    }

    public function exists($classroom_id, $user_id)
    {
        return DB::table('classroom_user')
            ->where('classroom_id', $classroom_id)
            ->where('user_id', $user_id)
            ->exists();
    }
}
