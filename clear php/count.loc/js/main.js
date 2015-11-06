$(document).ready(function () {
    var to = $('#to');
    var from = $('#from');
    $('.setting form').submit(function () {
        var from_val = parseInt(from.val());
        var to_val = parseInt(to.val());
        if (from_val > to_val) {
            to.val(from_val);
        }
    });
});