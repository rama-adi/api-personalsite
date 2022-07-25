<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>opengraph</title>
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <style>
        .og-img-background {
            width: 1200px;
            height: 630px;
            background-image: url("{{asset('img/og-image-template.png')}}");
            position: relative;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', 'sans-serif';
        }

        .og-title {
            font-size: 50pt;
            font-weight: bold;
            position: absolute;
            margin: 0;
            padding: 0;
            top: 300px;
            left: 50px;
            color: #0F172A;
            width: 950px;
            height: 219px;
        }

        .og-tags {
            justify-items: center;
            align-items: center;
            display: flex;
            color: #A855F7;
            font-size: 18pt;
            position: absolute;
            top: 540px;
            left: 50px;
            padding: 5px 20px;
            border-radius: 10px;
            margin: 0;
            font-family: 'Inter', 'sans-serif';
            font-weight: bold;
            background-color: #f2d5ff;
        }
    </style>
</head>
<body>
<div class="og-img-background">
    <h1 class="og-title">
        {!! $post->og_title !!}
    </h1>

    @if($tags)
        <p class="og-tags">
            <svg style="margin-right: 10px; height: 30px; width: 30px;" xmlns="http://www.w3.org/2000/svg"
                 class="h-5 w-5"
                 viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                      d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z"
                      clip-rule="evenodd"/>
            </svg>
            <span>
        {{$tags}}
        </span>
        </p>
    @endif
</div>
</body>
</html>
