<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Application de gestion disciplinaire</title>
</head>
<body>

    Bonjour {{ $mailData['user']->fname }}  {{ $mailData['user']->lname }}, <br><br>

    <p>Vous avez reçu un nouveau droit sur la plateforme {{ config('app.name') }}</p>

    <ul>
        <li>
            <strong>Nouveau droit: </strong> {{ $mailData['privilege'] }}
            <strong>Entité: </strong> {{ $mailData['entity'] }}
        </li>
    </ul>
    <br>

    <p>
        <a href="{{ url('http://supportrh.bfclimited.com:8070/profil/' . $mailData['user']->id) }}">
            Cliquer ici pour accéder à votre page de profil
        </a>
    </p>
</body>
</html>
