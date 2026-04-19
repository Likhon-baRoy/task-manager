$(document).ready(function() {

    // Initialize DataTable - Sort by ID DESC (Latest first)
    $('#taskTable').DataTable({
        pageLength: 10,
        ordering: true,
        responsive: true,
        order: [[0, 'desc']],           // Sort by ID column descending
        columnDefs: [
            { targets: 0, visible: false }   // Hide ID column
        ],
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

    // Visual feedback when status changes
    $('.status-form select').on('change', function() {
        const $select = $(this);
        $select.removeClass('status-pending status-in_progress status-completed')
               .addClass('status-' + $select.val());
    });
});