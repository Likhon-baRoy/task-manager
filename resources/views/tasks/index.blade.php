<!DOCTYPE html>
<html>

<head>
    <title>Task Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">
        <h2 class="mb-4">Task List</h2>

        <a href="{{ route('tasks.create') }}" class="btn btn-primary mb-3">+ Add New Task</a>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <div class="card">
            <div class="card-body p-3">
                <table id="taskTable" class="table table-hover mb-0 task-table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th width="200">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tasks as $task)
                        <tr>
                            <td>{{ $task->title }}</td>
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
                                @if($task->status == 'pending')
                                <span class="badge bg-secondary">Pending</span>
                                @elseif($task->status == 'in_progress')
                                <span class="badge bg-warning">In Progress</span>
                                @else
                                <span class="badge bg-success">Completed</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm btn-info">Edit</a>

                                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Delete this task?')" class="btn btn-sm btn-danger">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

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

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Description Modal
        $('#descModal').on('show.bs.modal', function(event) {
            const button = $(event.relatedTarget);
            const title = button.data('title');
            const desc = button.data('desc');

            $('#modalTaskTitle').text(title);
            $('#modalTaskDesc').text(desc || 'No description available.');
        });
    </script>
</body>

</html>