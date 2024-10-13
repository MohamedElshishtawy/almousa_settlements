$(document).ready(function () {
    // Initial index
    let currentIndex = 0;

    // Show the initial question container
    showQuestionContainer(currentIndex);

    // Next button click event
    let questionsCount = $('.q-container').length;

    // Next button click event
    $('#next').on('click', function () {
        console.log('currentIndex ' + currentIndex + ' questionsCount ' + questionsCount )
        if (currentIndex < questionsCount - 1) {
            currentIndex++;
            showQuestionContainer(currentIndex);
            $('#back').prop('disabled', false); // Re-enable the Back button
            if (currentIndex == questionsCount - 1){
                $(this).hide();
                $('#preEnd').show();
            }
        }
    });

    // Back button click event
    $('#back').on('click', function () {
        if (currentIndex > 0) {
            currentIndex--;
            showQuestionContainer(currentIndex);
            $('#next').show(); // Show the Next button
            $('#preEnd').hide();
        } else {
            $(this).prop('disabled', true); // Disable the Back button when at the first question
        }
    });

    function showQuestionContainer(index) {
        // Hide all question containers
        $('.q-container').hide();

        // Show the question container at the specified index
        $('.q-container').eq(index).show();

        // Question sidebar
        $('.question_link').removeClass('active_link')
        $('.question_link').eq(index).addClass('active_link')

        // Question Cunter
        $('#questionCounter').html(parseInt(index) + 1)

        // progress
        let totalContainers = $('.q-container').length;

        let percentage = ((parseInt(index) + 1) / totalContainers) * 100;


        // Use jQuery's css method to set the width
        $('.bar').css('width', `${percentage}%`);
        // Disable/Enable Next and Back buttons based on index
        $('#next').prop('disabled', currentIndex === $('.q-container').length - 1);
        $('#back').prop('disabled', currentIndex === 0);

        //edit buttons

        if ( index == $('.q-container').length -1){
            $('#next').hide();
            $('#preEnd').show();
        }else{
            $('#next').show();
            $('#preEnd').hide();
        }
    }

    $('input[type="radio"]').on('change', function () {
        let questionIndex = $(this).attr('question-index');

        $(`li[link-question="${questionIndex}"]`).addClass('answered');
    });

    $('[link-question]').on('click', function () {

        let linkQuestionValue = $(this).attr('link-question');


        currentIndex = linkQuestionValue

        showQuestionContainer(currentIndex);

    });



    // -- Start End Bottoms --

    $('#preEnd').on('click', function (event) {
        // Check if all radio inputs are checked
        let allChecked = $('input[type="radio"]').filter(':checked').length === $('.q-container').length * 2 - 2 ; // *2 For the bubble sheet

        if (allChecked) {
            $('#questions').hide();
            $('#buttons').hide();
            $('#endPage').show();
        } else {
            event.preventDefault();
            alert('تأكد من حل جميع الأسئلة');
        }
    });

    $('#backToExam').click(function () {
        $('#questions').show();
        $('#buttons').show();
        $('#endPage').hide();
    })




});

