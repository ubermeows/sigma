<!DOCTYPE html>
<html>
<head>
    <title>Sigma API</title> 
    <meta charset="UTF-8" />
    <link href="/css/app.css" rel="stylesheet">
</style>
</head>
<body>
<div class="console">
    <div class="lines">
        <p class="cpu">Welcome to Sigma API by <a href="http://lamegaforge.fr" >Lamegaforge</a>.</p>
        <br>
        <p class="cpu">- <span class="commands">Robot occurrences</span></p>
        <p class="cpu">Every ten minutes between 17:00 - 01:00</p>
        <p class="cpu">Hourly between 2:00 - 16:00</p>
        <br>
        <p class="cpu">- <span class="commands">Last 10 clips</span></p>
        @foreach($clips as $clip)
            @switch($clip->state->value)
                @case('active')
                <p class="cpu">✓ {{$clip->title}}</p>
                @break
                @case('suspect')
                <p class="unknown">x "{{$clip->title}}" has been tag suspect</p>
                @break
            @endswitch
        @endforeach
    </div>
</div>
</body>
</html>
