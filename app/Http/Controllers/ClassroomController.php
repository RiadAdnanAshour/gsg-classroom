<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Scopes\UserClassroomScope;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classrooms = Classroom::active()
            ->recent()
            ->orderBy('created_at', 'DESC')
            ->withoutGlobalScope(UserClassroomScope::class)->get(); // return cloection
        session();
        return view('classrooms.index', compact('classrooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return "Create Classroom Page Loaded"; // رسائل التصحيح

        return view('classrooms.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // method 1
        // $classroom = new Classroom();
        // $classroom->name = $request->post('name');
        // $classroom->secione = $request->post('secione');
        // $classroom->subject = $request->post('subject');
        // $classroom->room = $request->post('room');
        // $classroom->code = Str::random(8);
        // $classroom->save(); //insert

        // method 2

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'secione' => 'nullable|string|max:255',
            'subject' => 'nullable|string|max:255',
            'room' => 'nullable|string|max:255',
            'cover_image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validatedData = $request->all();
        if ($request->hasFile('cover_image_path')) {
            $file = $request->file('cover_image_path'); // uplodedFile
            $path = $file->store('classroom_covers', 'public'); // حفظ الملف في مجلد 'images' داخل التخزين العام
            $validatedData['cover_image_path'] = $path; // حفظ مسار الملف داخل مصفوفة البيانات
        }
        $validatedData['code'] = Str::random(8);

        DB::beginTransaction();
        try {
            $classroom = Classroom::create($validatedData);
            $classroom->join(Auth::id(), 'teacher');

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage())->withInput();
        }
        // PRG: Post Redirect Get
        return redirect()->route('classrooms.index')->with('success', 'Classroom create successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Classroom $classroom)
    {
        // احصل على الفصل الدراسي بدون التحقق من 'user_id'
        // $classroom = Classroom::findOrFail($id);
        $invitation_link = URL::signedRoute('classrooms.join', [
            'classroom' => $classroom->id,
            'code' => $classroom->code,
        ]);

        return View::make('classrooms.show')->with([
            'classroom' => $classroom,
            'invitation_link' => $invitation_link,
        ]);
    
    }
    public function edit($id)
    {
        $classroom = Classroom::findOrFail($id);
        return view('classrooms.edit', compact('classroom'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $classroom = Classroom::findOrFail($id);

        // التحقق من المدخلات
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'secione' => 'nullable|string|max:255',
            'subject' => 'nullable|string|max:255',
            'room' => 'nullable|string|max:255',
            'cover_image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        // إذا تم رفع صورة جديدة، حذف الصورة القديمة
        if ($request->hasFile('cover_image_path')) {
            // حذف الصورة القديمة
            // if ($classroom->cover_image_path) {
            //     Storage::disk('public')->delete($classroom->cover_image_path);
            // }

            // تخزين الصورة الجديدة
            $file = $request->file('cover_image_path');
            $path = $file->store('classroom_covers', 'public');
            $validatedData['cover_image_path'] = $path; // حفظ المسار الجديد
        }

        // تحديث بيانات الصف
        $classroom->update($validatedData);

        // إعادة التوجيه مع رسالة
        return redirect()->route('classrooms.index')->with('success', 'Classroom updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        // العثور على الفصل باستخدام الـ ID
        $classrooms = Classroom::findOrFail($id);
        // حذف الصورة من التخزين
        $classrooms->status = "archived";
        $classrooms->save();
    
        if ($classrooms->cover_image_path) {
            Storage::disk('public')->delete($classrooms->cover_image_path);
        }
        // تنفيذ الحذف الناعم
        $classrooms->delete();

        // إعادة التوجيه بعد الحذف
        return redirect()->route('classrooms.index')->with('success', 'Classroom deleted successfully');
    }


    public function trashed()
    {
        // onlyTrashed بيرجع فقط العناصر الي تم حذفها 
        // latest بترتب حسب المحذوف اول 
        $classrooms = Classroom::onlyTrashed()->latest('deleted_at')->get();
        return view('classrooms.trashed', compact('classrooms'));
    }

    public function restore($id)
    {
        $classrooms = Classroom::onlyTrashed()->findOrFail($id);
        $classrooms->restore();

        $classrooms->status = 'active';
        $classrooms->save();
        return redirect()->route('classrooms.index')->with('success', "Classroom ({$classrooms->name}) restore successfully");
    }

    public function forDelete($id)
    {
        $classrooms = Classroom::withTrashed()->findOrFail($id);
        $classrooms->forceDelete();
        Storage::disk('public')->delete($classrooms->cover_image_path);

        return redirect()->route('classrooms.trashed')->with('success', "Classroom ({$classrooms->name}) force Delete successfully");
    }
}
