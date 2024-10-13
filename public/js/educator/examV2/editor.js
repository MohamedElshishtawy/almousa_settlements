import {generateChoice} from './modules/choice.js'
import {generateTrueOrFalseQuestion} from './modules/trueOrFalse.js'
import {GenerateReading} from './modules/reading.js'
import {asset, getCookie, createMediaElement} from '../../models/helper.js'
$(document).ready(function () {
    "use strict"

    let lang = $('html').prop('lang');
    // Prevent Enter to submit the page
    $("form").bind("keydown", function(e) {
        if (e.keyCode === 13) return false;
    });

    //----{{ Add Questions Btn }}----//
    btnAddQ.click(function () {
        if (valOFinpNum.val() < "1") {
            valOFinpNum.css('color', 'red');
        } else {
            valOFinpNum.css('color', '#5cb85c');
            if (valOFinpNum.val() > "1") {
                let x = 1;
                let wait = setInterval(function () {
                    generateChoice(qCounter++, examOL, -1, lang);
                    x++
                    if (x > valOFinpNum.val()) {
                        clearInterval(wait);
                        valOFinpNum.val(1);
                    }
                }, 1000);
            } else {
                generateChoice(qCounter++, examOL, -1, lang);
            }
        }
    })

    addTrueOrFalse.click(function () {
        if (tfNumOFq.val() < "1") {
            tfNumOFq.css('color', 'red');
        } else {
            tfNumOFq.css('color', '#5cb85c');

            if (tfNumOFq.val() > "1") {
                let x = 1;
                let wait = setInterval(function () {
                    generateTrueOrFalseQuestion(qCounter++, examOL,-1,  lang);
                    x++
                    if (x > tfNumOFq.val()) {
                        clearInterval(wait);
                        tfNumOFq.val(1);
                    }
                }, 100);
            } else {
                generateTrueOrFalseQuestion(qCounter++, examOL,-1,  lang);
            }
        }
    })

    addReading.click(function (){
        GenerateReading(qCounter++, examOL, lang);
    })

    $(document).on('click', 'div[choice-for-reading]', function (){
        let readingId = $(this).attr('choice-for-reading')
        console.log(readingId)
        let questionsOl = $(`#ExamOL #readingQuestions${readingId}`)
        generateChoice(qCounter++, questionsOl, readingId)
    })

    $(document).on('click','div[true-or-false-for-reading]', function (){
        let readingId = $(this).attr('true-or-false-for-reading')
        let questionsOl = $(`#ExamOL #readingQuestions${readingId}`)
        generateTrueOrFalseQuestion(qCounter++, questionsOl, readingId)
    })

    //----{{ Delete Questions Btn }}----//
    $(document).on('click', '[data-deleteReading]', function() {
        let readingId = event.target.getAttribute('data-deletereading');
        $(`#ExamOL #h${readingId}`).slideUp('slow', function () {
            $(this).remove()
        });

    });

    $(document).on('click', '.delete-question', function () {
        $(this).parentsUntil('li').parent().slideUp(1500, function(){
            $(this).remove()
        })
    });

    // Delete Image
    $(document).on('click', '[for-img]', function() {
        let forImage = $(this).attr('for-img');
        let index = parseInt(forImage.substring(4));
        console.log(index)
        if (forImage.startsWith('img_')) {
            // Fade out and remove the image preview if it exists
            let image = $(`#ExamOL #img_${index}`)
            image.slideUp(300, function() {
                $(this).remove();
            });

            // Remove the file selected in the file input
            $('#img' + index).val('');

            // Find and clear the hidden input value
            $('#imgH' + index).val('');

            // Ensure the input is displayed
            $('#img' + index).removeClass('d-none');
        }
        else if (forImage.startsWith('obs_')) {
            // Fade out and remove the image preview if it exists
            $('#obs_' + index).slideUp(300, function() {
                $(this).remove();
            });

            // Remove the file selected in the file input
            $('#obsImg' + index).val('');

            // Find and clear the hidden input value
            $('#obsImgH' + index).val('');

            // Ensure the input is displayed
            $('#obsImg' + index).removeClass('d-none');
        }
    });

    // Put photo when you choose one
    $(document).on('change', 'input[type=file]', function () {
        const fileInput = $(this);
        let mediaElement = ''
        let qIndex= indexFromId(fileInput.attr('id'))
        if ( fileInput.attr('id').startsWith('img') ){
            mediaElement = createMediaElement(fileInput.val(), `img_${qIndex}`, 'question', 'q_img' )
        } else {
            mediaElement = createMediaElement(fileInput.val(), `obs_${qIndex}`, 'question', 'q_img' )
        }
        if (fileInput.next('img, video, audio').length === 0) {
            fileInput.after(mediaElement);
        } else {
            fileInput.next().replaceWith(mediaElement);
        }

        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (event) {
                mediaElement.attr("src", event.target.result);
            };
            reader.readAsDataURL(file);
        }
    });


    // Helper Functions For this Script
    function indexFromId(id) {
        if (id.startsWith('img')) {
            return parseInt( id.substring(3) )
        } else if (id.startsWith('obsImg')) {
            return  parseInt( id.substring(6) )
        }
        return false;
    }

    $(document).on('click', '#end', function(event) {
        let uncheckedNames = [];
        let isFirst = true;

        $('input[type="radio"]').not(':disabled').each(function() {
            let radioName = $(this).attr('name');
            let isChecked = $('input[type="radio"][name="' + radioName + '"]:checked').not(':disabled').length > 0;

            if (!isChecked) {
                event.preventDefault();
                if (uncheckedNames.indexOf(radioName) === -1) {
                    uncheckedNames.push(radioName);
                }
                $('input[type="radio"][name="' + radioName + '"]').css('border-color', 'red');
                if (isFirst) {
                    let firstUnchecked = $('input[type="radio"][name="' + radioName + '"]').first();
                    let offset = firstUnchecked.offset().top;
                    $('html, body').animate({ scrollTop: offset }, 1000); // Scroll with animation
                    firstUnchecked.focus();
                    isFirst = false;
                }
            } else {
                $('input[type="radio"][name="' + radioName + '"]').parent().css('border-color', 'green');
            }
        });

        if (uncheckedNames.length > 0) {
            alert('تأكد من حل جميع الأسئلة');
        }


        //check the max post
        const maxPostSize = 41943040; // 40 Mbyte
        const formData = new FormData(document.querySelector('form')); // Assuming your form has a tag
        let totalSize = 0;

        for (let [key, value] of formData.entries()) {
            if (value instanceof File) {
                totalSize += value.size;
            } else {
                totalSize += new Blob([value]).size;
            }
        }

        if (totalSize > maxPostSize) {
            alert('حجم البيانات المرسلة يتجاوز الحد المسموح به (40 ميجابايت). يرجى تقليل حجم الملفات المرفقة.');
            event.preventDefault();
        }
    });



    //----{{ Import Questions Windows }}----//
    let importBTN = $('#importQuestionsBTN');
    let closeBTN = $('#closeWindow')
    let importMessage = $('#importQuestionsMessage');
    let messageGroup = $('#importQuestionsMessage .message-group');

    // Initially hide both elements
    importMessage.hide();
    messageGroup.hide();

    importBTN.click(function () {
        // Fade in background first
        importMessage.slideDown(500);
        messageGroup.slideDown(500)
    });

    closeBTN.click(function () {
        // close the question
        $('#banksNav a:first-child').click()
        // Fade out small window first
        importMessage.fadeOut(500);
        messageGroup.slideUp(500);
    })

    // Toggle between Banks list and questions
    $(document).on('click', '#listGroup li', function () {
        let clickedElement = $(this)
        $('#listGroup li').slideUp(500 ,function () {
            $('#banksNav a:last-child').text(clickedElement.text())
        });
    })
    $(document).on('click', '#banksNav a:first-child', function () {
        $('#banksNav a:last-child').text('')
        $('#listGroup li').slideDown(500)
        $('#questionsWindow').slideUp(500);
    })

    $(document).on('click','#impotBTN', function() {
        let selectedValues = [];
        $('input[name="selectedQuestions[]"]:checked').each(function () {
            selectedValues.push($(this).val());
        });

        // ajax request to send the selectedValue and return the questions DOM
        $.ajax({
            url: asset('api/copyQuestion/') + examId,
            type: 'POST',
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
                "Authorization": "bearer token",
                "accept": "application/json",
            },
            data: {
                selectedValues: selectedValues
            },
            success: function (data) {
                if (data.length >= 1) {
                    for(let i = 0; i <data.length ; i++) {
                        if (data[i].type === questionTypes['choice']) {
                            generateChoice(qCounter++, examOL, -1, lang, data[i]);
                        } else if (data[i].type === questionTypes['trueOrFalse']) {
                            generateTrueOrFalseQuestion(qCounter++, examOL, -1,lang, data[i]);
                        } else if (data[i].type === questionTypes['reading']) {
                            GenerateReading(qCounter++,examOL ,lang ,data[i] );
                        }
                    }
                }
            }
        });


        closeBTN.click()
    })


});










