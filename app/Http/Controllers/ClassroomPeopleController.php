<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Http\Request;

class ClassroomPeopleController extends Controller
{
    public function index(Classroom $classroom)
    {
        

        return view('classrooms.people',compact(['classroom']));
    }
}
