import {getCookie} from "../models/helper.js";
$(document).ready(function() {
    let lang = getCookie('lang');
    // Function to handle the enabling and disabling of fields

    message(true)
    function updateDateFields() {
        const availableDuringPeriodChecked = $('#available_during_period').is(':checked');
        const endDateValue = $('#end_date').val();
        const now = new Date();

        if (availableDuringPeriodChecked) {
            $('#start_date').prop('disabled', false);
            $('#end_date').prop('disabled', false);
            $('label[for="start_date"]').removeClass('text-secondary');
            $('label[for="end_date"]').removeClass('text-secondary');

            // Check if end_date has a value and if it is greater than now  degreeShow_after_end
            if (endDateValue && new Date(endDateValue) > now) {
                $('#degreeShow_after_end').prop('disabled', false);
                $('#degreeShow_after_end').parent().removeClass('text-secondary').tooltip('dispose');
                $('label[for="degreeShow_after_end"]').removeClass('text-secondary');

                message(false)
            } else {
                $('#degreeShow_after_end').prop('disabled', true);
                $('label[for="degreeShow_after_end"]').addClass('text-secondary');
                message(true)
            }
        } else {
            $('#start_date').prop('disabled', true).val(null);
            $('#end_date').prop('disabled', true).val(null);
            $('label[for="start_date"]').addClass('text-secondary');
            $('label[for="end_date"]').addClass('text-secondary');
            $('label[for="degreeShow_after_end"]').addClass('text-secondary');
            $('#degreeShow_after_end').prop('disabled', true);
            $('#degreeShow_after_end').prop('checked', false);
            $('#degreeShow_after_end').parent().addClass('text-secondary').tooltip('dispose');
            message(true)
        }
    }

    // Initial call to set up the correct state of fields and tooltips
    updateDateFields();

    // Event listener for the radio button change event
    $('input[name="availability"]').change(function() {
        updateDateFields();
    });

    // Event listener for the end date change event
    $('#end_date').change(function() {
        updateDateFields();
    });
    function message(show) {
        if (show){
            $('#degreeShow_after_end').tooltip({
                title: lang === 'en' ? 'You can\'t use this option until you set a valid end time.' : 'لا يمكنك استخدام هذا الخيار حتى تقوم بتعيين وقت نهاية صالح.',
                placement: 'top',
                trigger: 'hover'
            });
            $('label[for="degreeShow_after_end"]').tooltip({
                title: lang === 'en' ? 'You can\'t use this option until you set a valid end time.' : 'لا يمكنك استخدام هذا الخيار حتى تقوم بتعيين وقت نهاية صالح.',
                placement: 'top',
                trigger: 'hover'
            });
        }
    }
});
