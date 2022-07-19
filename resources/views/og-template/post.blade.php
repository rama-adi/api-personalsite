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
            font-size: 24pt;
            position: absolute;
            top:540px;
            left:50px;
            padding: 0;
            margin: 0;
            font-family: 'Inter', 'sans-serif';
            font-weight: bold;
            color:#A855F7;
        }
    </style>
</head>
<body>
<div class="og-img-background">
    <h1 class="og-title">
        {{$post->title}}
    </h1>

    <p class="og-tags">
        {{$tags}}
    </p>
</div>
</body>
</html>
