$(document).ready(function () {
    // Prevent Enter to submit the page
    $("form").bind("keydown", function(e) {
        if (e.keyCode === 13) return false;
    });

    // add question progress
    let valOFinpNum = $('#numOFq');
    let btnAddQ = $('#addQustion');

    // Edit qCounter
    let qCounter = $('.q-num').length;

    btnAddQ.click(function () {
        if (valOFinpNum.val() < "1") {
            valOFinpNum.css('color', 'red');
        } else {
            valOFinpNum.css('color', '#5cb85c');

            if (valOFinpNum.val() > "1") {
                let x = 1;
                let wait = setInterval(function () {
                    "use strict"
                    setOneQuestion();
                    qCounter++;
                    x++
                    if (x > valOFinpNum.val()) {
                        clearInterval(wait);
                        valOFinpNum.val(1);
                    }
                }, 100);
            } else {
                setOneQuestion();
                qCounter++;
            }

            /**
             * FUNCTION -> v2.0
             * function place one question
             * it doesn't support parameters
             * ( new version [2] ) => adding remove question button
             */
            function setOneQuestion() {
                "use strict";
                let ExamOl = $('#ExamOL');

                // for question number
                ExamOl.append('<li class="q-num" id="h' + qCounter + '"></li>');
                $('#h' + qCounter).append('<div class="qus-div" id="qusDiv' + qCounter + '"></div>');

                // Degree
                $('#qusDiv' + qCounter).append('<div id="degDiv'+qCounter+'" class="deg-container"></div>');
                    $('#degDiv' + qCounter).append('<label for="degInput'+qCounter+'" class="deg-label">درجة السؤال: </label>');
                    $('#degDiv' + qCounter).append('<input type="number" class="form-control" id="degInput'+qCounter+'" value="1" name="deg[]" />');

                // for question input
                $('#qusDiv' + qCounter).append('<textarea type="text" class="form-control q-input" id="exInput' + qCounter + '" placeholder="ضع هنا السؤال" name="q[]"></textarea>');

                // for question image
                $('#qusDiv' + qCounter).append('<div class="img-div" id="imgDiv'+qCounter+'"></div>')

                    $('#imgDiv' + qCounter).append('<input type="file" class="file-input form-control" id="img' + qCounter + '" name="img[]">');

                    $('#imgDiv'+qCounter).append('<input type="hidden" class="file-input form-control" id="imgH'+qCounter+'" value="" name="img[]">')

                    $('#imgDiv' + qCounter).append('<div class="btn btn-danger btn-sm remove-img" id="removeImg'+qCounter+'"  for-img="img_'+qCounter+'"><i class="fa-solid fa-xmark"></i></div>')

                // for answers inputs
                for (let ans = 0; ans < 4; ans++) {
                    $('#qusDiv' + qCounter).append('<div id="ansDiv' + qCounter + ans + '" class="ans-div"></div>');
                    $('#ansDiv' + qCounter + ans).append('<input type="radio" class="rd-input" usage="trueAns" id="radio' + qCounter + ans + '" name="at[' + qCounter + ']" value="a' + ans + '">');

                    switch (ans) {
                        case 0:
                            $('#ansDiv' + qCounter + ans).append('<input type="text" class="form-control a-input" id="exInput' + qCounter + '_ans' + ans + '" name="a' + ans + '[]" value="الإختيار ا">');
                            break;
                        case 1:
                            $('#ansDiv' + qCounter + ans).append('<input type="text" class="form-control a-input" id="exInput' + qCounter + '_ans' + ans + '" name="a' + ans + '[]" value="الإختيار ب">');
                            break;
                        case 2:
                            $('#ansDiv' + qCounter + ans).append('<input type="text" class="form-control a-input" id="exInput' + qCounter + '_ans' + ans + '" name="a' + ans + '[]" value="الإختيار ج">');
                            break;
                        case 3:
                            $('#ansDiv' + qCounter + ans).append('<input type="text" class="form-control a-input" id="exInput' + qCounter + '_ans' + ans + '" name="a' + ans + '[]" value="الإختيار د">');
                            break;
                    }
                }


                // for question observation
                $('#qusDiv' + qCounter).append('<textarea type="text" class="form-control observ-input" id="observInput' + qCounter + '" placeholder="ضع ملحوظتك علي السؤال" name="obs[]"></textarea>');

                // for question image
                $('#qusDiv' + qCounter).append('<div class="img-div" id="obsDiv'+qCounter+'"></div>')

                    $('#obsDiv' + qCounter).append('<input type="file" class="file-input form-control" id="obsImg' + qCounter + '" name="obsImg[]">');

                    $('#obsDiv' + qCounter).append('<input type="hidden" class="file-input form-control" id="obsH'+qCounter+'" value="" name="obsImg[]">')

                    $('#obsDiv' + qCounter).append('<div class="btn btn-danger btn-sm remove-img" id="removeObs'+qCounter+'"  for-img="obs_'+qCounter+'"><i class="fa-solid fa-xmark"></i></div>')

                // for delete btn
                $('#qusDiv' + qCounter).append('<button class="btn btn-danger delete-question" type="button" id="delete' + qCounter + '" for-question="' + qCounter + '">delete</button>');
                /* * end the adding */
            }
        }
    });

    /* end delete question btn */

    $('#deleteQustion').click(function () {
        if (qCounter > 0) {
            qCounter--;
            $('#hr' + qCounter).remove();
            $('#qusDiv' + qCounter).remove(); // all div question
            $('#h' + qCounter).remove(); // li for question number
            $('#exInput' + qCounter).remove(); // text area for question
            $('#fileInput' + qCounter).remove(); // image file input
            $('#exInput' + qCounter).remove(); // for 4 answers
            $('#trueTxt' + qCounter).remove(); // for the text "الاجابة الصحيحة هي"
            for (num = 0; num < 4; num++) { // loop to remove all true ans [div label radio]
                $('#trueAnsDiv' + qCounter + num).remove(); // for the div
                $('#radio' + qCounter + num).remove(); // for input inner this div
                $('#label' + qCounter + num).remove(); // for label inner this div
            }
            $('#observInput' + qCounter).remove(); // for observation text area
        }
    });

    $(document).on('click', '.delete-question', function () {
        let questionNum = $(this).attr('for-question');
        $('#hr' + questionNum).remove();
        $('#qusDiv' + questionNum).remove(); // all div question
        $('#h' + questionNum).remove(); // li for question number
        $('#exInput' + questionNum).remove(); // text area for question
        $('#fileInput' + questionNum).remove(); // image file input
        $('#exInput' + questionNum).remove(); // for 4 answers
        $('#trueTxt' + questionNum).remove(); // for the text "الاجابة الصحيحة هي"
        for (num = 0; num < 4; num++) { // loop to remove all true ans [div label radio]
            $('#trueAnsDiv' + questionNum + num).remove(); // for the div
            $('#radio' + questionNum + num).remove(); // for input inner this div
            $('#label' + questionNum + num).remove(); // for label inner this div
        }
        $('#observInput' + questionNum).remove(); // for observation text area
        $(this).remove()
    });

    $(document).on('change', 'input[type=file]', function () {
        // Use $(this) to refer to the specific file input that triggered the event
        const $this = $(this);

        if ($this.next('img').length == 0) {
            $image = $('<img src="" class="q_img">');
            $this.after($image);
        } else {
            $image = $this.next();
        }

        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (event) {
                $image.attr("src", event.target.result);
            };
            reader.readAsDataURL(file);
        }
    });

    $(document).on('click', '[for-img]', function() {
        var imgIndex = $(this).attr('for-img');

        if (imgIndex.startsWith('img_')) {
            // Extract the index from the string
            var index = parseInt(imgIndex.substring(4));

            // Fade out and remove the image preview if it exists
            $('#img_' + index).fadeOut(300, function() {
                $(this).remove();
            });

            // Fade in the file input if it is hidden
            // $('#img' + index).fadeIn(300);

            // Remove the file selected in the file input
            $('#img' + index).val('');

            // Find and clear the hidden input value
            $('#imgH' + index).val('');

            // Ensure the input is displayed
            $('#img' + index).removeClass('d-none');
        } else if (imgIndex.startsWith('obs_')) {
            // Extract the index from the string
            var index = parseInt(imgIndex.substring(4));

            // Fade out and remove the image preview if it exists
            $('#obs_' + index).fadeOut(300, function() {
                $(this).remove();
            });

            // Fade in the file input if it is hidden
            // $('#obsImg' + index).fadeIn(300);

            // Remove the file selected in the file input
            $('#obsImg' + index).val('');

            // Find and clear the hidden input value
            $('#obsImgH' + index).val('');

            // Ensure the input is displayed
            $('#obsImg' + index).removeClass('d-none');
        }
    });

    $(document).on('click', '#end', function(event) {
        // Check if all radio inputs are checked
        let allChecked = $('input[type="radio"]').filter(':checked').length === $('.q-input').length;

        // Log the result (you can modify this part as needed)

        if (allChecked) {

        } else {
            event.preventDefault();
            alert('تأكد من حل جميع الأسئلة');
        }
    });

});
