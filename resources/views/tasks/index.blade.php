@extends('layouts.app')

@section('title', 'Task Manager')

@section('content')

    <h2 class="mb-4">Task Manager</h2>
    
    <a href="{{ route('tasks.create') }}" class="btn btn-primary mb-3">+ Add New Task</a>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Status Filter -->
    <div class="mb-3">
        <form method="GET" id="filterForm">
            <select name="status" id="statusFilter" style="width: 180px;">
                <option value="">All Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
            </select>
        </form>
    </div>

    <div class="card">
        <div class="card-body p-3">
            <table id="taskTable" class="table table-hover mb-0 task-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th width="160">Status</th>
                        <th width="180">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tasks as $task)
                    <tr>
                        <td>{{ $task->id }}</td>
                        <td><strong>{{ $task->title }}</strong></td>
                        <td>
                            @if(strlen($task->description ?? '') > 25)
                                <span class="description-text">
                                    {{ substr($task->description, 0, 25) }}...
                                </span>
                                <button type="button" class="btn btn-sm btn-link text-primary p-0 ms-2"
                                        data-bs-toggle="modal"
                                        data-bs-target="#descModal"
                                        data-title="{{ $task->title }}"
                                        data-desc="{{ $task->description }}">
                                    View Full
                                </button>
                            @else
                                {{ $task->description ?? '<span class="text-muted">—</span>' }}
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('tasks.update', $task->id) }}" method="POST" class="status-form">
                                @csrf
                                @method('PUT')
                                <select name="status"
                                        class="form-select form-select-sm status-select status-{{ $task->status }}"
                                        onchange="this.form.submit()">
                                    <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                            </form>
                        </td>
                        <td>
                            <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm btn-outline-primary me-1">Edit</a>
                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Delete this task?')"
                                        class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Description Modal -->
    <div class="modal fade" id="descModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTaskTitle">Task Description</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="modalTaskDesc" style="white-space: pre-wrap;">
                    <!-- Filled by JS -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection