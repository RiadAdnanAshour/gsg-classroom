@extends('layouts.master')
@section('title', 'People in ' . $classroom->name)
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
        <h1>People in {{ $classroom->name }}</h1>
        <x-alert />

        <!-- المدرسون -->
        <h2>Teachers</h2>
        <div class="row">
            @foreach ($classroom->teacher as $teacher)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">{{ $teacher->name }}</h5>
                            <p class="card-text">Email: {{ $teacher->email }}</p>
                            <p class="card-text">Role: Teacher</p>
                            <a href="#" class="btn btn-success">View Profile</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- الطلاب -->
        <h2>Students</h2>
        <div class="row">
            @foreach ($classroom->student as $student)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">{{ $student->name }}</h5>
                            <p class="card-text">Email: {{ $student->email }}</p>
                            <p class="card-text">Role: Student</p>
                            <a href="#" class="btn btn-success">View Profile</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</body>

</html>
@endsection
