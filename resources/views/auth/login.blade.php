<!-- Session Status -->
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>INSPINIA | Login</title>

    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('font-awesome/css/font-awesome.css')}}">

    <link rel="stylesheet" href="{{asset('css/animate.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/alertify.min.css')}}">
    <link href="{{asset('css/inspinia.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/inspinia.css')}}">

</head>

<body class="gray-bg">
    <div
        style="background: #000; height: 100%; width: 100%; display: flex; justify-content: center; align-items: center;">

        <div class="row" style="height: 98%; width: 98%">
            <div class="col-md-6 side-image d-flex justify-content-center align-items-center">
                <img src="{{asset('img/logotipo.png')}}" alt="#" class="img-lg-inspinia">
                <style>
                    .side-image {
                        background-color: #1ab394;
                    }

                    .row {
                        width: 900px;
                        height: 600px;
                    }
                </style>
            </div>

            <div class="col-md-6 right-form flex-centered white-text" style="background-color: #293846;">
                <div style="width: 80%; max-width: 400px;">
                    <div style="margin: 40px">
                        <h2 class="text-centered"><b>Ingresar a la cuenta</b></h3>
                    </div>
                    <form class="m-t" method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email Address -->
                        <div class="input-field">
                            <label for="text">Nombre de Usuario</label>
                            <x-text-input id="email"
                                class="input focus-lil-rounded focus-linear-black-to-gray white-text"
                                style="transition: 0.5s" type="email" name="email" :value="old('email')" required
                                autofocus autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                        <!-- Password -->
                        <div class="input-field">
                            <label for="password">Contraseña</label>
                            <div class="input-group">
                                <x-text-input id="password" class="input focus-lil-rounded focus-linear-black-to-gray white-text"
                                    style="transition: 0.5s" type="password" name="password" required autocomplete="current-password" />
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword" style="border: none; color:white; padding: 2px 5px; border-radius: 50%">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>


                        <x-primary-button class="form-group btn btn-primary block full-width m-b">
                            {{ __('Ingresar') }}
                        </x-primary-button>

                        @if (Route::has('password.request'))
                        <div class="text-center">
                            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                href="{{ route('password.request') }}"><small>
                                    {{ __('¿Has olvidado tu contraseña?') }}</small>
                            </a>
                        </div>
                        <p class="text-muted text-center"><small>No tienes una cuenta</small></p>
                        @endif


                        <a class="btn btn-primary block full-width m-b" href="{{ route('register') }}">
                            {{ __('Crear Cuenta') }}
                        </a>
                    </form>




                </div>
            </div>
        </div>
    </div>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function (e) {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
    </script>

</body>

</html>
