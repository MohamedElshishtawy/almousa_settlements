

let timeTaken = timeTakenBack; // Calculate time taken in sec

let alertShown = localStorage.getItem(`ShowAlert1Exam${examNumber}`) ?? false;
let alertShown2 = localStorage.getItem(`ShowAlert2Exam${examNumber}`) ?? false;

function updateTimer() {

    timeTaken++; // Calculate time taken in minutes

    let timeDifference = durationInMinutes - (timeTaken/60); // Calculate remaining time in minutes

    if (timeDifference <= 0) {
        clearInterval(timerInterval);
        if (alertShown) {
            localStorage.removeItem(`ShowAlert1Exam${examNumber}`);
        }
        if (alertShown2) {
            localStorage.removeItem(`ShowAlert2Exam${examNumber}`);
        }
        $('form').submit();
    } else {
        let hours = Math.floor(timeDifference / 60);
        let minutes = Math.floor(timeDifference % 60);
        let seconds = Math.floor((timeDifference * 60) % 60);

        $('#h').text(hours.toString().padStart(2, '0'));
        $('#m').text(minutes.toString().padStart(2, '0'));
        $('#s').text(seconds.toString().padStart(2, '0'));

        let timerElement = $('.time-counter div:nth-child(2)');
        if (timeDifference < 10) {
            timerElement.css('color', 'red');
            if (!alertShown) {
                localStorage.setItem(`ShowAlert1Exam${examNumber}`, true);
                alert('قارب الوقت على الإنتهاء');
                alertShown = true;
            }
        } else if (timeDifference < durationInMinutes / 2) {
            timerElement.css('color', 'orange');
            if (!alertShown2) {
                localStorage.setItem(`ShowAlert2Exam${examNumber}`, true);
                alert('متبقى ' + minutes + ' دقيقة');
                alertShown2 = true;
            }
        } else {
            timerElement.css('color', 'black');
        }
    }
}

var timerInterval = setInterval(function () {
    updateTimer();
}, 1000);

updateTimer();
