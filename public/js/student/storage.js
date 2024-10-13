$(document).ready(function () {
    var examId = $('#examId').val();
    //Exam Structure
    var newExam = {
        examId: examId,
        answers: {}
    }
    // Load exams data from localStorage
    var exam = JSON.parse(localStorage.getItem('exam')) || {};



    // Your existi  ng code ...

    // Check if there are stored answers for the current examId
    if ( exam ) {
        // The same exam
        if ( exam.examId == examId ){
            // Iterate through stored answers and set corresponding radio inputs to checked
            $.each(exam.answers, function(index, value) {
                $('input[name="answers[' + index + ']"][value="' + value + '"]').click();

            });
        }
        else {
            localStorage.clear()
            localStorage.setItem('exam', JSON.stringify(newExam));
        }

    }else {
        localStorage.setItem('exam', JSON.stringify(newExam));
        exam = JSON.parse(localStorage.getItem('exam')) || {};
    }

    // Your existing code ...

    // Save answers to localStorage when a radio input is clicked
    $('input[type="radio"][name^="answers["]').on('click', function() {
        var index = parseInt(this.name.match(/\[(\d+)\]/)[1]);
        var value = this.value;

        // Update stored exams or create a new entry
        exam.answers[index] = value;
        // Save updated exams to localStorage
        localStorage.setItem('exam', JSON.stringify(exam));
    });

    // Your existing code ...
});
