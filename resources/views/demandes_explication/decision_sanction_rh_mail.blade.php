<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Décision de sanction</title>
</head>
<body>
    <h1>Décision de sanction</h1>
    <h3>Demande d'explication N° {{ $mailData['numero_demande_explication'] }}</h3>
    <p><b>Initiateur:</b> {{ $mailData['emetteur_fname'] }} {{ $mailData['emetteur_lname'] }}</p>
    <p><b>Motif:</b> {{ $mailData['motif'] }}</p>

    <p>
        Bonjour, <br/>
        <ul>
            @foreach ($rh_users as $rh_user)
                <li>{{ $rh_user->fname }} {{ $rh_user->lname }}</li>
            @endforeach
        </ul>
        <br>
    </p>

    <p>
        Suite à la demande d'explication soumise à <b>{{ $mailData['destinataire_fname'] }} {{ $mailData['destinataire_lname'] }}</b>
        dont le motif est ci-dessus précisé, il a été convenu une décision de sanction.
        <br>
        Bien vouloir rédiger une note de décision de sanction à envoyer à l'accusé.
    </p>

    <p>
        {{-- <a href="{{ url('http://supportrh.bfclimited.com:8070/de/show/' . $mailData['demande_explication_id']) }}"> --}}
        <a href="{{ url('https://rh.support.initiativearec.com/de/show/' . $mailData['demande_explication_id']) }}">
            Bien vouloir suivre ce lien pour plus d'informations
        </a>
    </p>
</body>
</html>
