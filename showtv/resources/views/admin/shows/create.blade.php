@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Show</h1>
    <form action="{{ route('admin.shows.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="airing_time" class="form-label">Airing Time</label>
            <input type="text" class="form-control" id="airing_time" name="airing_time" required>
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
        <a href="{{ route('admin.shows.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
