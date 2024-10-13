$(document).ready(function() {

    $('#search-2').on('keyup', function () {
        var value = $(this).val().toLowerCase();

        // Filter only the first td in each row
        $('#table-1 tr').each(function () {
            var firstTd = $(this).find('td:nth-child(2)');
            var rowText = firstTd.text().toLowerCase();
            firstTd.closest('tr').toggle(rowText.indexOf(value) > -1);
        });

        // Show the first two rows
        $('#table-1 tr:first').show();
    });

});
