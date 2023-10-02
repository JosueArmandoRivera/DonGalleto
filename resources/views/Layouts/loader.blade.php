<div class="loader d-none">
    <div class="ring"></div>
    <div class="ring"></div>
    <div class="ring"></div>
    <p class="cargando">Cargando....</p>
</div>

<style>
    @keyframes latir {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.3);
        }

        100% {
            transform: scale(1);
        }
    }

    .cargando {
        color: #fff;
        animation: latir 2s ease-in-out infinite;
    }

    .loader {
        position: fixed;
        z-index: 10040;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        margin: 0;
        background-color: rgba(0, 0, 0, 0.5) !important;
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .ring {
        width: 300px;
        height: 300px;
        border: 0px solid #000;
        border-radius: 50%;
        position: absolute;
    }

    .ring:nth-child(1) {
        border-bottom-width: 8px;
        border-color: rgb(255, 255, 255);
        animation: rotate1 2s linear infinite;
        -webkit-animation: rotate1 2s linear infinite;
    }

    .ring:nth-child(2) {
        border-right-width: 8px;
        border-color: rgb(127, 127, 127);
        animation: rotate2 2s linear infinite;
        -webkit-animation: rotate2 2s linear infinite;
    }

    .ring:nth-child(3) {
        border-top-width: 8px;
        border-color: rgb(0, 0, 0);
        animation: rotate3 2s linear infinite;
        -webkit-animation: rotate3 2s linear infinite;
    }

    .loading {
        color: #ffffff;
        font-size: 1.2rem;
    }

    @keyframes rotate1 {
        0% {
            transform: rotateX(35deg) rotateY(-45deg) rotateZ(0deg);
        }

        100% {
            transform: rotateX(35deg) rotateY(-45deg) rotateZ(360deg);
        }
    }

    @keyframes rotate2 {
        0% {
            transform: rotateX(50deg) rotateY(10deg) rotateZ(0deg);
        }

        100% {
            transform: rotateX(50deg) rotateY(10deg) rotateZ(360deg);
        }
    }

    @keyframes rotate3 {
        0% {
            transform: rotateX(35deg) rotateY(55deg) rotateZ(0deg);
        }

        100% {
            transform: rotateX(35deg) rotateY(55deg) rotateZ(360deg);
        }
    }
</style>























{{-- <div class="loader d-none">
    <div class="hourglassBackground">
        <div class="hourglassContainer">
            <div class="hourglassCurves"></div>
            <div class="hourglassCapTop"></div>
            <div class="hourglassGlassTop"></div>
            <div class="hourglassSand"></div>
            <div class="hourglassSandStream"></div>
            <div class="hourglassCapBottom"></div>
            <div class="hourglassGlass"></div>
        </div>
    </div>
</div>

<style>
    .loader{
        position: fixed;
        z-index: 10040;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        margin: 0;
        background-color: rgba(0, 0, 0, 0.5) !important;
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .hourglassBackground {
        position: relative;
        background-color: #343a40;
        height: 130px;
        width: 130px;
        border-radius: 50%;
        margin: 30px auto;
    }

    .hourglassContainer {
        position: absolute;
        top: 30px;
        left: 40px;
        width: 50px;
        height: 70px;
        -webkit-animation: hourglassRotate 2s ease-in 0s infinite;
        animation: hourglassRotate 2s ease-in 0s infinite;
        transform-style: preserve-3d;
        perspective: 1000px;
    }

    .hourglassContainer div,
    .hourglassContainer div:before,
    .hourglassContainer div:after {
        transform-style: preserve-3d;
    }

    @-webkit-keyframes hourglassRotate {
        0% {
            transform: rotateX(0deg);
        }

        50% {
            transform: rotateX(180deg);
        }

        100% {
            transform: rotateX(180deg);
        }
    }

    @keyframes hourglassRotate {
        0% {
            transform: rotateX(0deg);
        }

        50% {
            transform: rotateX(180deg);
        }

        100% {
            transform: rotateX(180deg);
        }
    }

    .hourglassCapTop {
        top: 0;
    }

    .hourglassCapTop:before {
        top: -25px;
    }

    .hourglassCapTop:after {
        top: -20px;
    }

    .hourglassCapBottom {
        bottom: 0;
    }

    .hourglassCapBottom:before {
        bottom: -25px;
    }

    .hourglassCapBottom:after {
        bottom: -20px;
    }

    .hourglassGlassTop {
        transform: rotateX(90deg);
        position: absolute;
        top: -16px;
        left: 3px;
        border-radius: 50%;
        width: 44px;
        height: 44px;
        background-color: #999999;
    }

    .hourglassGlass {
        perspective: 100px;
        position: absolute;
        top: 32px;
        left: 20px;
        width: 10px;
        height: 6px;
        background-color: #999999;
        opacity: 0.5;
    }

    .hourglassGlass:before,
    .hourglassGlass:after {
        content: '';
        display: block;
        position: absolute;
        background-color: #999999;
        left: -17px;
        width: 44px;
        height: 28px;
    }

    .hourglassGlass:before {
        top: -27px;
        border-radius: 0 0 25px 25px;
    }

    .hourglassGlass:after {
        bottom: -27px;
        border-radius: 25px 25px 0 0;
    }

    .hourglassCurves:before,
    .hourglassCurves:after {
        content: '';
        display: block;
        position: absolute;
        top: 32px;
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background-color: #333;
        animation: hideCurves 2s ease-in 0s infinite;
    }

    .hourglassCurves:before {
        left: 15px;
    }

    .hourglassCurves:after {
        left: 29px;
    }

    @-webkit-keyframes hideCurves {
        0% {
            opacity: 1;
        }

        25% {
            opacity: 0;
        }

        30% {
            opacity: 0;
        }

        40% {
            opacity: 1;
        }

        100% {
            opacity: 1;
        }
    }

    @keyframes hideCurves {
        0% {
            opacity: 1;
        }

        25% {
            opacity: 0;
        }

        30% {
            opacity: 0;
        }

        40% {
            opacity: 1;
        }

        100% {
            opacity: 1;
        }
    }

    .hourglassSandStream:before {
        content: '';
        display: block;
        position: absolute;
        left: 24px;
        width: 3px;
        background-color: white;
        -webkit-animation: sandStream1 2s ease-in 0s infinite;
        animation: sandStream1 2s ease-in 0s infinite;
    }

    .hourglassSandStream:after {
        content: '';
        display: block;
        position: absolute;
        top: 36px;
        left: 19px;
        border-left: 6px solid transparent;
        border-right: 6px solid transparent;
        border-bottom: 6px solid #fff;
        animation: sandStream2 2s ease-in 0s infinite;
    }

    @-webkit-keyframes sandStream1 {
        0% {
            height: 0;
            top: 35px;
        }

        50% {
            height: 0;
            top: 45px;
        }

        60% {
            height: 35px;
            top: 8px;
        }

        85% {
            height: 35px;
            top: 8px;
        }

        100% {
            height: 0;
            top: 8px;
        }
    }

    @keyframes sandStream1 {
        0% {
            height: 0;
            top: 35px;
        }

        50% {
            height: 0;
            top: 45px;
        }

        60% {
            height: 35px;
            top: 8px;
        }

        85% {
            height: 35px;
            top: 8px;
        }

        100% {
            height: 0;
            top: 8px;
        }
    }

    @-webkit-keyframes sandStream2 {
        0% {
            opacity: 0;
        }

        50% {
            opacity: 0;
        }

        51% {
            opacity: 1;
        }

        90% {
            opacity: 1;
        }

        91% {
            opacity: 0;
        }

        100% {
            opacity: 0;
        }
    }

    @keyframes sandStream2 {
        0% {
            opacity: 0;
        }

        50% {
            opacity: 0;
        }

        51% {
            opacity: 1;
        }

        90% {
            opacity: 1;
        }

        91% {
            opacity: 0;
        }

        100% {
            opacity: 0;
        }
    }

    .hourglassSand:before,
    .hourglassSand:after {
        content: '';
        display: block;
        position: absolute;
        left: 6px;
        background-color: white;
        perspective: 500px;
    }

    .hourglassSand:before {
        top: 8px;
        width: 39px;
        border-radius: 3px 3px 30px 30px;
        animation: sandFillup 2s ease-in 0s infinite;
    }

    .hourglassSand:after {
        border-radius: 30px 30px 3px 3px;
        animation: sandDeplete 2s ease-in 0s infinite;
    }

    @-webkit-keyframes sandFillup {
        0% {
            opacity: 0;
            height: 0;
        }

        60% {
            opacity: 1;
            height: 0;
        }

        100% {
            opacity: 1;
            height: 17px;
        }
    }

    @keyframes sandFillup {
        0% {
            opacity: 0;
            height: 0;
        }

        60% {
            opacity: 1;
            height: 0;
        }

        100% {
            opacity: 1;
            height: 17px;
        }
    }

    @-webkit-keyframes sandDeplete {
        0% {
            opacity: 0;
            top: 45px;
            height: 17px;
            width: 38px;
            left: 6px;
        }

        1% {
            opacity: 1;
            top: 45px;
            height: 17px;
            width: 38px;
            left: 6px;
        }

        24% {
            opacity: 1;
            top: 45px;
            height: 17px;
            width: 38px;
            left: 6px;
        }

        25% {
            opacity: 1;
            top: 41px;
            height: 17px;
            width: 38px;
            left: 6px;
        }

        50% {
            opacity: 1;
            top: 41px;
            height: 17px;
            width: 38px;
            left: 6px;
        }

        90% {
            opacity: 1;
            top: 41px;
            height: 0;
            width: 10px;
            left: 20px;
        }
        
    }

    @keyframes sandDeplete {
        0% {
            opacity: 0;
            top: 45px;
            height: 17px;
            width: 38px;
            left: 6px;
        }

        1% {
            opacity: 1;
            top: 45px;
            height: 17px;
            width: 38px;
            left: 6px;
        }

        24% {
            opacity: 1;
            top: 45px;
            height: 17px;
            width: 38px;
            left: 6px;
        }

        25% {
            opacity: 1;
            top: 41px;
            height: 17px;
            width: 38px;
            left: 6px;
        }

        50% {
            opacity: 1;
            top: 41px;
            height: 17px;
            width: 38px;
            left: 6px;
        }

        90% {
            opacity: 1;
            top: 41px;
            height: 0;
            width: 10px;
            left: 20px;
        }
    }
</style> --}}



























{{-- <div class="contenedor">

    <div class="loader"></div>
</div>

<style>
    .contenedor {
        position: fixed;
        z-index: 1040;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        margin: 0;
        background-color: rgba(0, 0, 0, 0.5) !important;
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .loader {
        box-sizing: border-box;
        display: inline-block;
        width: 50px;
        height: 80px;
        border-top: 5px solid #fff;
        border-bottom: 5px solid #fff;
        position: relative;
        background: linear-gradient(#fff 30px, transparent 0) no-repeat;
        background-size: 2px 40px;
        background-position: 50% 0px;
        animation: spinx 3s linear infinite;
    }

    .loader:before,
    .loader:after {
        content: "";
        width: 40px;
        left: 50%;
        height: 35px;
        position: absolute;
        top: 0;
        transform: translatex(-50%);
        background: rgba(255, 255, 255, 0.4);
        border-radius: 0 0 20px 20px;
        background-size: 100% auto;
        background-repeat: no-repeat;
        background-position: 0 0px;
        animation: lqt 3s linear infinite;
    }

    .loader:after {
        top: auto;
        bottom: 0;
        border-radius: 20px 20px 0 0;
        animation: lqb 3s linear infinite;
    }

    @keyframes lqt {

        0%,
        100% {
            background-image: linear-gradient(#fff 40px, transparent 0);
            background-position: 0% 0px;
        }

        50% {
            background-image: linear-gradient(#fff 40px, transparent 0);
            background-position: 0% 40px;
        }

        50.1% {
            background-image: linear-gradient(#fff 40px, transparent 0);
            background-position: 0% -40px;
        }
    }

    @keyframes lqb {
        0% {
            background-image: linear-gradient(#fff 40px, transparent 0);
            background-position: 0 40px;
        }

        100% {
            background-image: linear-gradient(#fff 40px, transparent 0);
            background-position: 0 -40px;
        }
    }

    @keyframes spinx {

        0%,
        49% {
            transform: rotate(0deg);
            background-position: 50% 36px;
        }

        51%,
        98% {
            transform: rotate(180deg);
            background-position: 50% 4px;
        }

        100% {
            transform: rotate(360deg);
            background-position: 50% 36px;
        }
    }
</style> --}}
