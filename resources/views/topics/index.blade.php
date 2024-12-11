@extends('layouts.master')
@section('title', 'Topics Index')
@section('content')
    <!doctype html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>

    <body>
        <div class="container">
            <h1>All Topics</h1>
            <x-alert />
            <div class="row">
                @foreach ($topics as $topic)
                    <div class="col-md-3 mb-4">
                        <div class="card h-100">

                            <div class="card-body">
                                <h5 class="card-title">{{ $topic->name }}</h5>
                                <p class="card-text">{{ $topic->secione }} - {{ $topic->room }}</p>
                                <!-- View Button -->

                                <!-- Edit Button -->
                                <a href="{{ route('topics.edit', ['topic' => $topic->id]) }}"
                                    class="btn btn-warning">Edit</a>

                                <!-- Delete Button -->
                                <form action="{{ route('topics.destroy', $topic->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this topic?');">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </body>

    </html>
@endsection
