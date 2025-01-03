<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Classwork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class ClassworkController extends Controller
{

    protected function getType(Request $request)
    {
        $type = $request->query('type');
        $allowed_types = [
            Classwork::TYPE_ASSIGNEMNT,
            Classwork::TYPE_MATERIAL,
            Classwork::TYPE_QUESTION
        ];
        if (!in_array($type, $allowed_types)) {
            $type = Classwork::TYPE_ASSIGNEMNT;
        }
        return $type;
    }

    public function index(Classroom $classroom)
    {
        $classworks = $classroom->classworks()
            ->orderBy('published_at')
            ->get();

        return view('classworks.index', [
            'classroom' => $classroom,
            'classworks' => $classworks,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, Classroom $classroom)
    {
        $type =  $type = $this->getType($request);

        return view('classworks.create', compact('classroom', 'type'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Classroom $classroom)
    {
        $type =  $type = $this->getType($request);
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:assignment,material,question',
            'status' => 'required|in:published,draft',
            'published_at' => 'nullable|date',
        ]);

        $request->merge([
            'user_id' => Auth::id(),
            'classroom_id' => $classroom->id,
            'type' => $type,
        ]);

        $classwork = $classroom->classworks()->create($request->all());
        return redirect()->route('classrooms.classwork.index', $classroom->id)
            ->with('success', 'classwork created!');
    }

    public function show(Classroom $classroom, Classwork $classwork)
    {
        
        $classwork->load('comments.user'); // جلب التعليقات مع بيانات المستخدمين المرتبطة
        return view('classworks.show', compact('classroom', 'classwork'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Classroom $classroom, Classwork $classwork)
    {
        return view('classworks.edit', compact('classroom', 'classwork'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Classroom $classroom, Classwork $classwork)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:assignment,material,question',
            'status' => 'required|in:published,draft',
            'published_at' => 'nullable|date',
        ]);

        $classwork->update([
            'topic_id' => $request->input('topic_id'),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'type' => $request->input('type'),
            'status' => $request->input('status'),
            'published_at' => $request->input('published_at'),
            'options' => $request->input('options') ? json_encode($request->input('options')) : null,
        ]);

        return redirect()->route('classrooms.classwork.index', $classroom)
            ->with('success', 'Classwork updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Classroom $classroom, Classwork $classwork)
    {
        $classwork->delete();

        return redirect()->route('classrooms.classwork.index', $classroom)
            ->with('success', 'Classwork deleted successfully.');
    }
}
