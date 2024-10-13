
import { getCookie } from '../models/helper.js'
$(document).ready(function() {

    $(document).ready(function() {
        $('.toggle-slot').click(function() {
            var $toggleSlot = $(this);

            // Check if the slot already has the 'checked' class
            if ($toggleSlot.hasClass('checked')) {
                // Remove the 'checked' class and revert styles
                $toggleSlot.removeClass('checked');
                $('.toggle-button').css({
                    background: '',
                    'box-shadow': '',
                    transform: '',
                });
                $('.sun-icon-wrapper').css({
                    opacity: '',
                    transform: '',
                });
                $('.moon-icon-wrapper').css({
                    opacity: '',
                    transform: '',
                });
            } else {
                // Add the 'checked' class and apply styles
                $toggleSlot.addClass('checked');
                $('.toggle-button').css({
                    background: '#485367',
                    'box-shadow': 'inset 0px 0px 0px 0.75em white',
                    transform: 'translate(1.75em, 1.75em)',
                });
                $('.sun-icon-wrapper').css({
                    opacity: 0,
                    transform: 'translate(3em, 2em) rotate(0deg)',
                });
                $('.moon-icon-wrapper').css({
                    opacity: 1,
                    transform: 'translate(12em, 2em) rotate(-15deg)',
                });
            }
        });
    });


    /* Light / Dark Mode */
// Handle dark/light mode switch
    let modeBtn = $('#mode')
    let currentMode = getCookie('mode');

    function toggleMode(animate=true) {
        const mode = getCookie('mode');
        if (mode === 'dark') {
            toLight();
        } else {
            toDark();
        }

    }

    function toDark(addCookie = true) {
        const body = $('body');
        if (body) {
            body.addClass('dark-mode');
            currentMode = 'dark';
            $(".tdnn").addClass('day');
            $(".moon").addClass('sun');
            if (addCookie) {
                document.cookie = `mode=dark; path=/; max-age=31536000`;
            }
        }
    }

    function toLight(addCookie = true) {
        $('body').removeClass('dark-mode');
        if (addCookie) {
            document.cookie = `mode=light; path=/; max-age=31536000`;
        }
        currentMode = 'light';
    }

    $(document).on('click', '.tdnn', function () {
        $("body").toggleClass('light');
        $(".moon").toggleClass('sun');
        $(".tdnn").toggleClass('day');
        toggleMode();
    });

    if (currentMode === 'dark') {
        toDark(false)
    }

// Check the saved mode in cookies when the page loads and apply it
    const mode = getCookie('mode');
    if (mode === 'dark') {
        toDark(false)
    } else {
        toLight()
    }

// Update currentMode before navigation (replace with your Livewire hook)
    function updateCurrentModeBeforeNavigation() {
        currentMode = getCookie('mode');
    }


});
