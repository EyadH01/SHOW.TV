@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="fas fa-plus"></i> إضافة حلقة جديدة
                    </h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.episodes.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="show_id" class="form-label">المسلسل</label>
                            <select class="form-control @error('show_id') is-invalid @enderror" id="show_id" name="show_id" required>
                                <option value="">اختر المسلسل</option>
                                @foreach($shows as $show)
                                <option value="{{ $show->id }}">{{ $show->title }}</option>
                                @endforeach
                            </select>
                            @error('show_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">عنوان الحلقة</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">وصف الحلقة</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="duration" class="form-label">المدة (بالدقائق)</label>
                                <input type="number" class="form-control @error('duration') is-invalid @enderror" id="duration" name="duration" value="{{ old('duration') }}">
                                @error('duration')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="airing_time" class="form-label">وقت البث</label>
                                <input type="text" class="form-control @error('airing_time') is-invalid @enderror" id="airing_time" name="airing_time" value="{{ old('airing_time') }}" placeholder="مثال: الثلاثاء @ 9:00 مساءً">
                                @error('airing_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="video_url" class="form-label">رابط الفيديو (أو ارفع ملف فيديو)</label>
                            <input type="url" class="form-control @error('video_url') is-invalid @enderror" id="video_url" name="video_url" value="{{ old('video_url') }}" placeholder="https://www.youtube.com/embed/...">
                            @error('video_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">يمكنك استخدام رابط يوتيوب أو فيميو أو رابط فيديو مباشر. بدلاً من ذلك يمكنك رفع ملف MP4 عبر الحقل أدناه.</small>
                        </div>

                        <div class="mb-3">
                            <label for="video_file" class="form-label">رفع ملف فيديو (MP4) - اختياري</label>
                            <input type="file" class="form-control @error('video_file') is-invalid @enderror" id="video_file" name="video_file" accept="video/*">
                            @error('video_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">رفع الملف سيخزن الفيديو في التخزين العام ويسجل المسار في قاعدة البيانات.</small>
                        </div>

                        <div class="mb-3">
                            <label for="youtube_video_id" class="form-label">معرف فيديو يوتيوب (اختياري)</label>
                            <input type="text" class="form-control @error('youtube_video_id') is-invalid @enderror" id="youtube_video_id" name="youtube_video_id" value="{{ old('youtube_video_id') }}" placeholder="dQw4w9WgXcQ">
                            @error('youtube_video_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">إذا كان الفيديو من يوتيوب، أدخل المعرف فقط</small>
                        </div>

                        <div class="mb-3">
                            <label for="thumbnail" class="form-label">صورة مصغرة (اختياري)</label>
                            <input type="file" class="form-control @error('thumbnail') is-invalid @enderror" id="thumbnail" name="thumbnail" accept="image/*">
                            @error('thumbnail')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.episodes.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> العودة
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> إضافة الحلقة
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
