@extends('layouts.master')
@section('content')
@section('title', 'create class room')

<!doctype html>
<html lang="en">



<body>

    <div class="container">

        
        <h1>Create class room</h1>
        <x-alertError/>


        <form action="{{ route('classrooms.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="name" id="name" placeholder="class name">
                <label for="name">Class name</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="secione" id="secione" placeholder="class secione">
                <label for="secione">Class secione</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="subject" id="subject" placeholder="class subject">
                <label for="subject">Class subject</label>
            </div>


            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="room" id="room" placeholder="class room">
                <label for="room">Class room</label>
            </div>


            <div class="form-floating mb-3">
                <input type="file" class="form-control" name="cover_image_path" id="cover_image_path"
                    placeholder="Cover Image">
                <label for="cover_image_path">Cover Image</label>
            </div>

            <button type="submit" class="btn btn-primary">Create room</button>
        </form>
    </div>

</body>

</html>

@endsection
