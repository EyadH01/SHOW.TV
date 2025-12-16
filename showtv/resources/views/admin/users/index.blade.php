@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3><i class="fas fa-users"></i> إدارة المستخدمين</h3>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> العودة
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>الاسم</th>
                                    <th>البريد الإلكتروني</th>
                                    <th>الدور</th>
                                    <th>تاريخ الانضمام</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : 'primary' }}">
                                            {{ $user->role === 'admin' ? 'مدير' : 'مستخدم' }}
                                        </span>
                                    </td>
                                    <td>{{ $user->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i> تعديل
                                        </a>
                                        @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد من حذف هذا المستخدم؟')">
                                                <i class="fas fa-trash"></i> حذف
                                            </button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
