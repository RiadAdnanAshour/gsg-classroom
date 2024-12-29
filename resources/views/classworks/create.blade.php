@extends('layouts.master')
@section('title', 'Create Classwork')
@section('content')

<div class="container">
    <h1>Create Classwork for {{ $classroom->name }}</h1>

    <!-- Form for creating new classwork -->
    <form action="{{ route('classrooms.classwork.store', [$classroom->id, $type]) }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control"></textarea>
        </div>

        <div class="form-group">
            <label for="type">Type</label>
            <select name="type" id="type" class="form-control">
                <option value="assignment" {{ $type === 'assignment' ? 'selected' : '' }}>Assignment</option>
                <option value="material" {{ $type === 'material' ? 'selected' : '' }}>Material</option>
                <option value="question" {{ $type === 'question' ? 'selected' : '' }}>Question</option>
            </select>
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control" required>
                <option value="published">Published</option>
                <option value="draft">Draft</option>
            </select>
        </div>

        <div class="form-group">
            <label for="published_at">Published At</label>
            <input type="date" name="published_at" id="published_at" class="form-control">
        </div>

        <!-- قائمة الأسماء مع زر الاختيار -->
        <div class="form-group">
            <label>Select People</label>
            <div class="form-check">
                @foreach ($classroom->users as $user)
                    <div>
                        <input class="form-check-input" type="checkbox" name="users[]" value="{{ $user->id }}" id="user-{{ $user->id }}" checked  >
                        <label class="form-check-label" for="user-{{ $user->id }}">
                            {{ $user->name }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Create</button>
    </form>
</div>

@endsection
