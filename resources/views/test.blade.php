<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div>
        @foreach($docs as $doc)
            <a href=" {{ route('servedoc', ['filename' => $doc->name]) }}" target="_blank">View {{$doc->name}}</a>
        @endforeach
    </div>
</body>

</html>