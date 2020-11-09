<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Aliyun Sae Laravel Demo</title>

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

            .top-title {
                position: absolute;
                top: 18px;
                text-align: center;
                font-size: 30px;
            }

            .bottom-count {
                position: absolute;
                bottom: 18px;
                text-align: center;
                font-size: 30px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 50px;
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
                margin-left: 200px;
                margin-right: 200px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="top-title">
                Aliyun Sae Demo (laravel)
            </div>

            <div class="content">
                <div class="title m-b-md">
                    {{ $quote }}
                </div>
                <div class="title m-b-md">
                    {{ $quoteInChinese }}
                </div>
            </div>

            <div class="bottom-count">
                <span style="font-size: 60px; font-weight: bolder;">{{ $inspiredVisitors }}</span>
                visitors has been Inspired!
            </div>
        </div>
    </body>
</html>
