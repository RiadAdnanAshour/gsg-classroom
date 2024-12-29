<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use Illuminate\Support\Facades\Log; // إضافة هذه السطر


class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'content' => ['required', 'string'],
            'commentable_id' => ['required', 'int'],
            'commentable_type' => ['required', 'in:App\Models\Classwork'], // تأكد من أن هذا النوع متوافق مع النماذج لديك
        ]);

        

        // إضافة تعليق
        $comment=  Auth::user()->comments()->create([
            'content' => $request->input('content'),
            'commentable_id' => $request->input('commentable_id'),
            'commentable_type' => $request->input('commentable_type'),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
        // dd($comment); 
        return back()->with('success', 'Comment added successfully');
    }
}