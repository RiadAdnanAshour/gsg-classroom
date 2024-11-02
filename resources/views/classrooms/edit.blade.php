@extends('layouts.master')
@section('title', 'Edit Classroom')
@section('content')

    <!doctype html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title></title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>

    <body>

        <div class="container mt-5">
            <h1>Edit Classroom</h1>
            <x-alertError />
       
        </div>


        <form action="{{ route('classrooms.update', $classroom->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT') <!-- تعلن أن هذه هي عملية التحديث -->

            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="name" id="name"
                    value="{{ old('name', $classroom->name) }}" required>
                <label for="name">Class Name</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="secione" id="secione"
                    value="{{ old('secione', $classroom->secione) }}">
                <label for="secione">Class Section</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="subject" id="subject"
                    value="{{ old('subject', $classroom->subject) }}">
                <label for="subject">Class Subject</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="room" id="room"
                    value="{{ old('room', $classroom->room) }}">
                <label for="room">Class Room</label>
            </div>

            <div class="form-floating mb-3">
                <input type="file" class="form-control" name="cover_image_path" id="cover_image_path">
                <label for="cover_image_path">Cover Image (optional)</label>
            </div>

            <button type="submit" class="btn btn-primary">Update Classroom</button>
        </form>
        </div>

    </body>

    </html>
@endsection
