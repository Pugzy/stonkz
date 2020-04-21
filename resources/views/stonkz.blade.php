<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Stonkz</title>
</head>
<body>
    <h1>Stonkz</h1>
    <small>Last Updated: {{ now()->format('Y-m-d H:i:s') }}, Created by <a href="https://github.com/Pugzy">Pugzy</a></small>
    <ul>
        @foreach($items as $item)
            <li>
                <strong>
                    {{ $item['percentage'] }}%
                </strong>
                (<span>{{ $item['profit'] }}</span> per)
                <a href="">{{ $item['item_name'] }}</a>
                buy <span>{{ $item['buyPrice'] }}</span>
                sell <span>{{ $item['sellPrice'] }}</span>
                (7d <span>{{ $item['sellVolume'] }}</span> instabuys, <span>{{ $item['buyVolume'] }}</span> instasells)
            </li>
        @endforeach
    </ul>
</body>
</html>
