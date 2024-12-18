@extends('layouts.master')
@section('title','Class Room')
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
        <h1>Classroom</h1>
    <x-alert/>
        <div class="row">
            @foreach ($classrooms as $classroom)
                <div class="col-md-3 mb-4"> <!-- تعديل لإغلاق العمود بشكل صحيح -->
                    <div class="card h-100"> <!-- h-100 تجعل الكارد يأخذ الارتفاع بالكامل -->
                        <img src="{{ $classroom->cover_image_path }}" alt="Classroom Image">
                        <div class="card-body">
                            <h5 class="card-title">{{ $classroom->name }}</h5>
                            <p class="card-text">{{ $classroom->secione }} - {{ $classroom->room }}</p>
                            <!-- زر العرض -->
                            <a href="{{ route('classrooms.show', ['classroom' => $classroom->id]) }}"
                                class="btn btn-success">View</a>

                            <!-- زر التعديل -->
                            <a href="{{ route('classrooms.edit', ['classroom' => $classroom->id]) }}"
                                class="btn btn-warning">Edit</a>

                            <!-- زر الحذف -->
                            <form action="{{ route('classrooms.destroy', $classroom->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this classroom?');">
                                    Delete
                                </button>


                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</body>

</html>
@endsection