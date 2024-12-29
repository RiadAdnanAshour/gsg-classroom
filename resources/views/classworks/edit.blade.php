@extends('layouts.master')
@section('title', 'Edit Classwork')
@section('content')

<div class="container">
    <h1>Edit Classwork for {{ $classroom->name }}</h1>

    <form action="{{ route('classrooms.classwork.update', [$classroom->id, $classwork->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ $classwork->title }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control">{{ $classwork->description }}</textarea>
        </div>

        <div class="form-group">
            <label for="type">Type</label>
            <select name="type" id="type" class="form-control">
                <option value="assignment" {{ $classwork->type === 'assignment' ? 'selected' : '' }}>Assignment</option>
                <option value="material" {{ $classwork->type === 'material' ? 'selected' : '' }}>Material</option>
                <option value="question" {{ $classwork->type === 'question' ? 'selected' : '' }}>Question</option>
            </select>
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control" required>
                <option value="published" {{ $classwork->status === 'published' ? 'selected' : '' }}>Published</option>
                <option value="draft" {{ $classwork->status === 'draft' ? 'selected' : '' }}>Draft</option>
            </select>
        </div>

        <div class="form-group">
            <label for="published_at">Published At</label>
            <input type="date" name="published_at" id="published_at" class="form-control" 
                value="{{ $classwork->published_at ? \Carbon\Carbon::parse($classwork->published_at)->format('Y-m-d') : '' }}">
        </div>

        <button type="submit" class="btn btn-primary mt-3">Update</button>
        <a href="{{ route('classrooms.classwork.index', $classroom->id) }}" class="btn btn-secondary mt-3">Cancel</a>
    </form>
</div>

@endsection
