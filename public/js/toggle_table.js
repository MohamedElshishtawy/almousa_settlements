$(document).ready(function () {
    // fade alert messages when clicked on close button or fade out after 3 seconds
    $('.close-message').click(function () {
        $(this).parent().fadeOut();
    });


});
