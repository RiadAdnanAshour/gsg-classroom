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
        return view('classrooms.join', compact('classroom'));
        $exists = $this->exists($id, Auth::id());

        if ($exists) {
            return redirect('classrooms.show', $id);
        }
        return view('classrooms.join', compact('classroom'));
    }

    public function store(Request $request, $id)
    {
        $classroom = Classroom::withoutGlobalScope(UserClassroomScope::class)->active()->findOrFail($id);

        $request->validate([
            'role' => 'in:student,teacher'
        ]);

        // تحقق من أن الفصل الدراسي موجود وفعال


        // التحقق مما إذا كان المستخدم موجودًا بالفعل في الفصل
        $exists = $this->exists($id, Auth::id());

        if ($exists) {
            // إذا كان المستخدم موجودًا بالفعل، نعيد توجيهه للصفحة المناسبة
            return redirect()->route('classrooms.show', $id)
                ->with('message', 'You are already enrolled in this classroom.');
        }

        // إضافة المستخدم إلى الفصل
        $classroom->join(Auth::id(), $request->input('role', 'student'));
  

        // توجيه المستخدم إلى صفحة الفصل بعد التسجيل بنجاح
        return redirect()->route('classrooms.show', $id)
            ->with('message', 'You have successfully joined the classroom.');
    }

    public function exists($classroom_id, $user_id)
    {
        DB::table('classroom_user')
            ->where('classroom_id', $classroom_id)
            ->where('user_id', $user_id)
            ->exists();
    }
}
