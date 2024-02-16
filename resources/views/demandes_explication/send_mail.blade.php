<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Demande d'explication</title>
</head>
<body>
    <h1>Demande d'explication N° {{ $mailData['numero_demande_explication'] }}</h1>
    <p><b>Initiateur:</b> {{ $mailData['emetteur_fname'] }} {{ $mailData['emetteur_lname'] }}</p>
    <p><b>Fonction:</b> {{ $mailData['emetteur_fonction'] }}</p>
    <p><b>Grade:</b> {{ $mailData['emetteur_grade'] }}</p>
    <p><b>Motif:</b> {{ $mailData['motif'] }}</p>
    <br>
    Bonjour {{ $mailData['destinataire_fname'] }}  {{ $mailData['destinataire_lname'] }}, <br><br>

    Une demande d'explication vous a été adressée.
    <p>
        {{-- <a href="{{ url('http://supportrh.bfclimited.com:8070/de/show/' . $mailData['demande_explication_id']) }}"> --}}
        <a href="{{ url('https://rh.support.initiativearec.com/de/show/' . $mailData['demande_explication_id']) }}">
            Bien vouloir suivre ce lien pour plus de détails.
        </a>
    </p>
    <p>Délai de réponse: 72h dès réception du présent courriel</p>
</body>
</html>
