$(document).ready(function() {

    // Initialize DataTable
    $('#taskTable').DataTable({
        paging: true,
        ordering: true,
        searching: true,
        responsive: true,
        lengthChange: true,
        order: [[3, 'desc']],
        lengthMenu: [[5, 10, 25, 50], [5, 10, 25, 50]],
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
});