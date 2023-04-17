<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ ucfirst($animal->name) }}-{{ $animal->getSpecie->name }}</title>
    <style>
        @font-face {
            font-family: 'Roboto Slab';
            src: url({{ asset('fonts/RobotoSlab-Regular.ttf') }});
            font-weight: normal;
        }

        @font-face {
            font-family: 'Roboto Slab';
            src: url({{ asset('fonts/RobotoSlab-Bold.ttf') }});
            font-weight: bold;
        }

        body {
            font-family: 'Roboto Slab';
        }

        div {
            margin: 7px;
            padding: 7px;
        }

        .main {
            font-size: 18px;
        }

        .about {
            font-size: 11px;
            color: gray;
        }

        .img img {
            height: 200px;
            width: auto;
        }

        .color {
            width: 120px;
            height: 120px;
            line-height: 95px;
            vertical-align: middle;
            text-align: center;
            margin: 12px;
            font-size: 25px;
            text-transform: uppercase;
        }
    </style>

</head>

<body>
    <h1>{{ $animal->name }}</h1>
    <div class="main">Species: {{ $animal->getSpecie->name }}</div>
    <div class="img">
        @if ($animal->photo)
            <img src="{{ $animal->photo }}" alt="{{ $animal->name }}">
        @else
            <img src="{{ asset('img/no-img.png') }}" alt="{{ $animal->name }}">
        @endif
    </div>
    <div class="main">Birth Year: <b>{{ $animal->birth_year }}</b></div>
    <div class="main">Manager: {{ $animal->getManager->name }} {{ $animal->getManager->surname }}</div>
    <div class="about">
        <h2>Animal Book:</h2> {!! $animal->animal_book !!}
    </div>
</body>

</html>
