<div class="py-2 col-md-12" style="background-image: linear-gradient(to right, #343a40, #3e454c, #343a40 ); ">
    <div class="row text-white">
        <div class="col-md-3">
            <div class="d-flex m-3">
                {{-- <i class="fa-regular fa-circle-user fa-2xl my-1 mx-2 text-white"></i> --}}
                <img src="img/user.png" class="mr-2" alt="" height="45px" width="45px">
                <div class="d-block">
                    <p class="m-0 font-italic" style="font-size: 14px;">Bienvenido</p>
                    <p class="m-0" style="font-size: 18px">{{Session::get('Nombres')}}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 d-flex justify-content-center align-items-center">
            <div class="text-center">
                <h1>{{ $nombreModulo }}</h1>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>