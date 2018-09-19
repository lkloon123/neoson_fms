<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>{{ config('app.name') }}</title>

    <link href="/favicon.ico" rel="icon" sizes="16x16">
    <link rel="stylesheet" href="{{ mix('css/vendor.css') }}">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

</head>
<body class="skin-purple sidebar-mini">
<div id="app">
    <app-init></app-init>
</div>

<script src="{{ mix('js/manifest.js')  }}"></script>
<script src="{{ mix('js/vendor.js')  }}"></script>
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
