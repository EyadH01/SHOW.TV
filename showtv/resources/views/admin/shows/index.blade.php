@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Shows Management</h1>
    <a href="{{ route('admin.shows.create') }}" class="btn btn-primary">Create Show</a>
    <a href="{{ route('admin.episodes.index') }}" class="btn btn-secondary">Manage Episodes</a>
    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Manage Users</a>
    <table class="table table-striped mt-3">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Airing Time</th>
                <th>Episodes</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($shows as $show)
            <tr>
                <td>{{ $show->title }}</td>
                <td>{{ Str::limit($show->description, 50) }}</td>
                <td>{{ $show->airing_time }}</td>
                <td>{{ $show->episodes_count }}</td>
                <td>
                    <a href="{{ route('admin.shows.edit', $show) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('admin.shows.destroy', $show) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $shows->links() }}
</div>
@endsection
