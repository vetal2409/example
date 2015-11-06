$(document).ready(function () {
    $(document).on('change', '.grid-data-table .checkbox-column-label', function () {
        var $allCheckboxes = $('.checkbox-column');
        if ($(this).prop('checked')) {
            $allCheckboxes.prop('checked', true);
        } else {
            $allCheckboxes.prop('checked', false);
        }
    });

    $(document).on('change', '.column-grid-toggle', function () {
        var $allCheckboxes = $('.column-grid');
        if ($(this).prop('checked')) {
            $allCheckboxes.prop('checked', true);
        } else {
            $allCheckboxes.prop('checked', false);
        }
    });

    $(document).on('change', '.column-export-toggle', function () {
        var $allCheckboxes = $('.column-export');
        if ($(this).prop('checked')) {
            $allCheckboxes.prop('checked', true);
        } else {
            $allCheckboxes.prop('checked', false);
        }
    });
});