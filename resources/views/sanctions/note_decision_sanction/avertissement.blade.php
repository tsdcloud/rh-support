<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Note de decision</title>

    <style>
        .page-break {
            page-break-after: always;
        }
        *{
            font-family: 'Century Gothic', 'sans-serif';
        }
    </style>
</head>
<body>

    <h1>Page 1</h1>
    <p>
        {{ $data['value one'] }}
    </p>
    <p>
        {{ $data['value three'] }}
    </p>
    <div class="page-break"></div>
    <h1>Page 2</h1>

</body>
</html>
