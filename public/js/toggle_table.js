$(document).ready(function () {
    $('.notification-li').click(function () {
        $(this).find('.logs').slideToggle();
    });

    // slide up the log if cleck anywhere on the page instead the log
    $(document).click(function (e) {
        if (!$(e.target).closest('.notification-li').length) {
            $('.logs').slideUp();
        }
    });

    // fade alert messages when clicked on close button or fade out after 3 seconds
    $('.close-message').click(function () {
        $(this).parent().fadeOut();
    });


    $(".confirm-btn").click(function (event) {
        let confirmation = confirm("هل انت متأكد من إتمام العملية");
        if (!confirmation) {
            event.preventDefault(); // Prevents the default action if user selects "No"
        }
    });

});
