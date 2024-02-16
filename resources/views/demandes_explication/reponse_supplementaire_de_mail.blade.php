<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Demande d'explication</title>
</head>
<body>
    <h1>Réponse à la demande d'explication N° {{ $mailData['numero_demande_explication'] }}</h1>
    <p><b>Initiateur:</b> {{ $mailData['emetteur_fname'] }} {{ $mailData['emetteur_lname'] }}</p>

    <p><b>Motif:</b> {{ $mailData['motif'] }}</p>
    <br>

    <p>
        Bonjour

        {{ $mailData['emetteur_fname'] }} {{ $mailData['emetteur_lname'] }},

        <br>

        l'accusé
        {{ $mailData['destinataire_fname'] }}  {{ $mailData['destinataire_lname'] }},
        a repondu à votre sollicitation à recevoir plus d'informations.
        <br><br>
    </p>
    <p>
        {{-- <a href="{{ url('http://supportrh.bfclimited.com:8070/de/show/' . $mailData['demande_explication_id']) }}"> --}}
        <a href="{{ url('https://rh.support.initiativearec.com/de/show/' . $mailData['demande_explication_id']) }}">
            Bien vouloir suivre ce lien pour plus de détails.
        </a>
    </p>
</body>
</html>
