import { getCookie } from '../models/helper.js'

$(document).ready(function () {
    "use strict"


    // Set the default language cookie if not present
    if (!getCookie('lang')) {
        let htmlLang = $('html').prop('lang');
        document.cookie = `lang=${htmlLang}; path=/; max-age=31536000`;
    }

    // GSAP animations for initial load
    gsap.from('li', { x: 50, ease: "bounce.out", stagger: 0.2, duration: 1.5 })
    gsap.from($('section:nth-child(2) > div'), {
        y: 50,
        opacity: .5,
        stagger: 0.2,
        duration: 1.5
    })

    // Toggle account menu
    $(document).on('click', '.account > div:first-child, .account > div:nth-child(2)', function () {
        $('.account-menu').slideToggle(400)
        $('.ignorance-account > ul').slideUp(400)
    })

    // Language change (Arabic)
    $(document).on('click', '#toAr', function (e) {
        e.preventDefault();
        document.cookie = `lang=ar; path=/; max-age=31536000`;
        $(this).closest('form').submit();
    })

    // Language change (English)
    $(document).on('click', '#toEn', function (e) {
        e.preventDefault();
        document.cookie = `lang=en; path=/; max-age=31536000`;
        $(this).closest('form').submit();
    })

    // Toggle aside menu
    let asideBack = $('.aside-back');
    $(document).on('click', '#menu-btn', function () {
        gsap.fromTo(asideBack, { opacity: 0, display: 'none' }, { opacity: .95, display: 'block' });
        gsap.to($('aside'), { x: 0, duration: 1, ease: "bounce.out" });
    })

    $(document).on('click', '.aside-back, .close-aside', function () {
        gsap.to(asideBack, { opacity: 0, duration: 0.3, onComplete: function () {
                asideBack.css('display', 'none');
            }});
        if ($('html').prop('lang') === 'en') {
            gsap.to($('aside'), { x: -300, duration: 0.3 });
        } else {
            gsap.to($('aside'), { x: 300, duration: 0.3 });
        }
    })

    // Handle the down button for sub-lists
    $(document).on('click', '.down-btn', function () {
        if ($(this).hasClass('rotated')) {
            gsap.to($(this), { rotation: 0, duration: 0.4 })
            $(this).removeClass('rotated')
        } else {
            $(this).addClass('rotated')
            gsap.to($(this), { rotation: 180, duration: 0.4 })
        }
        $(this).parentsUntil('li').parent().find('.sub-list').slideToggle(400)
    })



    $(document).on('click', '.ignorance-account > div', function () {
        if ($(this).children('i').hasClass('rotated')) {
            gsap.to($(this).children('i'), { rotation: 0, duration: 0.4 })
            $(this).removeClass('rotated')
        } else {
            $(this).addClass('rotated')
            gsap.to($(this).children('i'), { rotation: 180, duration: 0.4 })
        }
        $(this).next().slideToggle(400)
    })


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
        if (animate) {
            gsap.from($('section:nth-child(2) > div'), {
                y: 50,
                opacity: 0,
                stagger: 0.2,
                duration: .5
            });
        }
    }

    function toDark(addCookie = true) {
        const body = $('body');
        if (body) {
            body.addClass('dark-mode');
            $('#mode').html('<i class="fa-solid fa-moon fa-xl fa-fw"></i>');
            $('#mode').addClass('moon')
            currentMode = 'dark'; // Update current mode
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
        $('#mode').removeClass('moon')
        $('#mode').html('<i class="fa-solid fa-sun fa-xl fa-fw"></i>')
        currentMode = 'light'; // Update current mode
    }

    $(document).on('click', '#mode', function () {
        toggleMode();
    });

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

// Listen for Livewire navigation events and apply the stored mode
    document.addEventListener('livewire:navigated', function() {
        if (currentMode === 'dark') {
            toDark(false)
        } else {
            toLight(false)
        }
    });


    // --- Ahmed Idea xxx --\\
    $(document).on('click', 'button[type="submit"]' , function(e){
        let action = confirm('هل انت متأكد');
        if (!action) {
            e.preventDefault();
        }
    });

})


