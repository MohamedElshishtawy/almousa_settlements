$(document).ready(function(){
    $(".contacts .content").slideUp()
    $('.contacts .main-icon').on('click', function(){
        $(".contacts .content").slideToggle(500); // Adjust the animation duration as needed
    });
});
