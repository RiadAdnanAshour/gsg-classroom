<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\Classroom;
use App\Models\User;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class TopicsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all topics ordered by the latest
        $topics = Topic::latest()->get();
        $users = User::all(); // Adjust this to your actual users model

        // Assuming you have a Classroom model or similar that will allow you to get classrooms for a dropdown or other use
        $classrooms = Classroom::all(); // Replace 'Classroom' with your actual model if it's different
    
        return view('topics.index', compact('topics', 'classrooms','users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classrooms = Classroom::all(); // Adjust this to your actual classrooms model
        $users = User::all(); // Adjust this to your actual users model
        return view('topics.create', compact('classrooms', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'classroom_id' => 'required|exists:classrooms,id',
            'user_id' => 'nullable|exists:users,id',
        ]);

        DB::beginTransaction();
        try {
            $topic = Topic::create($validatedData);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage())->withInput();
        }

        return redirect()->route('topics.index')->with('success', 'Topic created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Topic $topic)
    {
  
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Topic $topic)
    {
        $classrooms = Classroom::all(); // Adjust this to your actual classrooms model
        $users = User::all(); // Adjust this to your actual users model
        return view('topics.edit', compact('classrooms', 'users', 'topic'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Topic $topic): RedirectResponse
    {
        $classrooms = Classroom::all(); // Adjust this to your actual classrooms model
        $users = User::all(); // Adjust this to your actual users model
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'classroom_id' => 'nullable|exists:classrooms,id',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $topic->update($validatedData);

        return redirect()->route('topics.index')->with('success', 'Topic updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Topic $topic): RedirectResponse
    {
        $topic->delete();

        return redirect()->route('topics.index')->with('success', 'Topic deleted successfully.');
    }

    public function trashed()
    {
        $topics = Topic::onlyTrashed()->latest('deleted_at')->get();
        return view('topics.trashed', compact('topics'));
    }

    public function restore($id)
    {
        $topic = Topic::onlyTrashed()->findOrFail($id);
        $topic->restore();

        return redirect()->route('topics.index')->with('success', "Topic ({$topic->name}) restored successfully.");
    }

    public function forceDelete($id)
    {
        $topic = Topic::withTrashed()->findOrFail($id);
        $topic->forceDelete();

        return redirect()->route('topics.trashed')->with('success', "Topic ({$topic->name}) permanently deleted.");
    }
}