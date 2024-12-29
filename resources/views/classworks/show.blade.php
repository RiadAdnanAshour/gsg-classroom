@extends('layouts.master')
@section('title', 'View Classwork')
@section('content')

    <div class="container">
        <h1>Classwork Details</h1>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Title: {{ $classwork->title }}</h5>
                <p class="card-text">Description: {{ $classwork->description }}</p>
                <p class="card-text">Type: {{ ucfirst($classwork->type) }}</p>
                <p class="card-text">Status: {{ ucfirst($classwork->status) }}</p>
                <p class="card-text">
                    Published At:
                    {{ $classwork->published_at ? \Carbon\Carbon::parse($classwork->published_at)->format('Y-m-d') : 'N/A' }}
                </p>
            </div>
        </div>

        <h3 class="mt-4">Comments</h3>
        @if ($classwork->comments->isEmpty())
            <p>No comments available.</p>
        @else
            <ul class="list-group">
                @foreach ($classwork->comments as $comment)
                <li class="list-group-item">
                    <strong>{{ $comment->user->name ?? 'Anonymous' }}</strong>: 
                    {{ $comment->content }}
                    <br>
                    <small class="text-muted">Time: {{ $comment->created_at->format('Y-m-d H:i') }}</small>
                </li>
            @endforeach
            </ul>
        @endif

        <h3 class="mt-4">Add a Comment</h3>
        <form action="{{ route('comments.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="content" class="form-label">Your Comment</label>
                <textarea name="content" id="content" class="form-control" rows="3" required></textarea>
            </div>
            <input type="hidden" name="commentable_id" value="{{ $classwork->id }}">
            <input type="hidden" name="commentable_type" value="App\Models\Classwork">
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        

    @endsection
