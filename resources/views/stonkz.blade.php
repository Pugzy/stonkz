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
    <p>
        Last Updated: <strong><span>{{ now()->format('H:i:s Y-m-d') }}</span></strong>.<br />
        A self hosted version of Minikloon <a href="https://stonks.gg/">stonks.gg</a>.<br />
        Created by <a href="https://github.com/Pugzy">Pugzy</a> source code @ <a href="https://github.com/Pugzy/stonkz">Pugzy/stonkz</a>
    </p>
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
