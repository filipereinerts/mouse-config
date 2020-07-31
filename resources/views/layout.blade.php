<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" >

        <link rel="manifest" href="./manifest.json">

        <meta name="description" content="Configure color, mode, brightness and dpi for your logitech mouse">
        <meta name="theme-color" content="#01a7e1">

        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="apple-mobile-web-app-title" content="Mouse Configuration">
        <link rel="apple-touch-icon" href="/images/icon-152x152.png">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            .btn-install-app,.btn-install-app:hover {

                position: fixed;
                width: 100%;
                max-width: 500px;
                background-color: #01a7e1;
                color: white;
                font-weight: bold;
                font-size: 20px;
                height: 52px;
                bottom: -60px;
                right: 0px;
                border-radius: 0px;
                transition: bottom 0.5s;

            }

        </style>
    </head>
    <body>

        <div id="app">
            <noscript>
                Nothing Here
            </noscript>
            @yield('content','Nothing Here')
            <button class="btn btn-install-app">
                <i class="fa fa-plus"></i>
                Install App
            </button>
        </div>

        <script src="{{ asset('js/app.js') }}"></script>

    </body>

    <script type="text/javascript">

        let deferredPrompt;

        if ('serviceWorker' in navigator) {

            navigator.serviceWorker.register('/serviceworker.js', {
                scope: '.'
            }).then(function (registration) {
                console.log('Laravel PWA: ServiceWorker registration successful with scope: ', registration.scope);
            }, function (err) {
                console.log('Laravel PWA: ServiceWorker registration failed: ', err);
            });

            window.addEventListener('beforeinstallprompt', e => {
                e.preventDefault();
                console.log(e);
                deferredPrompt = e;
                $('.btn-install-app').css('bottom', '0').click(function(){
                    deferredPrompt.prompt();
                    deferredPrompt.userChoice
                        .then(choiceResult => {
                            if(choiceResult.outcome === 'accepted') {
                                console.log('user accepted A2HS prompt');
                            } else {
                                console.log('user dismissed A2HS prompt');
                            }
                            deferredPrompt = null
                        });
                });
            });

        }

    </script>

</html>
