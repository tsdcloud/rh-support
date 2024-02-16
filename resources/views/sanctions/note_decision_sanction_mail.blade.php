<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Note de décision de sanction</title>
</head>
<body>
    <h1>Note de décision de sanction</h1>
    <h3>Demande d'explication N° {{ $mailData['demande']->numero_demande_explication }}</h3>
    <p><b>Initiateur:</b> {{ $mailData['initiateur']->fname }} {{ $mailData['initiateur']->lname }}</p>

    <p><b>Motif:</b> {{ $mailData['demande']->motif->motif }}</p>
    <br>
    Bonjour {{ $mailData['destinataire']->fname }}  {{ $mailData['destinataire']->lname }}, <br><br>

    <p>
        <a href="{{ url('http://supportrh.bfclimited.com:8070/de/show/' . $mailData['demande']->id) }}">
            Bien vouloir suivre ce lien pour visualiser votre note de décision de sanction.
        </a>
    </p>
</body>
</html>
