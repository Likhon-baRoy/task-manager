<!DOCTYPE html>
<html>

<head>
    <title>Task Manager</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <style>
        :root {
            --pending: #6c757d;
            --progress: #ffc107;
            --completed: #198754;
        }

        .task-table thead th {
            background: linear-gradient(135deg, #0d6efd, #0b5ed7);
            color: white;
            font-weight: 600;
            padding: 14px 12px;
            border: none;
        }

        .task-table th,
        .task-table td {
            vertical-align: middle;
        }

        .status-select {
            border-radius: 20px;
            font-weight: 500;
            text-align: center;
            cursor: pointer;
            border: none;
            padding: 6px 12px;
            width: 100%;
            transition: all 0.2s;
        }

        .status-pending {
            background-color: var(--pending);
            color: white;
        }

        .status-in_progress {
            background-color: var(--progress);
            color: black;
        }

        .status-completed {
            background-color: var(--completed);
            color: white;
        }

        .status-select:hover {
            opacity: 0.95;
            transform: scale(1.02);
        }

        .description-text {
            max-width: 300px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .modal-body {
            max-height: 60vh;
            overflow-y: auto;
        }

        .card {
            border: none;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        }
    </style>
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
                            <th>Title</th>
                            <th>Description</th>
                            <th width="160">Status</th>
                            <th width="180">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tasks as $task)
                        <tr>
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
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        // Initialize DataTable
        $('#taskTable').DataTable({
            pageLength: 10,
            ordering: true,
            responsive: true,
            language: {
                search: "Search tasks:",
                lengthMenu: "Show _MENU_ tasks"
            }
        });

        // Status Filter with Select2
        $('#statusFilter').select2({
            placeholder: "Filter by status",
            allowClear: true,
            minimumResultsForSearch: Infinity
        }).on('change', function() {
            $('#filterForm').submit();
        });

        // Description Modal
        $('#descModal').on('show.bs.modal', function(event) {
            const button = $(event.relatedTarget);
            const title = button.data('title');
            const desc = button.data('desc');

            $('#modalTaskTitle').text(title);
            $('#modalTaskDesc').text(desc || 'No description available.');
        });

        // Visual feedback on status change
        $('.status-form select').on('change', function() {
            const $select = $(this);
            $select.removeClass('status-pending status-in_progress status-completed')
                .addClass('status-' + $select.val());
        });
    </script>
</body>

</html>