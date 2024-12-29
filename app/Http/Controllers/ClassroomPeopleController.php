<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Http\Request;

class ClassroomPeopleController extends Controller
{
    public function index(Classroom $classroom)
    {
        return view('classrooms.people', compact(['classroom']));
    }
    public function destroy(Request $request, Classroom $classroom)
    {
        $classroom->users()->detach($request->input('user_id'));

        return redirect()->route('classrooms.people', $classroom->id)->with('success', 'user removed!');
    }
}
