@extends('layouts.master')
@section('title', 'Classworks List')
@section('content')

    <div class="container">
        <h1>{{ $classroom->name }} - Classworks</h1>
        <x-alert />

        <!-- رابط لإضافة عمل جديد -->

        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                + create
            </button>
            <ul class="dropdown-menu">
                <a class="dropdown-item"
                    href="{{ route('classrooms.classwork.create', ['classroom' => $classroom->id]) }}?type=assignment">Assignment</a>
                <a class="dropdown-item"
                    href="{{ route('classrooms.classwork.create', ['classroom' => $classroom->id]) }}?type=material">Material</a>
                <a class="dropdown-item"
                    href="{{ route('classrooms.classwork.create', ['classroom' => $classroom->id]) }}?type=question">Question</a>


            </ul>
        </div>
        <!-- جدول لعرض قائمة classworks -->
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Published At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($classworks as $classwork)
                        <tr>
                            <td>{{ $classwork->title }}</td>
                            <td>{{ ucfirst($classwork->type) }}</td>
                            <td>{{ ucfirst($classwork->status) }}</td>
                            <td>
                                @if ($classwork->published_at)
                                    {{ \Carbon\Carbon::parse($classwork->published_at)->format('Y-m-d') }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>
                                <!-- زر العرض -->
                                <a href="{{ route('classrooms.classwork.show', [$classroom->id, $classwork->id]) }}"
                                    class="btn btn-success btn-sm">View</a>

                                <!-- زر التعديل -->
                                <a href="{{ route('classrooms.classwork.edit', [$classroom->id, $classwork->id]) }}"
                                    class="btn btn-warning btn-sm">Edit</a>

                                <!-- زر الحذف -->
                                <form
                                    action="{{ route('classrooms.classwork.destroy', [$classroom->id, $classwork->id]) }}"
                                    method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this classwork?');">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <p>Now Classwork found.</p>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
