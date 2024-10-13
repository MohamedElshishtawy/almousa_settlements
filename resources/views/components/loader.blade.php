<style>
    .body {
        margin: 0;
        padding: 0;
    }
    .loading {
        margin: 0;
        padding: 0;
        background: #fff;
        display: grid;
        align-content: center;
        height: 100vh;
        position: fixed;
        width: 100%;
        z-index: 100000000;
        top: 0;
    }

    .container {
    }

    .ball {
        width: 10px;
        height: 10px;
        margin: 10px auto;
        border-radius: 50px;
        background: #000;
    }

    .ball:nth-child(1) {
        background: #000;
        -webkit-animation: right 1s infinite ease-in-out;
        -moz-animation: right 1s infinite ease-in-out;
        animation: right 1s infinite ease-in-out;
    }

    .ball:nth-child(2) {
        -webkit-animation: left 1.1s infinite ease-in-out;
        -moz-animation: left 1.1s infinite ease-in-out;
        animation: left 1.1s infinite ease-in-out;
    }

    .ball:nth-child(3) {

        -webkit-animation: right 1.05s infinite ease-in-out;
        -moz-animation: right 1.05s infinite ease-in-out;
        animation: right 1.05s infinite ease-in-out;
    }

    .ball:nth-child(4) {

        -webkit-animation: left 1.15s infinite ease-in-out;
        -moz-animation: left 1.15s infinite ease-in-out;
        animation: left 1.15s infinite ease-in-out;
    }

    .ball:nth-child(5) {

        -webkit-animation: right 1.1s infinite ease-in-out;
        -moz-animation: right 1.1s infinite ease-in-out;
        animation: right 1.1s infinite ease-in-out;
    }

    .ball:nth-child(6) {

        -webkit-animation: left 1.05s infinite ease-in-out;
        -moz-animation: left 1.05s infinite ease-in-out;
        animation: left 1.05s infinite ease-in-out;
    }

    .ball:nth-child(7) {
        -webkit-animation: right 1s infinite ease-in-out;
        -moz-animation: right 1s infinite ease-in-out;
        animation: right 1s infinite ease-in-out;
    }

    .fade-out {
        opacity: 1; /* Initial opacity (fully visible) */
        transition: opacity 0.5s ease-in-out; /* Transition duration and easing */
    }

    .fade-out.hidden { /* Optional class to hide after fade-out */
        opacity: 0;
        display: none; /* Hide the element completely after fade-out */
    }

    @-webkit-keyframes right {
        0% {
            -webkit-transform: translate(-15px);
        }
        50% {
            -webkit-transform: translate(15px);
        }
        100% {
            -webkit-transform: translate(-15px);
        }
    }

    @-webkit-keyframes left {
        0% {
            -webkit-transform: translate(15px);
        }
        50% {
            -webkit-transform: translate(-15px);
        }
        100% {
            -webkit-transform: translate(15px);
        }
    }

    @-moz-keyframes right {
        0% {
            -moz-transform: translate(-15px);
        }
        50% {
            -moz-transform: translate(15px);
        }
        100% {
            -moz-transform: translate(-15px);
        }
    }

    @-moz-keyframes left {
        0% {
            -moz-transform: translate(15px);
        }
        50% {
            -moz-transform: translate(-15px);
        }
        100% {
            -moz-transform: translate(15px);
        }
    }

    @keyframes right {
        0% {
            transform: translate(-15px);
        }
        50% {
            transform: translate(15px);
        }
        100% {
            transform: translate(-15px);
        }
    }

    @keyframes left {
        0% {
            transform: translate(15px);
        }
        50% {
            transform: translate(-15px);
        }
        100% {
            transform: translate(15px);
        }
    }
</style>

<div class="loading">
    <div class="container">
        <div class="ball"></div>
        <div class="ball"></div>
        <div class="ball"></div>
        <div class="ball"></div>
        <div class="ball"></div>
        <div class="ball"></div>
        <div class="ball"></div>
    </div>
</div>


