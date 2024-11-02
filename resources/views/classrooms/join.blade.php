@extends('layouts.master')
@section('title', 'join Classoom')
@section('content')

    <div class="d-flex align-items-center justify-content-center vh100">
        <div class="border p-5 text-center">
            <h2 class="mb-4">{{ $classroom->name }}</h2>
            <form action="{{ route('classrooms.join', $classroom->id) }}" method="POST">
                @csrf

                <button type="submit" class="btn btn-primary">{{ __('join') }}</button>
            </form>
        </div>
    </div>


@endsection
