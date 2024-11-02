@extends('layouts.master')
@section('title','Classroom Details')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .code-box {
            font-size: 1.5rem;
            padding: 10px;
            color: white;
            border-radius: 8px;
            display: inline-block;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="container mt-5">
        <!-- بطاقة العرض للفصل الدراسي -->
        <div class="card">
            <!-- صورة الغلاف -->
            <img  src="{{ $classroom->cover_image_path ? asset('storage/' . $classroom->cover_image_path) : 'https://via.placeholder.com/1200x400' }}"                  class="card-img-top" alt="Classroom Cover Image">

            <div class="card-body">
                <!-- عنوان الفصل -->
                <h1 class="card-title">{{ $classroom->name }} - ({{ $classroom->id }})</h1>
                
                <!-- تفاصيل الفصل -->
                <div class="mb-3">
                    <strong>Code:</strong> 
                    <!-- مربع الكود مع لون عشوائي -->
                    <div class="code-box" id="classroomCode">{{ $classroom->code }}</div>
                    <p>invitation link: <a href="{{ $invitation_link }}">{{ $invitation_link }}</a> </p>
                    <button class="btn btn-sm btn-outline-secondary" onclick="copyCode()">Copy</button>
                </div>

                <p class="card-text"><strong>Section:</strong> {{ $classroom->secione ? $classroom->secione : 'N/A' }}</p>
                <p class="card-text"><strong>Room:</strong> {{ $classroom->room ? $classroom->room : 'N/A' }}</p>
                <p class="card-text"><strong>Subject:</strong> {{ $classroom->subject ? $classroom->subject : 'N/A' }}</p>
                <p class="card-text"><strong>Status:</strong> {{ ucfirst($classroom->status) }}</p>

                <!-- زر للعودة أو إجراءات إضافية -->
                <a href="{{ route('classrooms.index') }}" class="btn btn-primary">Back to Classrooms</a>
            </div>
        </div>
    </div>

    <script>
        // دالة لنسخ الكود
        function copyCode() {
            var codeText = document.getElementById("classroomCode").innerText;
            navigator.clipboard.writeText(codeText).then(function() {
                alert("Code copied to clipboard: " + codeText);
            }, function(err) {
                console.error("Could not copy text: ", err);
            });
        }

        // دالة لتوليد لون عشوائي
        function getRandomColor() {
            var letters = '0123456789ABCDEF';
            var color = '#';
            for (var i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }

        // تطبيق لون عشوائي على خلفية مربع الكود
        document.addEventListener('DOMContentLoaded', (event) => {
            document.getElementById('classroomCode').style.backgroundColor = getRandomColor();
        });
    </script>
</body>
</html>
@endsection