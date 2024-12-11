

@extends('layouts.master')
@section('title', 'Edit Topic')
@section('content')

<div class="container mt-5">
    <h1>Edit Topic</h1>
    <x-alertError />
</div>

<form action="{{ route('topics.update', $topic->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="form-floating mb-3">
        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name"
            value="{{ old('name', $topic->name) }}" required>
        <label for="name">Topic Name</label>
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>



 {{-- Classroom --}}
 <div class="form-floating mb-3">
    <select class="form-select @error('classroom_id') is-invalid @enderror" 
            name="classroom_id" id="classroom_id">
        <option value="" disabled selected>Select Classroom</option>
        @foreach ($classrooms as $classroom)
            <option value="{{ $classroom->id }}" {{ old('classroom_id') == $classroom->id ? 'selected' : '' }}>
                {{ $classroom->name }}
            </option>
        @endforeach
    </select>
    <label for="classroom_id">Classroom</label>
    @error('classroom_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

{{-- Assigned User (Optional) --}}
<div class="form-floating mb-3">
    <select class="form-select @error('user_id') is-invalid @enderror" 
            name="user_id" id="user_id">
        <option value="" selected>No User Assigned</option>
        @foreach ($users as $user)
            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                {{ $user->name }}
            </option>
        @endforeach
    </select>
    <label for="user_id">Assigned User (Optional)</label>
    @error('user_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

    <button type="submit" class="btn btn-primary">Update Topic</button>
</form>
</div>

@endsection
