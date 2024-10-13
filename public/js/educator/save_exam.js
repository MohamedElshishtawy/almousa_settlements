$(document).ready(function () {
    $(document).on('click', '#saveExam', function () {


        var exam = [];

        var $exam_questions = $('#ExamOL').find('li');
        let n = 0
        if ($exam_questions.length > 0) {
            $exam_questions.each(function () {
                exam.push({
                    q: $(this).find('[name=q]').val() || '',
                    img: "img" || '',
                    a0: $(this).find('[name=a0]').val() || '',
                    a1: $(this).find('[name=a1]').val() || '',
                    a2: $(this).find('[name=a2]').val() || '',
                    a3: $(this).find('[name=a3]').val() || '',
                    at: $(this).find('input[name^=at]:checked').val() || '',
                    obs: $(this).find('[name=obs]').val() || '',
                    obsImg: 'img' || ''
                });
            });
        }

        // // Log the first image file to the console
        // console.log(exam.length > 0 ? exam[0]['img'] : null);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // // let baseUrl = window.location.href.substring(0, window.location.href.lastIndexOf('/'));

        $.ajax({
            url: window.location.href + '/save_questions',
            method: 'POST',
            type: 'POST',
            enctype: 'multipart/form-data',
            // contentType: false,
            // processData: false,
            data: {
                exam: exam,
                // images: images
            },
            success: function (response) {
                window.alert("تم حفظ الإمتحان");
            },
            error: function (error) {
                window.alert('لم يتم حفظ الإمتحان:', error.responseText);
            }
        });
    });
});

