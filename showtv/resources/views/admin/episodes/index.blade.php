@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3><i class="fas fa-play-circle"></i> إدارة الحلقات</h3>
                    <a href="{{ route('admin.episodes.create') }}" class="btn btn-success">
                        <i class="fas fa-plus"></i> إضافة حلقة جديدة
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>العنوان</th>
                                    <th>المسلسل</th>
                                    <th>المدة</th>
                                    <th>الإعجابات</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($episodes as $episode)
                                <tr>
                                    <td>{{ $episode->id }}</td>
                                    <td>{{ $episode->title }}</td>
                                    <td>{{ $episode->show->title }}</td>
                                    <td>{{ $episode->duration }} دقيقة</td>
                                    <td>
                                        <span class="badge bg-success">{{ $episode->likes }}</span>
                                        <span class="badge bg-danger">{{ $episode->dislikes }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.episodes.edit', $episode) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i> تعديل
                                        </a>
                                        <a href="{{ route('episodes.show', $episode) }}" class="btn btn-sm btn-info" target="_blank">
                                            <i class="fas fa-eye"></i> عرض
                                        </a>
                                        <form action="{{ route('admin.episodes.destroy', $episode) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد من حذف هذه الحلقة؟')">
                                                <i class="fas fa-trash"></i> حذف
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{ $episodes->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
