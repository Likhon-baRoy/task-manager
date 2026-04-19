@extends('layouts.app')

@section('title', 'Edit Task')

@section('content')

    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-6">
            
            <div class="card">
                <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Edit Task</h4>
                    <a href="{{ route('tasks.index') }}" class="btn btn-light btn-sm">
                        <i class="bi bi-arrow-left"></i> Back to List
                    </a>
                </div>
                <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Task Title <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="title" 
                                   class="form-control @error('title') is-invalid @enderror"
                                   value="{{ old('title', $task->title) }}" 
                                   placeholder="Enter task title"
                                   required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea name="description" 
                                      class="form-control @error('description') is-invalid @enderror" 
                                      rows="5"
                                      placeholder="Enter task description...">{{ old('description', $task->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Status</label>
                            <select name="status" 
                                    class="form-select @error('status') is-invalid @enderror">
                                <option value="pending" {{ old('status', $task->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="in_progress" {{ old('status', $task->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" {{ old('status', $task->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success px-4">
                                Update Task
                            </button>
                            
                            <a href="{{ route('tasks.index') }}" 
                               class="btn btn-secondary px-4">
                                Cancel
                            </a>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>

@endsection