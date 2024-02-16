<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Proposition de sanction</title>
</head>
<body>
    <h1>Proposition de sanction</h1>
    <h3>Demande d'explication N° {{ $mailData['numero_demande_explication'] }}</h3>
    <p><b>Initiateur:</b> {{ $mailData['emetteur_fname'] }} {{ $mailData['emetteur_lname'] }}</p>
    <p><b>Motif:</b> {{ $mailData['motif'] }}</p>
    <p><b>Personnel:</b> {{ $mailData['destinataire_fname'] }}  {{ $mailData['destinataire_lname'] }}</p>
    <p><b>Sanction proposée par :</b> {{ $mailData['proposition_fname'] }} {{ $mailData['proposition_lname'] }}</p>
    <br>

    {{-- <p><a href="{{ url('http://supportrh.bfclimited.com:8070/de/show/' . $mailData['demande_explication_id']) }}">Suivre ce lien pour voir les propositions des sanctions</a></p> --}}
    <p><a href="{{ url('https://rh.support.initiativearec.com/de/show/' . $mailData['demande_explication_id']) }}">Suivre ce lien pour voir les propositions des sanctions</a></p>
</body>
</html>
